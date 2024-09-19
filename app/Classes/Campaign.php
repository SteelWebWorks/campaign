<?php declare(strict_types=1);

namespace App\Classes;

use App\Entities\Entity;
use Carbon\Carbon;
use Doctrine\Common\Collections\ArrayCollection;

class Campaign
{

    protected string $id;
    public string $name;
    public Carbon $start;

    public Carbon $end;

    public ArrayCollection $entities;

    /**
     * @param string $name
     * @param Carbon $start
     * @param Carbon $end
     */
    public function __construct(string $name, Carbon $start, Carbon $end)
    {
        $this->id = uniqid();
        $this->name = $name;
        $this->start = $start;
        $this->end = $end;
        $this->entities = new ArrayCollection();
    }

    public function addEntity(Entity $entity): void
    {
        $this->entities->add($entity);
    }

    public function getId(): string
    {
        return $this->id;
    }

    public function __toString(): string
    {
        return $this->name . " starts at: " . $this->start->format('Y-m-d H:i') . " ends at: " . $this->end->format('Y-m-d H:i');
    }

}