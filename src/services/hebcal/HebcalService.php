<?php

namespace jewellclub\services\hebcal;

use jewellclub\model\dto\hebcal\HebcalSingleResponseDto;
use jewellclub\services\amo\ContactService;
use jewellclub\services\BaseService;

/**
 * Service for API hebcal.com br>
 * https://www.hebcal.com/home/219/hebrew-date-converter-rest-api
 */
class HebcalService extends BaseService
{
    /**
     * @var HebcalService|null
     */
    private static ?HebcalService $service = null;

    /**
     * @return HebcalService
     */
    public static function getInstance(): HebcalService
    {
        if (self::$service === null) {
            self::$service = new HebcalService();
        }

        return self::$service;
    }

    public function __construct()
    {
        parent::__construct("HebcalService");
    }

    /**
     * Convert from Gregorian to Hebrew date
     * @param string $date Gregorian date in YYYY-MM-DD format
     * @param bool $gs After sunset on Gregorian date
     * @return HebcalSingleResponseDto|null
     */
    public function convertGregorianToHebrew(string $date, bool $gs = true): ?HebcalSingleResponseDto {
        $url = "https://www.hebcal.com/converter?cfg=json&g2h=1&strict=1&date=$date";
        if (!!$gs) {
            $url = $url . "&gs=on";
        }

        $response = file_get_contents($url);
        if (!!$response) {
            $respObj = new HebcalSingleResponseDto();
            $respObj->parseJson($response);
            return $respObj;
        }

        return null;
    }
}