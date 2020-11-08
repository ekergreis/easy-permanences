<?php

namespace App\Controller;

use App\Entity\GroupSearch;
use App\Entity\Permanence;
use App\Form\GroupSearchType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class MainController extends AbstractController
{
    private $config;
    /**
     * @var EntityManagerInterface
     */
    private $em;
    /**
     * @var ParameterBagInterface
     */
    private $parameterBag;

    public function __construct(EntityManagerInterface $em, ParameterBagInterface $parameterBag)
    {
        $this->config = $parameterBag->get('app');
        $this->em = $em;
    }

    /**
     * @Route("/", name="main")
     */
    public function index(Request $request)
    {
        // Recupération filtre sur affichage permanences par utilisateur ou par groupe
        $groupSearch = new GroupSearch();
        $form = $this->createForm(GroupSearchType::class, $groupSearch);
        $form->handleRequest($request);

        // Constitution tableau des permanences (multi-dimension une ligne par mois et une colonne par jour)

        // Recherche permanences assurées par l'utilisateur et par les groupes
        // Conservation pour affichage date prochaine permanence et nb permanences assurées
        $arrayPermanence = [];
        $nextPermanence = null;
        $nbPermanence = 0;

        $user = $this->getUser();
        $permanences = $this->em
            ->getRepository(Permanence::class)
            ->findBy([], ['date' => 'ASC']);
        // Parcours de l'ensemble des permanences
        foreach($permanences as $permanence) {
            // Initialisation 1ère dimension tableau pour un mois (affichage ligne)
            $month = $permanence->getDate()->format('m-Y');
            // Initialisation 2ème dimension tableau pour un jour de permanence (affichage colonne)
            $day = $permanence->getDate()->format('d');
            // Initialisation tableau pour permanence
            $arrayPermanence[$month][$day] = [
                'date' => $permanence->getDate(),
                'user' => false,
                'group' => $permanence->getGroup(),
            ];

            // Parcours des utilisateurs liés à la permanence
            foreach ($permanence->getUsers() as $userPermanence) {
                // Si l'utilisateur connecté et affecté à la permanence
                if($user == $userPermanence) {
                    $nextPermanence = $permanence->getDate();
                    $nbPermanence++;
                    $arrayPermanence[$month][$day]['user'] = true;
                }
            }
        }

        // Affichage view
        return $this->render('main/index.html.twig', [
            'controller_name' => 'MainController',
            'form' => $form->createView(),
            'group_search' => $groupSearch->isFilterGroup(),
            'array_permanence' => $arrayPermanence,
            'next_permanence' => $nextPermanence,
            'nb_permanence' => $nbPermanence,
        ]);
    }

    /**
     * @Route("/detail-permanence/{permanence}", name="detail_permanence")
     */
    public function detailPermanence(Permanence $permanence)
    {
        return $this->render('main/index.html.twig', [
            'controller_name' => 'MainController',
        ]);
    }

    /**
     * @Route("/subscrib-permanence/{permanence}", name="subscrib_permanence")
     */
    public function subscribPermanence(Permanence $permanence)
    {

    }

    /**
     * @Route("/change-permanence/{permanence}", name="change_permanence")
     */
    public function requestChangePermanence(Permanence $permanence)
    {

    }

    /**
     * @Route("/propo-permanence/{permanenceDem}/{permanencePropo}", name="propo_permanence")
     */
    public function propoEchangePermanence(Permanence $permanenceDem, Permanence $permanencePropo)
    {

    }
}
