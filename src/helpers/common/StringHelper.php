<?php

namespace amoispring\helpers\common;

/**
 * StringHelper
 */
class StringHelper
{
    /**
     * @var string
     */
    static public string $EMPTY_STRING = "";

    /**
     * check if string is null or empty
     * @param string|null $value
     * @return bool
     */
    static public function isEmpty(?string $value): bool {
        return $value === null || $value === self::$EMPTY_STRING;
    }

    /**
     * check if string not empty
     * @param string|null $value
     * @return bool
     */
    static public function isNotEmpty(?string $value): bool {
        return !self::isEmpty($value);
    }

    /**
     * Проверить вхождение $needle в $haystack
     * @param string $haystack
     * @param string $needle
     * @param bool $caseSensitive чувствительность к регистру
     * @return bool
     */
    static public function contains(string $haystack, string $needle, bool $caseSensitive = true): bool {
        if ($caseSensitive) {
            return strpos($haystack, $needle) !== false;
        } else {
            return stripos($haystack, $needle) !== false;
        }
    }

    /**
     * Проверить вхождение $needle в $haystack используя ext-mbstring
     * @param string $haystack
     * @param string $needle
     * @param bool $caseSensitive чувствительность к регистру
     * @return bool
     */
    static public function mbContains(string $haystack, string $needle, bool $caseSensitive = true): bool {
        if ($caseSensitive) {
            return mb_strpos($haystack, $needle) !== false;
        } else {
            return mb_stripos($haystack, $needle) !== false;
        }
    }
}