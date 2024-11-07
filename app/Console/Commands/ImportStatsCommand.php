<?php

namespace App\Console\Commands;

use App\Models\Campaign;
use App\Models\Stat;
use App\Models\Term;
use Illuminate\Console\Command;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Log;

class ImportStatsCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:import-stats {filename}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Import stats from CSV files';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $filename = $this->argument('filename');
        $path = storage_path($filename);

        if (!file_exists($path)) {
            $this->error("File not found: {$filename}");

            return Command::FAILURE;
        }

        $data = array_map('str_getcsv', file($path));

        $expected_header = ["utm_campaign", "utm_term", "monetization_timestamp", "revenue"];

        foreach ($data as $index => $row) {
            if ($index === 0) {
                if ($expected_header !== $row) {
                    $this->error('Headings mismatch detected!');
                    $this->info('Please ensure that columns are in the sequence of : '.implode(', ', $expected_header));

                    return Command::FAILURE;
                }

                continue;
            }

            [$utm_campaign, $utm_term, $eventTime, $revenue] = $row;

            $utm_term_empty = (empty($utm_term) || strtolower($utm_term) === 'null') ;
            $utm_campaign_empty = (empty($utm_campaign) || strtolower($utm_campaign) === 'null') ;

            // Skip rows without required fields
            if ($utm_term_empty || $utm_campaign_empty) {
                $this->warn('Skipping row => '.($index + 1).'. '.
                    ($utm_term_empty ? 'utm_term has invalid data.' : '').' '.
                    ($utm_campaign_empty ? 'utm_campaign has invalid data.' : ''));

                continue;
            }

            try {
                // Find or create the campaign and term
                $campaign = Campaign::firstOrCreate(['utm_campaign' => $utm_campaign]);
                $term = $utm_term ? Term::firstOrCreate(['utm_term' => $utm_term]) : null;

                // Create the stat entry
                Stat::create([
                    'campaign_id' => $campaign->id,
                    'term_id' => $term->id ?? null,
                    'revenue' => $revenue,
                    'event_time' => Carbon::parse($eventTime)->toDateTimeString()
                ]);
            } catch (\Exception $e) {
                Log::error($e->getMessage());

                $this->error('Something went wrong while importing stats from row => '.($index + 1));
                $this->error('Error Message => '.$e->getMessage());
            }
        }

        $this->info("Data imported successfully from {$filename}");

        return Command::SUCCESS;
    }
}
