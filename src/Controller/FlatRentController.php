<?php


namespace App\Controller;


use App\Builder\FlatBuilder;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class FlatRentController extends AbstractController
{
    /**
     * @var FlatBuilder
     */
    private $flatBuilder;

    public function __construct(FlatBuilder $flatBuilder)
    {
        $this->flatBuilder = $flatBuilder;
    }

    /**
     * @Route("/")
     */
    public function flatList()
    {
        $flats = $this->flatBuilder->buildMultipleFlats(5);
        return $this->render('flatRent/index.html.twig', [
            "flats" => $flats
        ]);
    }
}