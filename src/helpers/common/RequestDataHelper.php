<?php

namespace jewellclub\helpers\common;

use jewellclub\common\BaseComponent;
use jewellclub\model\dto\common\ApiDataType;

/**
 * RequestDataHelper
 */
class RequestDataHelper extends BaseComponent
{
    public const REQUEST_POST = 'POST';

    /** @var RequestDataHelper|null */
    private static ?RequestDataHelper $instance = null;

    /**
     * @return RequestDataHelper
     */
    public static function getInstance(): RequestDataHelper
    {
        if (self::$instance === null) {
            self::$instance = new RequestDataHelper();
        }

        return self::$instance;
    }

    public function __construct()
    {
        parent::__construct("RequestDataHelper");
    }

    /**
     * Получить метод запроса
     * @return string|null
     */
    public function getRequestMethod(): ?string
    {
        return isset($_SERVER['REQUEST_METHOD']) ? (string)$_SERVER['REQUEST_METHOD'] : null;
    }

    /**
     * Проверить что текущий запрос POST
     * @return bool
     */
    public function isPostRequestMethod(): bool
    {
        $requestMethod = $this->getRequestMethod();
        return $requestMethod === self::REQUEST_POST;
    }

    /**
     * Получить Url который был запрошен у сервера
     * @return string|null
     */
    public function getRequestUrl(): ?string
    {
        return isset($_SERVER['REQUEST_URI']) ? (string)$_SERVER['REQUEST_URI'] : null;
    }

    /**
     * @return string|null
     */
    public function getRequestContentType(): ?string
    {
        return isset($_SERVER['CONTENT_TYPE']) ? (string)$_SERVER['CONTENT_TYPE'] : null;
    }

    /**
     * Получить GET параметры
     * @return array
     */
    public function readGet(): array
    {
        return $_GET ?? [];
    }

    /**
     * @return mixed|null
     */
    public function readGetValue($name)
    {
        return !empty($_GET[$name]) ? $_GET[$name] : null;
    }

    /**
     * Получить GET параметры как json строка
     * @return string
     */
    public function readGetJson(): string
    {
        return json_encode($this->readGet());
    }

    /**
     * @param string $name
     * @return string|null
     */
    public function readGetParam(string $name): ?string
    {
        $getParams = $this->readGet();
        return isset($getParams[$name]) ? (string)$getParams[$name] : null;
    }

    /**
     * @return array|null
     */
    public function readPost(): ?array
    {
        return $_POST ?? null;
    }

    /**
     * @return string|null
     */
    public function readPostJson(): ?string
    {
        $post = $this->readPost();
        return $post === null ? null : json_encode($post);
    }

    /**
     * Запрашиваемый формат данных
     * @return string
     */
    public function readFormat():string {
        $formatGetParam = $this->readGetValue(ApiDataType::GEt_PARAM);
        $this->logger->info("readFormat | formatGetParam = $formatGetParam");
        if ($formatGetParam != null) {
            $format = strtolower($formatGetParam);
            if ($format == ApiDataType::XLS) {
                return ApiDataType::XLS;
            }
        }

        return ApiDataType::JSON;
    }

    /**
     * Нужно вернуть в формате xls
     * @return bool
     */
    public function formatIsXls():bool {
        $format = $this->readFormat();
        return $format == ApiDataType::XLS;
    }
}