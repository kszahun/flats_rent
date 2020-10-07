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
     * @var Reservation[]
     */
    private $Reservations;


}