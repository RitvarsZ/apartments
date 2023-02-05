<?php

namespace App\Console\Commands;

use App\Models\Apartment;
use Illuminate\Console\Command;

class ClearApartments extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'apartments:clear';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Clear apartments older than configured days';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $apartments = Apartment::where('created_at', '<', now()->subDays(config('services.ss.listing_expiry_days')))->delete();

        $this->info('Deleted ' . $apartments->count() . ' apartments');

        return Command::SUCCESS;
    }
}
