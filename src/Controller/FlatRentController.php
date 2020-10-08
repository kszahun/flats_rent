<?php


namespace App\Controller;


use App\Builder\FlatBuilder;
use App\Entity\Flat;
use App\Form\ReservationForm;
use App\Repository\FlatRepository;
use Doctrine\ORM\EntityManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
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

    public function __construct(FlatBuilder $flatBuilder, FlatRepository $flatRepository)
    {
        $this->flatBuilder = $flatBuilder;
        $this->flatRepository = $flatRepository;
    }

    /**
     * @Route("/")
     */
    public function flatList()
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