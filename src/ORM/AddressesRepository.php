<?php

namespace ORM;

use Entity\AddressesBook;

class AddressesRepository
{
    private DBProviderInterface $BDProvider;

    public function __construct(DBProviderInterface $BDProvider)
    {
        $this->BDProvider = $BDProvider;
        $BDProvider->setReflectionClass(new \ReflectionClass(new AddressesBook(0)));
    }

    public function addRecord(AddressesBook $record): void
    {
        $this->BDProvider->add($record);
    }

    public function deleteRecord(int $id): void
    {
        $this->BDProvider->delete(AddressesBook::_TABLE_NAME, $id);
    }

    public function updateRecord(AddressesBook $record): void
    {
        $this->BDProvider->update($record);
    }

    public function findAll(): array
    {
        return $this->BDProvider->findAll(AddressesBook::_TABLE_NAME, AddressesBook::class);
    }

    public function findById(int $id): AddressesBook
    {
        return $this->BDProvider->find(AddressesBook::_TABLE_NAME, $id);
    }

}