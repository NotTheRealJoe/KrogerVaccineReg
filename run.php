<?php

// ====== Config ======

// Domain of your Kroger store (e.g. 'www.kroger.com' or 'www.kingsoopers.com').
// It is unknown whether all brands use 'www'. Just copy it as it is in the browser.
const KROGER_DOMAIN = 'www.kingsoopers.com';

// ZIP Code
const ZIP_CODE = '80202';

// Radius to search in miles. Maximum seems to be 20 - any number over does not return any additional results.
const RADIUS = 20;

// First date to search for appointments on (YYYY-MM-DD or other DateTime compatible format)
const DATE_RANGE_START = '2021-04-02';

// Last date to search for appointments on (YYYY-MM-DD or other DateTime compatible format)
const DATE_RANGE_END = '2021-04-12';

// ====== End Config ======



function __autoload(string $className): void {
    require_once(__DIR__ . '/include/' . $className . '.php');
}
$krogerRequests = new KrogerRequests('www.kingsoopers.com');
$response = $krogerRequests->getSchedulerSlots(ZIP_CODE, new DateTime(DATE_RANGE_START), new DateTime(DATE_RANGE_END), RADIUS);

$locations = array_map(fn ($jsonObj) => KrogerLocation::fromJSON($jsonObj), json_decode($response));
echo 'Search found ' . count($locations) . ' locations.' . PHP_EOL;

$availableLocations = array_filter($locations, fn ($location) => $location->getAvailableSlotCount() > 0);

if (count($availableLocations) > 0) {
    array_walk($availableLocations, function ($availableLocation) {
        echo $availableLocation->getAvailableSlotCount() . ' slots available at ' . $availableLocation->getAddress() . ', ' . $availableLocation->getCity() . '!' . PHP_EOL;
    });
} else {
    echo 'No locations have slots open at this time :/' . PHP_EOL;
}