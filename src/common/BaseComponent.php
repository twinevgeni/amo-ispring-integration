<?php

namespace jewellclub\common;

use Monolog\Logger;
use jewellclub\helpers\common\LoggerHelper;

abstract class BaseComponent
{
    protected string $serviceName;

    /** @var Logger */
    protected Logger $logger;

    /**
     * @param string $name имя компонента
     * @param string $logPrefix имя префикса для лог файла
     */
    public function __construct(string $name = LOG_NAME_COMMON, string $logPrefix = LOG_FILE_COMMON)
    {
        $this->serviceName = $name;
        $this->logger = LoggerHelper::getLogger($name, $logPrefix);
    }
}