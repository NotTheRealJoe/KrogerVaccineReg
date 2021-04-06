<?php
class KrogerRequests {
    protected string $krogerDomain;

    protected const SCHEDULER_SLOTS_BASE_PATH='rx/api/anonymous/scheduler/slots/locationsearch/';
    /** @var string It is unknown what these params are for, but they are what the website uses. */
    protected const SCHEDULER_SLOTS_MAGIC_PARAMS='?appointmentReason=131&appointmentReason=134&appointmentReason=137&appointmentReason=122&appointmentReason=125&appointmentReason=129&benefitCode=null';

    public function __construct(string $krogerDomain) {
        $this->krogerDomain = $krogerDomain;
    }
    
    public function getSchedulerSlots(int $zipCode, DateTime $dateRangeStart, DateTime $dateRangeEnd, int $radiusMiles) {
        $url = static::SCHEDULER_SLOTS_BASE_PATH
        . implode('/', [
            $zipCode,
            $dateRangeStart->format('Y-m-d'),
            $dateRangeEnd->format('Y-m-d'),
            $radiusMiles
        ])
        . static::SCHEDULER_SLOTS_MAGIC_PARAMS;

        return $this->get($url);
    }

    protected function get($path) {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_URL, "https://{$this->krogerDomain}/${path}");
        $response = curl_exec($ch);
        curl_close($ch);
        return $response;
    }
}