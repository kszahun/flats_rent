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

    /**
     * @return \DateTime
     */
    public function getStartDate()
    {
        return $this->startDate;
    }

    /**
     * @return \DateTime
     */
    public function getEndDate()
    {
        return $this->endDate;
    }

    /**
     * @return int
     */
    public function getNumberOfResidents()
    {
        return $this->numberOfResidents;
    }

    /**
     * @return float
     */
    public function getCost()
    {
        return $this->cost;
    }


}