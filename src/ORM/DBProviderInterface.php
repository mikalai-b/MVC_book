<?php


namespace ORM;


use Entity\EntityInterface;

interface DBProviderInterface
{
    public function add(EntityInterface $entity): void;
    public function delete(string $tableName, int $id): void;
    public function update(EntityInterface $entity): void;
    public function findAll(string $tableName): array;
    public function find(string $tableName, int $id): EntityInterface;


}