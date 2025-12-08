<?php

namespace App\Console\Commands;

use App\Jobs\GenerateSitemapJob;
use App\Services\SitemapGenerator;
use Illuminate\Console\Command;

class GenerateSitemap extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'sitemap:generate {--queue : Run the sitemap generation in the queue}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate XML sitemaps for all content';

    /**
     * Execute the console command.
     */
    public function handle(): int
    {
        if ($this->option('queue')) {
            GenerateSitemapJob::dispatch();
            $this->info('Sitemap generation job dispatched to queue.');
            return self::SUCCESS;
        }

        $this->info('Generating sitemaps...');

        $startTime = microtime(true);

        try {
            $generator = new SitemapGenerator();
            $generator->generate();

            $executionTime = round(microtime(true) - $startTime, 2);

            $this->info("Sitemaps generated successfully in {$executionTime} seconds!");
            $this->table(
                ['Sitemap', 'Path'],
                [
                    ['sitemap.xml', public_path('sitemap.xml')],
                    ['sitemap-static.xml', public_path('sitemaps/sitemap-static.xml')],
                    ['sitemap-categories.xml', public_path('sitemaps/sitemap-categories.xml')],
                    ['sitemap-products.xml', public_path('sitemaps/sitemap-products.xml')],
                    ['sitemap-blogs.xml', public_path('sitemaps/sitemap-blogs.xml')],
                    ['sitemap-brands.xml', public_path('sitemaps/sitemap-brands.xml')],
                    ['sitemap-pages.xml', public_path('sitemaps/sitemap-pages.xml')],
                ]
            );

            return self::SUCCESS;
        } catch (\Exception $e) {
            $this->error('Failed to generate sitemaps: ' . $e->getMessage());
            return self::FAILURE;
        }
    }
}
