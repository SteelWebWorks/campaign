<?php declare(strict_types=1);

namespace App\Entities;

use App\Entities\Entity;

class BlogEntity extends Entity
{
    public string $title;
    public string $body;

    public function __construct(string $title, string $body)
    {
        $this->title = $title;
        $this->body = $body;
        parent::__construct();
    }

}