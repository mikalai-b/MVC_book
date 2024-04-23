<?php

namespace Entity;

interface EntityInterface
{
    public function getId(): int;

    public function _getTableName(): string;

}