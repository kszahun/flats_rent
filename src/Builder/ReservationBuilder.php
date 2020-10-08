<?php


namespace App\Builder;


use App\Entity\Flat;
use App\Entity\Reservation;

class ReservationBuilder
{
    public function buildReservation(Flat $flat, int $numberOfResidents, \DateTime $start, \DateTime $end, float $cost)
    {
        $reservation = new Reservation($start, $end, $numberOfResidents, $cost);
        $reservation->setFlat($flat);
        $flat->addReservation($reservation);

        return $reservation;
    }
}