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
     * @ORM\OneToMany(targetEntity="Reservation", mappedBy="flat", cascade={"all"})
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

    /**
     * @param string $name
     */
    public function setName(string $name)
    {
        $this->name = $name;
    }

    /**
     * @param float $price
     */
    public function setPrice(float $price)
    {
        $this->price = $price;
    }

    /**
     * @param string $address
     */
    public function setAddress(string $address)
    {
        $this->address = $address;
    }

    /**
     * @param int $maxNumberOfResidents
     */
    public function setMaxNumberOfResidents(int $maxNumberOfResidents)
    {
        $this->maxNumberOfResidents = $maxNumberOfResidents;
    }

    /**
     * @param Reservation $reservation
     */
    public function addReservation(Reservation $reservation)
    {
        $this->reservations->add($reservation);
    }
}