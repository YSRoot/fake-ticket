<?php

namespace App;

use Illuminate\Support\Facades\File;

final class Airports
{
    private static array $airports = [];
    private static array $options = [];

    public static function airports(): array
    {
        if (!empty(self::$airports)) {
            return self::$airports;
        }

        return self::loadAirports();
    }

    public static function options(): array
    {
        if (!empty(self::$options)) {
            return self::$options;
        }

        return self::loadOptions();
    }

    public static function byIata(string $iata): array
    {
        return self::airports()[$iata] ?? [];
    }

    private static function loadAirports(): array
    {
        $path = base_path('vendor/mwgg/airports/airports.json');
        $json = File::get($path);
        $data = json_decode($json, true, flags: JSON_THROW_ON_ERROR);

        return self::$airports = collect($data)
            ->filter(fn($item) => !empty($item['iata']))
            ->values()
            ->keyBy('iata')
            ->toArray();
    }

    private static function loadOptions(): array
    {
        if (empty(self::$airports)) {
            self::loadAirports();
        }

        return self::$options = collect(self::$airports)
            ->mapWithKeys(function ($item) {

                $code = $item['iata']; // IATA code (то, что нам нужно)
                $city = $item['city'] ?: $item['name']; // если city отсутствует — название аэропорта
                $country = $item['country'];

                $label = "{$city} ({$code})";

                return [$code => $label];
            })
            ->toArray();
    }
}
