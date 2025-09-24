<?php

namespace amoispring\services\amo;

use amoispring\helpers\amo\AmoApiHelper;
use amoispring\services\BaseService;

abstract class BaseAmoService extends BaseService
{
    /** @var AmoApiHelper */
    protected AmoApiHelper $amoApiHelper;

    public function __construct($name, $logPrefix = LOG_FILE_COMMON)
    {
        parent::__construct($name, $logPrefix);
        $this->amoApiHelper = AmoApiHelper::getInstance();
    }
}