<?php

use Controller\AddressesBookController;

class Router
{
    private AddressesBookController $addressesBookController;
    public function __construct(AddressesBookController $addressesBookController)
    {
        $this->addressesBookController = $addressesBookController;
    }

    public function call(string $path, array $get): ?string
    {

        return match ($path) {
            '/list' => $this->addressesBookController->listAction(),
            '/delete' => $this->addressesBookController->deleteAction($get['id']),
            '/add' => $this->addressesBookController->addAction(),
            '/update' => $this->addressesBookController->updateAction($get['id']),
            default => $this->addressesBookController->homepageAction(),
        };
    }
}