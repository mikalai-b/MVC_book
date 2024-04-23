<?php

namespace Controller;

use Entity\AddressesBook;
use ORM\AddressesRepository;
use View\Render;

class AddressesBookController
{
    private array $container;

    public function __construct(array $container)
    {
        $this->container = $container;
    }

    public function listAction(): string
    {
        /** @var AddressesRepository $repository */
        $repository = $this->container['AddressesRepository'];
        $records = $repository->findAll();
        /** @var Render $render */
        $render = $this->container['Render'];
        return $render->renderList($records);
    }

    public function homepageAction(): string
    {
        /** @var Render $render */
        $render = $this->container['Render'];
        return $render->renderHomepage();
    }
    public function deleteAction(int $id): void
    {
        /** @var AddressesRepository $repository */
        $repository = $this->container['AddressesRepository'];
        $repository->deleteRecord($id);
        header("Location: /list");
    }

    public function addAction(): string
    {
        // Not good solution. Better make an abstract form binder and use a Request object
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $record = new AddressesBook();
            $record = $this->formBind($record);

            /** @var AddressesRepository $repository */
            $repository = $this->container['AddressesRepository'];
            $repository->addRecord($record);
        }

        /** @var Render $render */
        $render = $this->container['Render'];
        return $render->renderAddForm();
    }

    public function updateAction(int $id): string
    {
        /** @var AddressesRepository $repository */
        $repository = $this->container['AddressesRepository'];
        $record = $repository->findById($id);

        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $record = $this->formBind($record);
            $repository->updateRecord($record);
            header("Location: /list");
        }

        /** @var Render $render */
        $render = $this->container['Render'];
        return $render->renderUpdateForm($record);
    }

    private function formBind(AddressesBook $record): AddressesBook
    {
        $record->setName($_POST['name']);
        $record->setSurname($_POST['surname']);
        $record->setPhone($_POST['phone']);
        $record->setEmail($_POST['email']);
        $record->setAddress($_POST['address']);

        return $record;
    }
}