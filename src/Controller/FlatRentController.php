<?php


namespace App\Controller;


use App\Entity\Flat;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class FlatRentController extends AbstractController
{

    /**
     * @Route("/")
     */
    public function flatList()
    {
        $flats = $this->generateNumberOfFlats(4);
        return $this->render('flatRent/index.html.twig', [
            "flats" => $flats
        ]);
    }

    /**
     * @param int $number
     * @return array
     */
    private function generateNumberOfFlats(int $number)
    {
        $result = [];
        for ($i = 1; $i <= $number; $i++) {
            $result[] = new Flat('name', 9.8, 'adres', 12);
        }

        return $result;
    }

}