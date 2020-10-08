<?php


namespace App\Builder;


use App\Entity\Flat;

class FlatBuilder
{
    public function buildFlat(int $number)
    {
        return new Flat('name'.$number, rand(10,100), 'ul. Polna5/'.$number, rand(1,10));
    }

    public function buildMultipleFlats($numberOfFlats)
    {
        $result = [];
        for ($i = 1; $i <= $numberOfFlats; $i++) {
            $result[] = $this->buildFlat($i);
        }

        return $result;
    }
}