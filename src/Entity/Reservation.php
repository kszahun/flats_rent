<?php


namespace App\Entity;


class Reservation
{
    public function __construct(\DateTime $startDate, \DateTime $endDate, int $numberOfResidents, float $cost)
    {
        $this->startDate = $startDate;
        $this->endDate = $endDate;
        $this->numberOfResidents = $numberOfResidents;
        $this->cost = $cost;
    }

    /**
     * @var \DateTime
     */
    private $startDate;

    /**
     * @var \DateTime
     */
    private $endDate;

    /**
     * @var int
     */
    private $numberOfResidents;

    /**
     * @var float
     */
    private $cost;
}