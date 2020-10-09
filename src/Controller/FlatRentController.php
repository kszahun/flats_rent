<?php


namespace App\Controller;


use App\Builder\FlatBuilder;
use App\Builder\ReservationBuilder;
use App\Entity\Flat;
use App\Form\ReservationForm;
use App\Repository\FlatRepository;
use App\Service\ReservationFormValidator;
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

    /**
     * @var ReservationFormValidator
     */
    private $reservationFormValidator;

    public function __construct(
        FlatBuilder $flatBuilder,
        FlatRepository $flatRepository,
        ReservationBuilder $reservationBuilder,
        ReservationFormValidator $validator
    ){
        $this->flatBuilder = $flatBuilder;
        $this->flatRepository = $flatRepository;
        $this->reservationBuilder = $reservationBuilder;
        $this->reservationFormValidator = $validator;
    }

    /**
     * @Route("/")
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     * @throws \Doctrine\ORM\ORMException
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
        if ($form->isSubmitted() && $form->isValid()) {
            $data = $form->getData();
            $flat = $data['name'];
            $numberOfResidents = $data['numberOfResidents'];
            $from = $data['start'];
            $to = $data['end'];
            $validResponse = $this->reservationFormValidator->isValid($flat, $numberOfResidents, $from, $to);

            if ($validResponse['isValid']) {
                $cost = $this->calculateCost($flat->getPrice(), $numberOfResidents, date_diff($from, $to)->days + 1);
                $reservation = $this->reservationBuilder->buildReservation($flat, $numberOfResidents, $from, $to, $cost);
                $successReservationMessage = 'Zarezewowano Cena: '.$cost;
                $em->persist($reservation);
                $em->flush();
            }
        }

        return $this->render('flatRent/index.html.twig', [
            "message" =>isset($validResponse) ? ($validResponse['isValid'] ? $successReservationMessage : $validResponse['errorMsg']): "",
            "flats" => $flats,
            "form" => $form->createView()
        ]);
    }

    /**
     * @param array $entities
     * @param EntityManager $em
     * @throws \Doctrine\ORM\ORMException
     */
    private function persistEntities(array $entities, EntityManager $em) {
        foreach ($entities as $entity) {
            $em->persist($entity);
        }
    }

    /**
     * @param array $flats
     * @return array
     */
    private function changeArrayKeys(array $flats)
    {
        $newFlats =[];
        foreach ($flats as $flat) {
            $newFlats[$flat->getName()] = $flat;
        }

        return $newFlats;
    }

    /**
     * @param float $price
     * @param int $numberOfResidents
     * @param int $time
     * @return float|int
     */
    private function calculateCost(float $price, int $numberOfResidents, int $time)
    {
        $cost = $price*$numberOfResidents*$time;
        if ($time > 7) {
            $discountPercent = ($time-7)*2;
            if ($discountPercent > 40) $discountPercent=40;
            $cost = $cost*($discountPercent/100);
        }
        return $cost;
    }

}