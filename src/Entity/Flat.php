<?php


namespace App\Entity;


use Doctrine\Common\Collections\ArrayCollection;

class Flat
{

    public function __construct(string $name, float $price, string $address, int $maxNumberOfResidents)
    {
        $this->name = $name;
        $this->price = $price;
        $this->address =$address;
        $this->maxNumberOfResidents = $maxNumberOfResidents;
        $this->reservations = new ArrayCollection();
    }

    /**
     * @var string
     */
    private $name;

    /**
     * @var float
     */
    private $price;

    /**
     * @var string
     */
    private $address;

    /**
     * @var int
     */
    private $maxNumberOfResidents;

    /**
     * @var ArrayCollection|Reservation[]
     */
    private $reservations;


}