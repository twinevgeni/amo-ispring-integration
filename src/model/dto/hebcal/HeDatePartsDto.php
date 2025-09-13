<?php

namespace jewellclub\model\dto\hebcal;

use jewellclub\model\dto\BaseDto;

class HeDatePartsDto extends BaseDto
{
    /**
     * @var string|null
     */
    public ?string $y;

    /**
     * @var string|null
     */
    public ?string $m;

    /**
     * @var string|null
     */
    public ?string $d;

    /**
     * Прочитать объект из json массива после json_decode
     * @param array $json
     * @return void
     */
    public function parseJsonArray(array $json): void {
        if (!!$json) {
            $this->y = $json['y'] ?? null;
            $this->m = $json['m'] ?? null;
            $this->d = $json['d'] ?? null;
        }
    }
}