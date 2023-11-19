<?php

namespace App\Dto;

class UserDTO
{
    public string $name;

    public function __construct(string $name, string $password, string $email)
    {
        $this->name = $nome;
        $this->password = $password;
        $this->email = $email;
    }

    public function toArray() : array
    {
        return [
            'nome' => $this->names,
            'password' => $this->password,
            'email' => $this->email,
        ];
    }
}
