<?php

namespace App\Entities;

abstract class Entity
{
    protected string $id;

    public function __construct()
    {
        $this->id = uniqid(); // Representing the DB id
    }

}