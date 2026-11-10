<?php

namespace App\Http\Controllers;

use App\Models\Donation;
use App\Support\Pesapal;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Throwable;

class DonationController extends Controller
{
    public function create()
    {
        return view('public.donate');
    }

    public function store(Request $request, Pesapal $pesapal)
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:150'],
            'email' => ['required', 'email', 'max:150'],
            'phone' => ['nullable', 'string', 'max:40'],
            'amount' => ['required', 'numeric', 'min:100'],
            'currency' => ['required', 'in:RWF,USD,EUR,GBP'],
            'purpose' => ['nullable', 'string', 'max:120'],
            'message' => ['nullable', 'string', 'max:1000'],
        ]);

        $currency = strtoupper($data['currency']);
        $originalAmount = (float) $data['amount'];
        $amount = $originalAmount;
        $rate = 1.0;

        if ($currency !== 'RWF') {
            $rate = (float) config('pesapal.fx.'.$currency, 0);
            abort_if($rate <= 0, 422, 'This currency is not supported.');
            $amount = round($originalAmount * $rate, 2);
        }

        $max = (float) config('pesapal.max_donation_rwf', 2_000_000);
        if ($max > 0 && $amount > $max) {
            return back()->withInput()->withErrors(['amount' => 'The maximum donation is '.format_rwf($max).'.']);
        }

        $donation = Donation::create([
            'reference' => 'DON-'.now()->format('Ymd').'-'.strtoupper(Str::random(6)),
            'name' => $data['name'],
            'email' => $data['email'],
            'phone' => $data['phone'] ?? null,
            'amount' => $amount,
            'currency' => 'RWF',
            'original_amount' => $originalAmount,
            'original_currency' => $currency,
            'fx_rate_to_rwf' => $rate,
            'purpose' => $data['purpose'] ?? 'General fund',
            'message' => $data['message'] ?? null,
            'status' => 'PENDING',
        ]);

        if (! $pesapal->enabled()) {
            return redirect()
                ->route('donate.thanks', $donation->reference)
                ->with('info', 'Your donation has been recorded. Online card payments are being configured — the club will contact you to complete it.');
        }

        try {
            $result = $pesapal->submitDonation($donation);

            $donation->update([
                'order_tracking_id' => $result['order_tracking_id'] ?? null,
                'redirect_url' => $result['redirect_url'],
                'gateway_response' => $result['response'] ?? null,
            ]);

            return redirect()->away($result['redirect_url']);
        } catch (Throwable $e) {
            $donation->update(['status' => 'FAILED', 'payment_status' => $e->getMessage()]);
            Log::error('Donation initiation failed', ['reference' => $donation->reference, 'error' => $e->getMessage()]);

            return back()
                ->withInput()
                ->withErrors(['donation' => 'We could not start the payment. Please try again or contact the club directly.']);
        }
    }

    public function callback(Request $request, Pesapal $pesapal)
    {
        $trackingId = (string) ($request->query('OrderTrackingId') ?: $request->query('orderTrackingId'));
        $reference = (string) ($request->query('OrderMerchantReference') ?: $request->query('orderMerchantReference'));

        $donation = Donation::query()
            ->when($reference, fn ($q) => $q->where('reference', $reference))
            ->when(! $reference && $trackingId, fn ($q) => $q->where('order_tracking_id', $trackingId))
            ->first();

        if ($donation && $trackingId) {
            try {
                $status = $pesapal->transactionStatus($trackingId);
                $pesapal->applyStatus($donation, $status);
            } catch (Throwable $e) {
                Log::warning('Donation callback verification failed', ['reference' => $donation->reference, 'error' => $e->getMessage()]);
            }
        }

        if ($donation) {
            return redirect()->route('donate.thanks', $donation->reference);
        }

        return redirect()->route('donate')->with('info', 'Thank you. If you completed a payment, the club will confirm it shortly.');
    }

    public function ipn(Request $request, Pesapal $pesapal)
    {
        $payload = array_merge($request->query(), $request->all());
        $trackingId = (string) ($payload['OrderTrackingId'] ?? $payload['orderTrackingId'] ?? '');

        try {
            if ($trackingId !== '') {
                $status = $pesapal->transactionStatus($trackingId);
                $donation = Donation::where('order_tracking_id', $trackingId)->first();

                if ($donation) {
                    $pesapal->applyStatus($donation, $status);
                }
            }

            return response()->json([
                'orderNotificationType' => 'IPNCHANGE',
                'orderTrackingId' => $trackingId,
                'orderMerchantReference' => $payload['OrderMerchantReference'] ?? $payload['orderMerchantReference'] ?? '',
                'status' => 200,
            ]);
        } catch (Throwable $e) {
            Log::error('Pesapal IPN failed', ['error' => $e->getMessage()]);

            return response()->json([
                'orderNotificationType' => 'IPNCHANGE',
                'orderTrackingId' => $trackingId,
                'status' => 500,
                'message' => 'Unable to process notification.',
            ], 500);
        }
    }

    public function thanks(string $reference)
    {
        $donation = Donation::where('reference', $reference)->firstOrFail();

        return view('public.donation-thanks', compact('donation'));
    }
}
