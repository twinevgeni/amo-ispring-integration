<?php

namespace amoispring\services\amo;

use AmoCRM\Filters\LeadsFilter;
use AmoCRM\Models\LeadModel;
use Exception;

/**
 * LeadService
 */
class LeadService extends BaseAmoService
{
    /**
     * @var LeadService|null
     */
    private static ?LeadService $service = null;

    /**
     * @return LeadService
     */
    public static function getInstance(): LeadService
    {
        if (self::$service === null) {
            self::$service = new LeadService();
        }

        return self::$service;
    }

    /**
     * @var CustomFieldsService
     */
    private CustomFieldsService $customFieldsService;

    public function __construct()
    {
        parent::__construct("LeadService");
        $this->customFieldsService = CustomFieldsService::getInstance();
    }

    /**
     * @param string|int $id
     * @return LeadModel|null
     */
    public function getLeadById($id): ?LeadModel
    {
        $this->logger->info("loadLeadById | id=$$id");

        try {
            $apiClient = $this->amoApiHelper->getApiClient();
            $filter = new LeadsFilter();
            $filter->setIds([(int)$id]);
            $leads = $apiClient->leads()->get($filter, [LeadModel::CONTACTS, LeadModel::CATALOG_ELEMENTS]);
            $this->logger->info("loadLeadById | leads by filter(id=$id) loaded: " . json_encode($leads->toArray(), JSON_UNESCAPED_UNICODE));
            return $leads->first();
        } catch (Exception $e) {
            $this->logger->error("loadLeadById error | id=$id | error: " . $e->getMessage());
        }

        return null;
    }
}