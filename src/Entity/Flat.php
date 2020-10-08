<?php


namespace App\Entity;


use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=FlatRepository::class)
 */
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
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @var string
     */
    private $name;

    /**
     * @ORM\Column(type="decimal", precision=2)
     * @var float
     */
    private $price;

    /**
     * @ORM\Column(type="string", length=255)
     * @var string
     */
    private $address;

    /**
     * @ORM\Column(type="integer")
     * @var int
     */
    private $maxNumberOfResidents;

    /**
     * @var ArrayCollection|Reservation[]
     */
    private $reservations;

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @return float
     */
    public function getPrice()
    {
        return $this->price;
    }

    /**
     * @return string
     */
    public function getAddress()
    {
        return $this->address;
    }

    /**
     * @return int
     */
    public function getMaxNumberOfResidents()
    {
        return $this->maxNumberOfResidents;
    }

    /**
     * @return Reservation[]|ArrayCollection
     */
    public function getReservations()
    {
        return $this->reservations;
    }


}