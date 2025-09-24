<?php

namespace amoispring\services\amo;

use AmoCRM\Collections\CustomFieldsValuesCollection;
use AmoCRM\Models\CustomFieldsValues\BaseCustomFieldValuesModel;
use AmoCRM\Models\CustomFieldsValues\TextCustomFieldValuesModel;
use AmoCRM\Models\CustomFieldsValues\ValueCollections\TextCustomFieldValueCollection;
use AmoCRM\Models\CustomFieldsValues\ValueModels\TextCustomFieldValueModel;
use Exception;

/**
 * CustomFieldsService
 */
class CustomFieldsService extends BaseAmoService
{
    /**
     * @var CustomFieldsService|null
     */
    private static ?CustomFieldsService $service = null;

    /**
     * @return CustomFieldsService
     */
    public static function getInstance(): CustomFieldsService
    {
        if (self::$service === null) {
            self::$service = new CustomFieldsService();
        }

        return self::$service;
    }

    public function __construct()
    {
        parent::__construct("CustomFieldsService");
    }

    /**
     * @param CustomFieldsValuesCollection|null $customFieldsValuesCollection
     * @param int $id
     * @return BaseCustomFieldValuesModel|null
     */
    public function getCustomFieldById(?CustomFieldsValuesCollection $customFieldsValuesCollection, int $id): ?BaseCustomFieldValuesModel
    {
        $this->logger->info('getCustomFieldById | fieldId: ' . $id);

        try {
            if ($customFieldsValuesCollection !== null &&
                !$customFieldsValuesCollection->isEmpty()) {
                /* @var $customFieldValue BaseCustomFieldValuesModel */
                foreach ($customFieldsValuesCollection as $customFieldValue) {
                    $customFieldId = $customFieldValue->getFieldId();
                    if ($customFieldId == $id) {
                        $this->logger->info('getCustomFieldById | field found: ' . json_encode($customFieldValue->toArray(), JSON_UNESCAPED_UNICODE));
                        return $customFieldValue;
                    }
                }
            }
        } catch (Exception $e) {
            $this->logger->error("getCustomFieldById error | fieldId: $id | error: " . $e->getMessage());
            $this->logger->error($e->getTraceAsString());
        }

        $this->logger->info('getCustomFieldById | field not found');
        return null;
    }

    /**
     * @param CustomFieldsValuesCollection|null $customFieldsValuesCollection
     * @param int $id
     * @return array|bool|int|object|string|null
     */
    public function getCustomFieldFirstValueById(?CustomFieldsValuesCollection $customFieldsValuesCollection, int $id)
    {
        $field = $this->getCustomFieldById($customFieldsValuesCollection, $id);
        if (!!$field) {
            $values = $field->getValues();
            if (!!$values) {
                return $values->first()->getValue();
            }
        }

        return null;
    }

    /**
     * @param CustomFieldsValuesCollection|null $customFieldsValuesCollection
     * @param int $id
     * @return array|null
     */
    public function getCustomFieldValuesById(?CustomFieldsValuesCollection $customFieldsValuesCollection, int $id): ?array
    {
        $field = $this->getCustomFieldById($customFieldsValuesCollection, $id);
        if (!!$field) {
            $values = $field->getValues();
            if (!!$values) {
                $valuesArray = [];
                foreach ($values as $value) {
                    $valuesArray[] = $value->getValue();
                }

                return $valuesArray;
            }
        }

        return null;
    }

    /**
     * Проверить что custom field есть
     * @param CustomFieldsValuesCollection|null $customFieldsValuesCollection
     * @param int $id
     * @return bool
     */
    public function existsCustomFieldById(?CustomFieldsValuesCollection $customFieldsValuesCollection, int $id):bool {
        return $this->getCustomFieldFirstValueById($customFieldsValuesCollection, $id) !== null;
    }

    /**
     * @param CustomFieldsValuesCollection|null $customFieldsValuesCollection
     * @param string $code
     * @return BaseCustomFieldValuesModel|null
     */
    public function getCustomFieldByCode(?CustomFieldsValuesCollection $customFieldsValuesCollection, string $code): ?BaseCustomFieldValuesModel
    {
        $this->logger->info('getCustomFieldById | fieldCode: ' . $code);

        try {
            if ($customFieldsValuesCollection !== null &&
                !$customFieldsValuesCollection->isEmpty()) {
                /* @var $customFieldValue BaseCustomFieldValuesModel */
                foreach ($customFieldsValuesCollection as $customFieldValue) {
                    $customFieldCode = $customFieldValue->getFieldCode();
                    if ($customFieldCode == $code) {
                        $this->logger->info('getCustomFieldById | field found: ' . json_encode($customFieldValue->toArray()));
                        return $customFieldValue;
                    }
                }
            }
        } catch (Exception $e) {
            $this->logger->error("getCustomFieldById error | fieldCode: $code | error: " . $e->getMessage());
            $this->logger->error($e->getTraceAsString());
        }

        $this->logger->info('getCustomFieldById | field not found');
        return null;
    }

    /**
     * @param CustomFieldsValuesCollection|null $customFieldsValuesCollection
     * @param string $code
     * @return array|bool|int|object|string|null
     */
    public function getCustomFieldFirstValueByCode(?CustomFieldsValuesCollection $customFieldsValuesCollection, string $code)
    {
        $field = $this->getCustomFieldByCode($customFieldsValuesCollection, $code);
        if (!!$field) {
            $values = $field->getValues();
            if (!!$values) {
                return $values->first()->getValue();
            }
        }

        return null;
    }

    /**
     * @param CustomFieldsValuesCollection $customFieldsValues
     * @param int|string|null|array|bool $fieldValue
     * @param int $fieldId
     * @return void
     */
    public function addTextCustomField(CustomFieldsValuesCollection $customFieldsValues, $fieldValue, int $fieldId)
    {
        $this->logger->info("addTextCustomField | fieldId: $fieldId | fieldValue: $fieldValue");
        $value = new TextCustomFieldValueModel();
        $value->setValue($fieldValue);
        $values = new TextCustomFieldValuesModel();
        $values->setFieldId($fieldId);
        $values->setValues((new TextCustomFieldValueCollection())->add($value));
        $customFieldsValues->add($values);
    }

    /**
     * @param CustomFieldsValuesCollection $customFieldsValues
     * @param $fieldValue
     * @param int $fieldId
     * @return void
     */
    public function updateTextCustomField(CustomFieldsValuesCollection $customFieldsValues, $fieldValue, int $fieldId) {
        $this->logger->info("updateTextCustomField | fieldId: $fieldId | fieldValue: $fieldValue");
        if (!$this->existsCustomFieldById($customFieldsValues, $fieldId)) {
            $this->logger->info("updateTextCustomField | field not exists | creating new");
            $this->addTextCustomField($customFieldsValues, $fieldValue, $fieldId);
        } else {
            $this->logger->info("updateTextCustomField | field exists | updating value");
            $customField = $this->getCustomFieldById($customFieldsValues, $fieldId);
            if (!!$customField) {
                $customField->getValues()->first()->setValue($fieldValue);
            }
        }
    }
}