<?php declare(strict_types=1);

namespace App\Entities;

use App\Entities\Entity;

class ProductEntity extends Entity
{
    public string $name;

    public string $description;

    public int $price;

    public function __construct(string $name, string $description, int $price)
    {
        $this->name = $name;
        $this->description = $description;
        $this->price = $price;
        parent::__construct();
    }
}