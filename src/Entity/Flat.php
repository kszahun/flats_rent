<?php


namespace App\Entity;


class Flat
{
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