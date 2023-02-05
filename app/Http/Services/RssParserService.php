<?php

namespace App\Http\Services;

use Carbon\Carbon;
use Feed;
use Illuminate\Support\Collection;

class RssParserService {
    public function parseApartments(Feed $feed): Collection {
        return collect($feed->toArray()['item'])->map(function ($item) use ($feed) {
            return [
                'title' => $item['title'],
                'link' => $item['link'],
                'published_at' => Carbon::parse($item['pubDate']),
                'city' => explode(' : ', $feed->toArray()['title'])[2] ?? '',
            ] + $this->parseDescription($item['description']);
        });
    }

    public function parseDescription(string $description): array {
        $description = str_replace('<b>', '', $description);
        $description = str_replace('</b>', '', $description);

        $district = preg_match('/Pagasts: (.*?)<br>(.*?)<br\/>/', $description, $matches) ? $matches[1] : null;
        $street = $this->parseStreetName($matches[2] ?? null);
        $rooms = preg_match('/Ist.: (.*?)<br\/>m2:/', $description, $matches) ? $matches[1] : null;
        $m2 = preg_match('/m2: (.*?)<br\/>Stāvs:/', $description, $matches) ? $matches[1] : null;
        $floor = preg_match('/Stāvs: (.*?)<br\/>Sērija:/', $description, $matches) ? $matches[1] : null;
        $series = preg_match('/Sērija: (.*?)<br\/>/', $description, $matches) ? $matches[1] : null;
        $price = preg_match('/Cena: (.*?)  (.*?)<br\/>/', $description, $matches) ? $matches[1] : null;
        $price_unit = $matches[2] ?? null;
        $image_thumbnail = preg_match('/src="(.*?)"/', $description, $matches) ? $matches[1] : null;

        return [
            'district' => $district,
            'street' => $street,
            'rooms' => $rooms,
            'm2' => $m2,
            'floor' => $floor,
            'series' => $series,
            'price' => $price,
            'price_unit' => $price_unit,
            'price_per_m2' => $m2 ? round($price / $m2, 2) : null,
            'image_thumbnail' => $image_thumbnail,
        ];
    }

    public function parseStreetName(string $string = null): string {
        if (!$string) {
            return '';
        }

        $string = str_replace(' d. ', ' dambis ', $string);
        $string = str_replace(' pr. ', ' prospekts ', $string);
        $string = str_replace(' bulv. ', ' bulvāris ', $string);
        $string = str_replace(' šķ l. ', ' šķerslīnija ', $string);
        $string = str_replace(' l. ', ' līnija ', $string);
        $string = str_replace(' g. ', ' gatve ', $string);
        $string = str_replace(' al. ', ' aleja ', $string);

        return $string;
    }
}
