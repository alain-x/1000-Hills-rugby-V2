<?php

namespace App\Support;

use App\Models\StoredImage;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use SplFileInfo;

class ImageStringStore
{
    /** @var array<string, string> */
    private array $mimeByExtension = [
        'jpg' => 'image/jpeg',
        'jpeg' => 'image/jpeg',
        'png' => 'image/png',
        'gif' => 'image/gif',
        'webp' => 'image/webp',
        'avif' => 'image/avif',
        'svg' => 'image/svg+xml',
        'bmp' => 'image/bmp',
        'ico' => 'image/x-icon',
    ];

    public function importPublicImages(Command $command, bool $keepFiles = false): void
    {
        ini_set('memory_limit', '512M');
        $this->raisePacketLimit();

        $roots = ['images', 'imagesNews', 'uploads', 'logos_', 'image'];
        $stored = 0;
        $skipped = 0;
        $failed = 0;
        $files = [];

        foreach ($roots as $root) {
            $absolute = public_path($root);

            if (! is_dir($absolute)) {
                continue;
            }

            $iterator = new \RecursiveIteratorIterator(
                new \RecursiveDirectoryIterator($absolute, \FilesystemIterator::SKIP_DOTS)
            );

            /** @var SplFileInfo $file */
            foreach ($iterator as $file) {
                if (! $file->isFile()) {
                    continue;
                }

                $extension = strtolower($file->getExtension());

                if (! isset($this->mimeByExtension[$extension])) {
                    continue;
                }

                $files[] = [$file->getPathname(), $extension];
            }
        }

        $command->line('Found '.count($files).' images.');

        foreach ($files as [$pathname, $extension]) {
            $relative = StoredImage::normalizePath(substr($pathname, strlen(public_path()) + 1));
            $binary = file_get_contents($pathname);

            if ($binary === false || $binary === '') {
                $command->warn('Skipped empty file: '.$relative);
                $skipped++;
                continue;
            }

            try {
                StoredImage::storeBytes($relative, $this->mimeByExtension[$extension], $binary);
                $stored++;

                if (! $keepFiles) {
                    @unlink($pathname);
                }
            } catch (\Throwable $e) {
                $failed++;
                $command->error('Could not store '.$relative.': '.$e->getMessage());
            }

            unset($binary);

            if ($stored > 0 && $stored % 25 === 0) {
                $command->line('Stored '.$stored.' images...');
            }
        }

        $this->removeEmptyDirectories($roots);

        $command->info("Done. Stored {$stored} images as strings. Skipped {$skipped}. Failed {$failed}.");
    }

    public function mimeForExtension(string $extension, ?string $detected = null): ?string
    {
        $extension = strtolower($extension);

        if ($detected && str_starts_with($detected, 'image/')) {
            return $detected === 'image/jpg' ? 'image/jpeg' : $detected;
        }

        return $this->mimeByExtension[$extension] ?? null;
    }

    public function isImageExtension(string $extension): bool
    {
        return isset($this->mimeByExtension[strtolower($extension)]);
    }

    private function raisePacketLimit(): void
    {
        try {
            DB::statement('SET GLOBAL max_allowed_packet = 134217728');
        } catch (\Throwable) {
            // The session may already allow large packets.
        }
    }

    /** @param list<string> $roots */
    private function removeEmptyDirectories(array $roots): void
    {
        foreach ($roots as $root) {
            $absolute = public_path($root);

            if (! is_dir($absolute)) {
                continue;
            }

            $directories = [];
            $iterator = new \RecursiveIteratorIterator(
                new \RecursiveDirectoryIterator($absolute, \FilesystemIterator::SKIP_DOTS),
                \RecursiveIteratorIterator::CHILD_FIRST
            );

            foreach ($iterator as $item) {
                if ($item->isDir()) {
                    $directories[] = $item->getPathname();
                }
            }

            foreach ($directories as $directory) {
                $contents = @scandir($directory);
                if ($contents !== false && count($contents) === 2) {
                    @rmdir($directory);
                }
            }
        }
    }
};
