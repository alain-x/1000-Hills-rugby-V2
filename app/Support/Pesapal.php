<?php

namespace App\Support;

use App\Models\Donation;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\URL;

class Pesapal
{
    public function enabled(): bool
    {
        return (bool) config('pesapal.enabled')
            && filled(config('pesapal.consumer_key'))
            && filled(config('pesapal.consumer_secret'));
    }

    public function baseUrl(): string
    {
        return rtrim((string) config('pesapal.base_url'), '/');
    }

    public function requestToken(): string
    {
        $response = Http::acceptJson()
            ->asJson()
            ->timeout(30)
            ->post($this->baseUrl().'/api/Auth/RequestToken', [
                'consumer_key' => config('pesapal.consumer_key'),
                'consumer_secret' => config('pesapal.consumer_secret'),
            ]);

        $token = $response->json('token');

        if (! is_string($token) || $token === '') {
            Log::error('Pesapal token request failed', ['status' => $response->status(), 'body' => $response->body()]);
            throw new \RuntimeException('Unable to authenticate with Pesapal.');
        }

        Cache::put('pesapal.token', $token, now()->addMinutes(5));

        return $token;
    }

    public function token(): string
    {
        return Cache::get('pesapal.token') ?: $this->requestToken();
    }

    public function registerIpn(): string
    {
        $response = Http::withToken($this->token())
            ->acceptJson()
            ->asJson()
            ->timeout(30)
            ->post($this->baseUrl().'/api/URLSetup/RegisterIPN', [
                'url' => route('donate.ipn'),
                'ipn_notification_type' => 'POST',
            ]);

        $ipnId = $response->json('ipn_id');

        if (! is_string($ipnId) || $ipnId === '') {
            throw new \RuntimeException('Unable to register the Pesapal IPN URL.');
        }

        return $ipnId;
    }

    /**
     * @return array{redirect_url: string, order_tracking_id: string}
     */
    public function submitDonation(Donation $donation): array
    {
        $ipnId = config('pesapal.ipn_id') ?: $this->registerIpn();

        $payload = [
            'id' => $donation->reference,
            'currency' => $donation->currency,
            'amount' => (float) $donation->amount,
            'description' => 'Donation - '.setting('site_name', '1000 Hills Rugby'),
            'callback_url' => route('donate.callback'),
            'notification_id' => $ipnId,
            'branch' => setting('site_name', '1000 Hills Rugby'),
            'billing_address' => [
                'email_address' => $donation->email,
                'phone_number' => (string) $donation->phone,
                'country_code' => 'RW',
                'first_name' => str($donation->name)->before(' ')->toString(),
                'middle_name' => '',
                'last_name' => str($donation->name)->after(' ')->toString() ?: 'Supporter',
                'line_1' => '',
                'line_2' => '',
                'city' => 'Kigali',
                'state' => 'Kigali',
                'postal_code' => '',
                'zip_code' => '',
            ],
        ];

        $response = Http::withToken($this->token())
            ->acceptJson()
            ->asJson()
            ->timeout(30)
            ->post($this->baseUrl().'/api/Transactions/SubmitOrderRequest', $payload);

        $redirect = $response->json('redirect_url');
        $tracking = $response->json('order_tracking_id');

        if (! is_string($redirect) || $redirect === '') {
            Log::error('Pesapal order submission failed', ['status' => $response->status(), 'body' => $response->body()]);
            throw new \RuntimeException('Pesapal rejected the donation request. Please try again.');
        }

        return [
            'redirect_url' => $redirect,
            'order_tracking_id' => (string) $tracking,
            'response' => $response->json(),
        ];
    }

    public function transactionStatus(string $orderTrackingId): array
    {
        $response = Http::withToken($this->token())
            ->acceptJson()
            ->timeout(30)
            ->get($this->baseUrl().'/api/Transactions/GetTransactionStatus', [
                'orderTrackingId' => $orderTrackingId,
            ]);

        if (! $response->successful()) {
            throw new \RuntimeException('Unable to verify the payment status.');
        }

        return $response->json() ?: [];
    }

    public function applyStatus(Donation $donation, array $status): Donation
    {
        $description = (string) ($status['payment_status_description'] ?? '');
        $normalized = strtoupper($description);

        $donation->fill([
            'payment_status' => $description,
            'payment_method' => $status['payment_method'] ?? $donation->payment_method,
            'confirmation_code' => $status['confirmation_code'] ?? $donation->confirmation_code,
            'status' => $normalized !== '' ? $normalized : $donation->status,
            'gateway_response' => $status,
        ]);

        if (in_array($normalized, ['COMPLETED', 'SUCCESS', 'PAID'], true) && ! $donation->paid_at) {
            $donation->paid_at = now();
        }

        $donation->save();

        return $donation;
    }

    public function callbackUrl(): string
    {
        return URL::route('donate.callback');
    }
}
