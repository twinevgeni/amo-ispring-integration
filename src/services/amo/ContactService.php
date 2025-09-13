<?php

namespace jewellclub\services\amo;

use AmoCRM\Filters\ContactsFilter;
use AmoCRM\Models\ContactModel;
use Carbon\Carbon;
use Exception;
use jewellclub\services\hebcal\HebcalService;

/**
 * ContactService
 */
class ContactService extends BaseAmoService
{
    /**
     * @var ContactService|null
     */
    private static ?ContactService $service = null;

    /**
     * @return ContactService
     */
    public static function getInstance(): ContactService
    {
        if (self::$service === null) {
            self::$service = new ContactService();
        }

        return self::$service;
    }

    private CustomFieldsService $customFieldsService;
    private HebcalService $hebcalService;

    public function __construct()
    {
        parent::__construct("ContactService");
        $this->customFieldsService = CustomFieldsService::getInstance();
        $this->hebcalService = HebcalService::getInstance();
    }

    /**
     * @return ContactModel[]
     */
    public function getAllContacts(): array
    {
        $this->logger->info("getAllContacts");
        $contactsResp = [];

        $limit = 250;
        $page = 1;

        while (true) {
            try {
                $this->logger->info("getAllContacts | loading page $page | limit = $limit");
                $apiClient = $this->amoApiHelper->getApiClient();
                $filter = new ContactsFilter();
                $filter->setLimit($limit);
                $filter->setPage($page);

                $contacts = $apiClient->contacts()->get($filter);
                foreach ($contacts as $contact) {
                    $contactsResp[] = $contact;
                }

                $this->logger->info("getAllContacts | laded page $page | count = {$contacts->count()}");
                if ($contacts->count() < $limit) {
                    break;
                }

                $page++;
                sleep(AMO_PAGINATION_WAIT_SEC);
            } catch (Exception $e) {
                $this->logger->error("getAllContacts error load page $page " . $e->getMessage());
            }
        }

        return $contactsResp;
    }

    /**
     * @param string $dateFormatted date in "YYYY-mm-dd" format
     * @return ContactModel[]
     */
    public function getAllContactsByBirthday($date): array
    {
        $contactsBirthday = [];
        foreach ($this->getAllContacts() as $contact) {
            $customFields = $contact->getCustomFieldsValues();
            $birthdayDate = $this->customFieldsService->getCustomFieldFirstValueById($customFields, AMO_BIRTHDAY_FIELD_ID);

            if (!!$birthdayDate && $birthdayDate instanceof Carbon) {
                $birthdayDateFormatted = $birthdayDate->copy()->setTimezone(AMO_TIMEZONE)->format('m-d');
                $dateFormatted = $date->format('m-d');
                if ($birthdayDateFormatted == $dateFormatted) {
                    $contactsBirthday[] = $contact;
                }
            }
        }

        return $contactsBirthday;
    }

    /**
     * @return ContactModel[]
     */
    public function getAllContactsByBirthdayToday(): array
    {
        return $this->getAllContactsByBirthday(Carbon::now(AMO_TIMEZONE));
    }

    /**
     * Получить контакт по id
     * @param $id
     * @return ContactModel|null
     */
    public function getContactById($id): ?ContactModel
    {
        $this->logger->info("getContactById | id=$$id");

        try {
            $apiClient = $this->amoApiHelper->getApiClient();
            $contact = $apiClient->contacts()->getOne($id);
            $this->logger->info("getContactById | contact loaded: " . json_encode($contact->toArray(), JSON_UNESCAPED_UNICODE));
            return $contact;
        } catch (Exception $e) {
            $this->logger->error("getContactById error | id=$id | error: " . $e->getMessage());
        }

        return null;
    }

    /**
     * Обновить возраст конткта и поле "еврейская дата рождения"
     */
    public function updateContactBirthdayData(ContactModel $contact): void
    {
        $needUpdate = false;
        $this->logger->info("updateContactBirthdayData updating contact id: {$contact->getId()} | {$contact->getFirstName()} {$contact->getLastName()}");

        $customFields = $contact->getCustomFieldsValues();
        $birthdayDate = $this->customFieldsService->getCustomFieldFirstValueById($customFields, AMO_BIRTHDAY_FIELD_ID);

        if (!!$birthdayDate && $birthdayDate instanceof Carbon) {
            $birthdayDateFormatted = $birthdayDate->copy()->setTimezone(AMO_TIMEZONE)->format('Y-m-d');
            $hebcal = $this->hebcalService->convertGregorianToHebrew($birthdayDateFormatted);
            $hebrewValue = $this->customFieldsService->getCustomFieldFirstValueById($customFields, AMO_HEBREW_FIELD_ID);
            $hebrewNewValue = "$hebcal->hd-$hebcal->hm-$hebcal->hy";
            if ($hebrewValue == null || $hebrewValue != $hebrewNewValue) {
                $this->customFieldsService->updateTextCustomField($customFields, $hebrewNewValue, AMO_HEBREW_FIELD_ID);
                $needUpdate = true;
            }

            $age = $birthdayDate->age;
            $ageValue = $this->customFieldsService->getCustomFieldFirstValueById($customFields, AMO_AGE_FIELD_ID);
            if ($ageValue == null || $ageValue != $age) {
                $this->customFieldsService->updateTextCustomField($customFields, $age, AMO_AGE_FIELD_ID);
                $needUpdate = true;
            }

            if ($needUpdate) {
                $apiClient = $this->amoApiHelper->getApiClient();
                $apiClient->contacts()->updateOne($contact);
            }
        }
    }

}