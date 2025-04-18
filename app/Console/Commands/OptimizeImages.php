<?php
// app/Console/Commands/OptimizeImages.php
namespace App\Console\Commands;

use Illuminate\Console\Command;
use Intervention\Image\Laravel\Facades\Image;

class OptimizeImages extends Command
{
    protected $signature = 'images:optimize {--batch=10} {--resize=0}';
    protected $description = 'Optimize images in public directory';

    const IMAGE_EXTENSIONS = ['jpg', 'jpeg', 'png'];
    const MAX_WIDTH = 1920;
    const MAX_HEIGHT = 1080;
    const QUALITY = 80;
    const WEBP_QUALITY = 90;

    public function handle()
    {
        ini_set('memory_limit', '512M');

        $path = public_path('images');
        $batchSize = (int) $this->option('batch');
        $shouldResize = (bool) $this->option('resize');

        $this->info("Starting image optimization...");
        $this->info("Batch size: " . $batchSize);
        $this->info("Resize enabled: " . ($shouldResize ? 'Yes' : 'No'));

        $files = collect(\File::allFiles($path));
        $totalFiles = $files->count();
        $processedFiles = 0;

        $files->chunk($batchSize)->each(function ($batch) use (&$processedFiles, $totalFiles, $shouldResize) {
            foreach ($batch as $file) {
                try {
                    // Procéder si la taille de l'image est supérieure à 512 Ko
                    if ($file->getSize() < 512 * 1024) {
                        $this->info("Skipping {$file->getFilename()} (size: " . round($file->getSize() / 1024, 2) . " KB)");
                        continue;
                    }
                    if (in_array(strtolower($file->getExtension()), self::IMAGE_EXTENSIONS)) {
                        $image = Image::read($file);

                        // Redimensionner l'image si l'option est activée
                        if ($shouldResize) {
                            $image->resize(self::MAX_WIDTH, null, function ($constraint) {
                                $constraint->aspectRatio();
                                $constraint->upsize();
                            });
                        }

                        // Sauvegarder en WebP si il n'existe pas un fichier WebP avec le même nom
                        $webpPath = $file->getPath() . '/' . $file->getBasename('.' . $file->getExtension()) . '.webp';
                        if (!file_exists($webpPath)) {
                            $image->save($webpPath, self::WEBP_QUALITY, 'webp');
                        }

                        // Optimiser l'original
                        $image->save($file, self::QUALITY);

                        $processedFiles++;
                        $this->info("[{$processedFiles}/{$totalFiles}] Optimized: " . $file->getFilename());
                    }
                } catch (\Exception $e) {
                    $this->error("Error processing {$file->getFilename()}: {$e->getMessage()}");
                    continue;
                }
            }
            // Libérer la mémoire après chaque lot
            gc_collect_cycles();
        });

        $this->info("\nOptimization completed!");
        $this->info("Total files processed: {$processedFiles}");
    }
}
