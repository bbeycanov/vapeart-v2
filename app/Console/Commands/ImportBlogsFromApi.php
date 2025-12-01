<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Services\Contracts\BlogImportServiceInterface;

class ImportBlogsFromApi extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'blogs:import
                            {url? : The API URL to import from}
                            {--queue : Run the import in the background using queue}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Import blog posts from external API into the database';

    /**
     * Execute the console command.
     */
    public function handle(BlogImportServiceInterface $importService): int
    {
        $url = $this->argument('url') ?? config('services.blog_api.url', 'http://127.0.0.1:8001/api/posts');

        $this->info("Starting blog import from: {$url}");
        $this->newLine();

        if ($this->option('queue')) {
            $this->info('Dispatching import job to queue...');
            \App\Jobs\ImportBlogsJob::dispatch($url);
            $this->info('Job dispatched successfully. Check your queue worker for progress.');
            return self::SUCCESS;
        }

        $progressBar = $this->output->createProgressBar();
        $progressBar->setFormat(' %current% blogs processed [%bar%] %message%');
        $progressBar->start();

        $stats = $importService->importFromApi($url, function ($result, $stats) use ($progressBar) {
            $progressBar->advance();
            $progressBar->setMessage(
                "Imported: {$stats['imported']} | Updated: {$stats['updated']} | Failed: {$stats['failed']}"
            );
        });

        $progressBar->finish();
        $this->newLine(2);

        // Display summary
        $this->info('Import completed!');
        $this->table(
            ['Metric', 'Count'],
            [
                ['New Blogs', $stats['imported']],
                ['Updated Blogs', $stats['updated']],
                ['Failed', $stats['failed']],
                ['Total Processed', $stats['imported'] + $stats['updated'] + $stats['failed']],
            ]
        );

        // Display errors if any
        if (!empty($stats['errors'])) {
            $this->newLine();
            $this->warn('Errors encountered:');
            foreach (array_slice($stats['errors'], 0, 10) as $error) {
                $this->error(" - {$error}");
            }

            if (count($stats['errors']) > 10) {
                $this->warn('... and ' . (count($stats['errors']) - 10) . ' more errors. Check logs for details.');
            }
        }

        return $stats['failed'] > 0 ? self::FAILURE : self::SUCCESS;
    }
}
