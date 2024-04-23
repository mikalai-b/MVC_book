<?php

namespace ORM;

use Entity\EntityInterface;
use Exception;
use ReflectionProperty;

class SQLiteProvider implements DBProviderInterface
{
    private \SQLite3 $db;
    private \ReflectionClass $reflectionClass;

    public function __construct(string $path)
    {
        $this->db = new \SQLite3($path);
    }

    public function __destruct()
    {
        $this->db->close();
    }

    public function setReflectionClass(\ReflectionClass $reflectionClass)
    {
        $this->reflectionClass = $reflectionClass;
    }

    /**
     * @throws Exception
     */
    public function add(EntityInterface $entity): void
    {
        $stmt = $this->db->prepare('INSERT INTO ' . $entity->_getTableName() . ' (' . $this->getFieldsName() . ') VALUES (' . $this->getParametersName() . ')');
        $stmt = $this->bindEntityParams($stmt, $entity);
        $result = $stmt->execute();

        if(!$result) {
            throw new Exception('Invalid request. Record can not be written.');
        }
    }

    /**
     * @throws Exception
     */
    public function delete(string $tableName, int $id): void
    {
        $stmt = $this->db->prepare('DELETE FROM ' . $tableName . ' WHERE id = ' . $id);

        $result = $stmt->execute();

        if(!$result) {
            throw new Exception('Invalid request. Record can not be deleted.');
        }
    }

    /**
     * @throws Exception
     */
    public function update(EntityInterface $entity): void
    {
        $stmt = $this->db->prepare('UPDATE ' . $entity->_getTableName() . ' SET ' . $this->getSettingParameters() . ' WHERE id = ' . $entity->getId());
        $stmt = $this->bindEntityParams($stmt, $entity);

        $result = $stmt->execute();

        if(!$result) {
            throw new Exception('Invalid request. Record can not be deleted.');
        }
    }

    /**
     * @throws Exception
     */
    public function findAll(string $tableName): array
    {
        $query = 'SELECT * FROM ' . $tableName;
        $result = $this->db->query($query);

        if(!$result) {
            throw new Exception('Invalid request. Records can not be gotten.');
        }

        $fields = $this->getFields();

        $objects = [];
        $className = $this->reflectionClass->getName();

        while ($record = $result->fetchArray(SQLITE3_ASSOC) ){
            $object = new $className($record['id']);
            /** @var ReflectionProperty $field */
            foreach ($fields as $field) {
                $method = 'set' . $field->getName();
                $object->$method($record[$field->getName()]);
            }
            $objects[] = $object;
        }

        return $objects;
    }

    /**
     * @throws Exception
     */
    public function find(string $tableName, int $id): EntityInterface
    {
        $query = 'SELECT * FROM ' . $tableName . ' WHERE id = ' . $id;
        $result = $this->db->query($query);

        if(!$result) {
            throw new Exception('Invalid request. Record can not be gotten.');
        }

        $fields = $this->getFields();
        $record = $result->fetchArray(SQLITE3_ASSOC);

        $className = $this->reflectionClass->getName();
        $object = new $className($record['id']);
        /** @var ReflectionProperty $field */
        foreach ($fields as $field) {
            $method = 'set' . $field->getName();
            $object->$method($record[$field->getName()]);
        }

        return $object;
    }

    private function getFields(): array
    {
        $fields = $this->reflectionClass->getProperties();
        return array_filter($fields, function (ReflectionProperty $field) { return $field->getName()[0] != '_'; });
    }

    private function bindEntityParams(\SQLite3Stmt $stmt, EntityInterface $entity): \SQLite3Stmt
    {
        /** @var ReflectionProperty $field */
        foreach ($this->getFields() as $field) {
            $method = 'get' . $field->getName();
            $var = $entity->$method();
            $stmt->bindValue(':' . $field->getName(), $var);
        }

        return $stmt;
    }

    private function getFieldsName(): string
    {
        $fields = $this->getFields();
        $formatted = '';
        /** @var ReflectionProperty $field */
        foreach ($fields as $field) {
            if ($field != end($fields)) {
                $formatted = $formatted .  $field->getName() .', ';
            } else {
                $formatted = $formatted . $field->getName();
            }
        }
        return $formatted;
    }

    private function getParametersName(): string
    {
        $fields = $this->getFields();
        $formatted = '';
        /** @var ReflectionProperty $field */
        foreach ($fields as $field) {
            if ($field != end($fields)) {
                $formatted = $formatted . ':' . $field->getName() .', ';
            } else {
                $formatted = $formatted . ':' . $field->getName();
            }
        }
        return $formatted;
    }

    private function getSettingParameters(): string
    {
        $fields = $this->getFields();
        $str = '';

        /** @var ReflectionProperty $field */
        foreach ($fields as $field) {
            if ($field != end($fields)) {
                $str = $str . $field->getName() . ' = :' . $field->getName() . ', ';
            } else {
                $str = $str . $field->getName() . ' = :' . $field->getName();
            }
        }
        return $str;
    }
}