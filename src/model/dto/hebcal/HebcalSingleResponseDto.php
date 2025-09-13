<?php

namespace jewellclub\model\dto\hebcal;

use jewellclub\model\dto\BaseDto;

class HebcalSingleResponseDto extends BaseDto
{
    /**
     * @var string|null
     */
    public ?string $rawJson;

    public ?int $gy;
    public ?int $gm;
    public ?int $gd;
    public ?bool $afterSunset;
    public ?int $hy;
    public ?string $hm;
    public ?int $hd;
    public ?string $hebrew;
    public ?HeDatePartsDto $heDateParts;

    /**
     * @var string[]|null
     */
    public ?array $events;

    /**
     * YYYY-MM-DD
     * @return string
     */
    public function getGregorianDateStr(): string
    {
        return "$this->gy-$this->gm-$this->gd";
    }

    /**
     * Прочитать объект из json строки
     * @param string|null $json
     * @return void
     */
    public function parseJson(?string $json): void
    {
        $this->rawJson = $json;
        parent::parseJson($json);
    }

    /**
     * Прочитать объект из json массива после json_decode
     * @param array $json
     * @return void
     */
    public function parseJsonArray(array $json): void
    {
        if (!!$json) {
            $this->gy = $json['gy'] ?? null;
            $this->gm = $json['gm'] ?? null;
            $this->gd = $json['gd'] ?? null;
            $this->afterSunset = $json['afterSunset'] ?? false;
            $this->hy = $json['hy'] ?? null;
            $this->hm = $json['hm'] ?? null;
            $this->hd = $json['hd'] ?? null;
            $this->hebrew = $json['hebrew'] ?? null;

            if (isset($json['heDateParts'])) {
                $heDateParts = new HeDatePartsDto();
                $heDateParts->parseJsonArray($json['heDateParts']);
                $this->heDateParts = $heDateParts;
            }

            $this->events = $json['events'] ?? null;
        }
    }
}