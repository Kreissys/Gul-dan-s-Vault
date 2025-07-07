<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;

class TestRawgApi extends Command
{
    protected $signature = 'rawg:test';
    protected $description = 'Test RAWG API connection';

    public function handle()
    {
        $apiKey = env('RAWG_API_KEY');
        
        if (!$apiKey) {
            $this->error('RAWG API key not found in .env file');
            return 1;
        }

        try {
            $response = Http::get('https://api.rawg.io/api/games', [
                'key' => $apiKey,
                'search' => 'test',
                'page_size' => 1
            ]);

            if ($response->successful()) {
                $data = $response->json();
                $this->info('RAWG API connection successful!');
                $this->info('Response: ' . json_encode($data));
                return 0;
            } else {
                $this->error('RAWG API returned error: ' . $response->status());
                $this->error('Error message: ' . $response->body());
                return 1;
            }
        } catch (\Exception $e) {
            $this->error('Error connecting to RAWG API: ' . $e->getMessage());
            return 1;
        }
    }
}
