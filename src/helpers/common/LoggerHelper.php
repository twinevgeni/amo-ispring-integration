<?php

namespace amoispring\helpers\common;

use Monolog\Handler\StreamHandler;
use Monolog\Logger;

/**
 * LoggerHelper
 */
class LoggerHelper
{
    /**
     * @var string
     */
    static public string $NULL_LOG_STRING = "NULL";

    /**
     * @param string $name
     * @param string $filenamePrefix
     * @return Logger
     */
    static public function getLogger(string $name, string $filenamePrefix = LOG_FILE_COMMON): Logger
    {
        $logger = new Logger($name);

        if (LOG_STDOUT_ENABLED) {
            $stdoutStreamHandler = new StreamHandler("php://stdout");
            $logger->pushHandler($stdoutStreamHandler);
        }

        if (LOG_FILE_ENABLED) {
            $fileStreamHandler = new StreamHandler(self::getLogFilePath($filenamePrefix));
            $logger->pushHandler($fileStreamHandler);
        }

        return $logger;
    }

    /**
     * @param string $filenamePrefix
     * @return string
     */
    static private function getLogFileName(string $filenamePrefix): string
    {
        $currentDate = date('Y-m-d');
        return "$filenamePrefix.$currentDate.txt";
    }

    /**
     * @param string $filenamePrefix
     * @return string
     */
    static private function getLogFilePath(string $filenamePrefix): string
    {
        $log = DIR_LOG . DS . self::getLogFileName($filenamePrefix);
        return $log;
    }

    /**
     * @param array|null $arr
     * @return string
     */
    static public function arrayToLogString(?array $arr): string {
        return !isset($arr) ? self::$NULL_LOG_STRING : json_encode($arr);
    }

    /**
     * @param mixed|null $obj
     * @return string
     */
    static public function toLogString($obj): string {
        if (is_null($obj)) {
            return self::$NULL_LOG_STRING;
        }

        if (isset($arr)) {
            return self::arrayToLogString($obj);
        }

        return json_encode($obj);
    }

    /**
     * Очистка старых логов
     * @return void
     */
    static public function cleanUpLogs(string $filenamePrefix = LOG_FILE_COMMON, int $days = 7) {

    }
}