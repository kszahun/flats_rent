<?php


namespace App\Controller;


use App\Builder\FlatBuilder;
use App\Builder\ReservationBuilder;
use App\Entity\Flat;
use App\Form\ReservationForm;
use App\Repository\FlatRepository;
use Doctrine\ORM\EntityManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\EntityManagerInterface;

class FlatRentController extends AbstractController
{
    /**
     * @var FlatBuilder
     */
    private $flatBuilder;

    /**
     * @var FlatRepository
     */
    private $flatRepository;
    /**
     * @var ReservationBuilder
     */
    private $reservationBuilder;

    public function __construct(FlatBuilder $flatBuilder, FlatRepository $flatRepository, ReservationBuilder $reservationBuilder)
    {
        $this->flatBuilder = $flatBuilder;
        $this->flatRepository = $flatRepository;
        $this->reservationBuilder = $reservationBuilder;
    }

    /**
     * @Route("/")
     */
    public function flatList(Request $request)
    {
        $em = $this->getDoctrine()->getManager();

        if (count($this->flatRepository->findAll()) < 5) {
            $flats = $this->flatBuilder->buildMultipleFlats(5);
            $this->persistEntities($flats, $em);
            $em->flush();
        } else {
            $flats = $this->flatRepository->findAll();
        }
        $flats = $this->changeArrayKeys($flats);
        $form = $this->createForm(ReservationForm::class, null, ['data' =>['flats' => $flats]]);

        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()) {
            
        }

        return $this->render('flatRent/index.html.twig', [
            "flats" => $flats,
            "form" => $form->createView()
        ]);
    }

    private function persistEntities(array $entities, EntityManager $em) {
        foreach ($entities as $entity) {
            $em->persist($entity);
        }

    }

    private function changeArrayKeys(array $flats)
    {
        $newFlats =[];
        foreach ($flats as $flat) {
            $newFlats[$flat->getName()] = $flat;
        }

        return $newFlats;
    }
}