<?php

namespace amoispring\model\dto;

use amoispring\helpers\common\StringHelper;

abstract class BaseDto
{
    /**
     * Преобразовать объект в json строку
     * @return string
     */
    public function toJson(): string {
        return StringHelper::$EMPTY_STRING;
    }

    /**
     * Прочитать объект из json строки
     * @param string|null $json
     * @return void
     */
    public function parseJson(?string $json): void {
        if (StringHelper::isNotEmpty($json)) {
            $this->parseJsonArray(json_decode($json, true));
        }
    }

    /**
     * Прочитать объект из json массива после json_decode
     * @param array $json
     * @return void
     */
    public function parseJsonArray(array $json): void {

    }
}