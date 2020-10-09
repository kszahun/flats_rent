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
        if($this->isDatesAlreadyReserved($flat, $from, $to, $numberOfResidents)) return ['isValid' => false, 'errorMsg' => "Wybrany termin jest juz zarezerwowany"];

        return ['isValid' => true];
    }

    private function isDatesAlreadyReserved(Flat $flat, \DateTime $from, \DateTime $to, int $numberOfResidents)
    {
        $flatReservations = $flat->getReservations();
        if($flatReservations->count() == 0) return false;
        $daysOccupancy = [];
        /** @var Reservation $reservation */
        foreach ($flatReservations as $reservation) {
            $reservationStartDate = $reservation->getStartDate();
            $reservationEndDate = $reservation->getEndDate();

            if(!$reservationStartDate > $to || !$reservationEndDate < $from) {
                $daysOccupancy = $this->createOccupancyDaysArray($reservation, $from, $to, $daysOccupancy);
            }
            $mostOccupiedDay = max($daysOccupancy);

            if($reservationEndDate >= $from && $reservationStartDate < $from && !$this->isEnoughSpace($flat->getMaxNumberOfResidents(), $mostOccupiedDay, $numberOfResidents)) return true;
            if($reservationStartDate <= $to && $reservationEndDate > $to && !$this->isEnoughSpace($flat->getMaxNumberOfResidents(), $mostOccupiedDay, $numberOfResidents)) return true;
            if($reservationStartDate <= $from && $reservationEndDate >= $to && !$this->isEnoughSpace($flat->getMaxNumberOfResidents(), $mostOccupiedDay, $numberOfResidents)) return true;
            if($reservationStartDate >= $from && $reservationEndDate <= $to  && !$this->isEnoughSpace($flat->getMaxNumberOfResidents(), $mostOccupiedDay, $numberOfResidents)) return true;
        }

        return false;
    }

    private function createOccupancyDaysArray(Reservation $reservation,\DateTime $from, \DateTime $to, array $daysOccupancy)
    {
        $startDate = clone $reservation->getStartDate();
        $endDate = $reservation->getEndDate();
        $numberOfResidents = $reservation->getNumberOfResidents();
        while ($startDate <= $endDate) {
           if($startDate >= $from && $startDate <= $to) {
               if(isset($daysOccupancy[$startDate->format("Y-m-d")])) {
                   $daysOccupancy[$startDate->format("Y-m-d")] += $numberOfResidents;
               } else {
                   $daysOccupancy[$startDate->format("Y-m-d")] = $numberOfResidents;
               }
           }
            $startDate->modify('+1 day');
        }

        return $daysOccupancy;
    }

    private function isEnoughSpace(int $maxNumberOfResidents, int $mostOccupiedDay, int $numberOfResidentsFromReservation)
    {
        return $maxNumberOfResidents >= $mostOccupiedDay + $numberOfResidentsFromReservation;
    }
}