<?php

namespace jewellclub\controllers;

use jewellclub\services\amo\ContactService;

class ContactController extends BaseController
{
    /**
     * @var ContactController|null
     */
    private static ?ContactController $controller = null;

    /**
     * @return ContactController
     */
    public static function getInstance(): ContactController
    {
        if (self::$controller === null) {
            self::$controller = new ContactController();
        }

        return self::$controller;
    }

    private ContactService $contactService;

    public function __construct()
    {
        parent::__construct("ContactController");
        $this->contactService = ContactService::getInstance();
    }

    private function _onContactWebhook($data): void
    {
        $this->logger->info('onContactWebhook | processing webhook data');

        if (!!$data) {
            if (count($data) > 0) {
                foreach ($data as $contact) {
                    if (isset($contact['id'])) {
                        $contactId = $contact['id'];
                        $this->logger->info("onContactWebhook | processing webhook data | contactId = $contactId");

                        $contact = $this->contactService->getContactById($contactId);
                        $this->contactService->updateContactBirthdayData($contact);
                    }
                }
            }
        }
    }

    public function onContactWebhook(): void
    {
        $this->logger->info("onContactWebhook call");

        $postDataJson = $this->requestDataHelper->readPostJson();
        $this->logger->info($postDataJson);
        $json = json_decode($postDataJson, true);

        if (!!$json) {
            $contacts = $json['contacts'] ?? null;

            if (!!$contacts) {
                $this->logger->error("onContactWebhook call | contacts record found");

                $dataAdd = $contacts['add'] ?? null;
                $this->_onContactWebhook($dataAdd);

                $dataUpdate = $contacts['update'] ?? null;
                $this->_onContactWebhook($dataUpdate);
            }
        } else {
            $this->logger->error("onContactWebhook call | POST data is empty");
        }
    }
}