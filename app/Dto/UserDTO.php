<?php

namespace App\Dto;

class UserDTO
{
    public string $name;

    public function __construct(string $name, string $email)
    {
        $this->name = $name;
        $this->email = $email;
    }

    public function toArray() : array
    {
        return [
            'name' => $this->name,
            'email' => $this->email,
        ];
    }
}
