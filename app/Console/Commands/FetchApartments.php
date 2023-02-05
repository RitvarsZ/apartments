<?php

namespace App\Console\Commands;

use App\Http\Services\RssParserService;
use App\Models\Apartment;
use Feed;
use Geocoder\Query\GeocodeQuery;
use Illuminate\Console\Command;

class FetchApartments extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'apartments:fetch';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Fetch apartments from RSS feed';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle(RssParserService $service)
    {
        $apartments = $service->parseApartments(Feed::loadRss(config('services.ss.feed')));

        $bar = $this->output->createProgressBar($apartments->count());
        $bar->start();

        $apartments->each(function ($data) use ($bar) {
            $apartment = Apartment::firstOrNew(['link' => $data['link']]);
            $apartment->fill($data);

            // sleep for 1 second to avoid rate limit
            sleep(1);

            $address = implode(', ', [
                $apartment->street,
                $apartment->city,
                'Latvija',
            ]);

            try {
                $coordinates = app('geocoder')->geocodeQuery(
                    GeocodeQuery::create($address)->withLocale('lv')->withLimit(1)
                )->get()->first();

                if (!$coordinates) {
                    $this->error('No coordinates found for address: ' . $address);

                    // fallback to Šmerļa mežs
                    $apartment->latitude = '56.9807';
                    $apartment->longitude = '24.2258';
                } else {
                    $coordinates = $coordinates->getCoordinates();
                    $apartment->latitude = $coordinates->getLatitude();
                    $apartment->longitude = $coordinates->getLongitude();
                }

                $apartment->save();
            } catch (\Exception $e) {
                $this->error($e->getMessage());
            }

            $bar->advance();
        });

        $bar->finish();

        return Command::SUCCESS;
    }
}
