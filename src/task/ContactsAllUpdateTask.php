<?php

namespace jewellclub\task;

use Exception;
use jewellclub\services\amo\ContactService;

class ContactsAllUpdateTask extends BaseTask
{
    private ContactService $contactService;

    public function __construct()
    {
        parent::__construct("ContactsAllUpdateTask");
        $this->contactService = ContactService::getInstance();
    }

    /**
     * @inheritDoc
     */
    public function run(): void
    {
        $maxCountLimiter = 15;
        $countLimiter = 0;

        $this->logger->info('ContactsAllUpdateTask run');
        $contacts = $this->contactService->getAllContacts();
        foreach ($contacts as $contact) {
            try {
                $this->contactService->updateContactBirthdayData($contact);
            } catch (Exception $e) {
                $this->logger->error("ContactsAllUpdateTask error update contact | id: {$contact->getId()} | error: " . $e->getMessage());
                $this->logger->error($e->getTraceAsString());
            }

            $countLimiter++;

            if ($countLimiter >= $maxCountLimiter) {
                $countLimiter = 0;
                sleep(AMO_PAGINATION_WAIT_SEC);
            }
        }
    }

    /**
     * @inheritDoc
     */
    public function getResultRaw()
    {
        return null;
    }
}