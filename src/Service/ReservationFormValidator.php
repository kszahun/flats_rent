<?php


namespace App\Service;


use App\Entity\Flat;
use App\Entity\Reservation;

class ReservationFormValidator
{
    /**
     * @param Flat $flat
     * @param int $numberOfResidents
     * @param \DateTime $from
     * @param \DateTime $to
     * @return array
     */
    public function isValid(Flat $flat, int $numberOfResidents, \DateTime $from, \DateTime $to)
    {
        $now = new \DateTime("now");
        if($from < $now || $to < $now) return ['isValid' => false, 'errorMsg' => "Podano datę z przeszłośći"];
        if($from > $to) return ['isValid' => false, 'errorMsg' => "Niezgody zakres dat(od>do)"];
        if($flat->getMaxNumberOfResidents() < $numberOfResidents) return ['isValid' => false, 'errorMsg' => "W tym mieszkaniu nie ma tylu miejsc"];
        if($this->isDatesAlreadyReserved($flat, $from, $to)) return ['isValid' => false, 'errorMsg' => "Wybrany termin jest juz zarezerwowany"];

        return ['isValid' => true];
    }

    private function isDatesAlreadyReserved(Flat $flat, \DateTime $from, \DateTime $to)
    {
        $flatReservations = $flat->getReservations();
        if($flatReservations->count() == 0) return false;

        /** @var Reservation $reservation */
        foreach ($flatReservations as $reservation) {
            $reservationStartDate = $reservation->getStartDate();
            $reservationEndDate = $reservation->getEndDate();

            if($reservationEndDate >= $from && $reservationStartDate < $from) return true;
            if($reservationStartDate <= $to && $reservationEndDate > $to) return true;
            if($reservationStartDate <= $from && $reservationEndDate >= $to) return true;
            if($reservationStartDate <= $from && $reservationEndDate >= $to) return true;
        }

        return false;
    }

}