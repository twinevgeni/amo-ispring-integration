<?php

namespace jewellclub\controllers;

use amoispring\common\BaseComponent;
use amoispring\helpers\common\RequestDataHelper;

abstract class BaseController extends BaseComponent
{
    /** @var RequestDataHelper */
    protected RequestDataHelper $requestDataHelper;

    public function __construct($name, $logPrefix = LOG_FILE_COMMON)
    {
        parent::__construct($name, $logPrefix);
        $this->requestDataHelper = RequestDataHelper::getInstance();
    }

    protected function logRequest()
    {
        $requestUrl = $this->requestDataHelper->getRequestUrl();
        $requestMethod = $this->requestDataHelper->getRequestMethod();
        $contentType = $this->requestDataHelper->getRequestContentType();
        $getParamsJson = $this->requestDataHelper->readGetJson();
        $postParamsJson = $this->requestDataHelper->readPostJson();

        $this->logger->debug("request received" .
            " | requestMethod: $requestMethod" .
            " | requestUrl: $requestUrl" .
            " | contentType: $contentType" .
            " | requestGetParams: $getParamsJson" .
            " | requestPostParams: $postParamsJson"
        );
    }
}