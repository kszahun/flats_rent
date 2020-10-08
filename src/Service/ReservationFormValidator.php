<?php


namespace App\Service;


use App\Entity\Flat;

class ReservationFormValidator
{
    /**
     * @param Flat $flat
     * @param int $numberOfResidents
     * @param \DateTime $from
     * @param \DateTime $to
     * @return bool
     */
    public function isValid(Flat $flat, int $numberOfResidents, \DateTime $from, \DateTime $to)
    {
        $now = new \DateTime("now");


        return true;
    }

}