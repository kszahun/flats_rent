<?php


namespace App\Controller;


use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class FlatRentController extends AbstractController
{

    /**
     * @Route("/")
     */
    public function flatList()
    {
        return $this->render('flatRent/index.html.twig', [
            //pass required values
        ]);
    }

}