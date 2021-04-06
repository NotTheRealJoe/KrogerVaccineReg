<?php
class KrogerLocation {
    protected string $name;
    protected string $address;
    protected string $city;
    protected string $state;
    protected string $zip;
    protected float $distance;
    protected array $dates;

    public function __construct(string $name, string $address, string $city, string $state, string $zip, float $distance, array $dates) {
        $this->name = $name;
        $this->address = $address;
        $this->city = $city;
        $this->state = $state;
        $this->zip = $zip;
        $this->distance = $distance;
        $this->dates = $dates;
    }

    public static function fromJSON(stdClass $jsonObject) {
        return new static(
            $jsonObject->facilityDetails->vanityName,
            $jsonObject->facilityDetails->address->address1,
            $jsonObject->facilityDetails->address->city,
            $jsonObject->facilityDetails->address->state,
            $jsonObject->facilityDetails->address->zipCode,
            $jsonObject->facilityDetails->distance,
            $jsonObject->dates
        );
    }

    public function getName(): string {
        return $this->name;
    }

    public function getAddress(): string {
        return $this->address;
    }

    public function getCity(): string {
        return $this->city;
    }

    public function getState(): string {
        return $this->state;
    }

    public function getZip(): string {
        return $this->zip;
    }

    public function getDistance(): float {
        return $this->distance;
    }

    public function getAvailableSlotCount(): int {
        return array_sum(
            array_map(fn ($date) => count($date->slots), $this->dates)
        );
    }
}