<?php

namespace Entity;

class AddressesBook implements EntityInterface
{
    public const _TABLE_NAME = 'addresses_book';
    private int $_id;
    private ?string $name = '';
    private ?string $surname = '';
    private ?string $phone = '';
    private ?string $email = '';
    private ?string $address = '';

    public function __construct(int $id = 0)
    {
        $this->_id = $id;
    }

    /**
     * @return string
     */
    public function _getTableName(): string
    {
        return self::_TABLE_NAME;
    }

    public function getId(): int
    {
        return $this->_id;
    }

    /**
     * @return string|null
     */
    public function getName(): ?string
    {
        return $this->name;
    }

    /**
     * @param string $name
     */
    public function setName(string $name): void
    {
        $this->name = $name;
    }

    /**
     * @return string|null
     */
    public function getSurname(): ?string
    {
        return $this->surname;
    }

    /**
     * @param string $surname
     */
    public function setSurname(string $surname): void
    {
        $this->surname = $surname;
    }

    /**
     * @return string|null
     */
    public function getPhone(): ?string
    {
        return $this->phone;
    }

    /**
     * @param string|null $phone
     */
    public function setPhone(?string $phone): void
    {
        $this->phone = $phone;
    }

    /**
     * @return string|null
     */
    public function getEmail(): ?string
    {
        return $this->email;
    }

    /**
     * @param string|null $email
     */
    public function setEmail(?string $email): void
    {
        $this->email = $email;
    }

    /**
     * @return string|null
     */
    public function getAddress(): ?string
    {
        return $this->address;
    }

    /**
     * @param string|null $address
     */
    public function setAddress(?string $address): void
    {
        $this->address = $address;
    }

}
