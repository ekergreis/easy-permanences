<?php

namespace App\Controller;

use App\Entity\GroupSearch;
use App\Entity\Permanence;
use App\Form\GroupSearchType;
use App\Utils\TraitementPermanences;
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

        // Génération tableau des permanences (multi-dimension une ligne par mois et une colonne par jour)
        $arrayPermanence = (new TraitementPermanences($this->em))
            ->extractInfos($this->getUser());

        // Affichage view
        return $this->render('main/index.html.twig', [
            'controller_name' => 'MainController',
            'form' => $form->createView(),
            'group_search' => $groupSearch->isFilterGroup(),
            'array_permanence' => $arrayPermanence,
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
