<?php


namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ReservationRepository::class)
 */
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
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @var Flat
     * @ORM\ManyToOne(targetEntity="Flat", cascade={"all"})
     */
    private $flat;

    /**
     * @ORM\Column(type="datetime")
     * @var \DateTime
     */
    private $startDate;

    /**
     * @ORM\Column(type="datetime")
     * @var \DateTime
     */
    private $endDate;

    /**
     * @ORM\Column(type="integer")
     * @var int
     */
    private $numberOfResidents;

    /**
     * @ORM\Column(type="decimal", precision=2)
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