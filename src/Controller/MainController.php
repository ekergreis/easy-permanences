<?php

namespace App\Controller;

use App\Entity\GroupSearch;
use App\Entity\Permanence;
use App\Form\GroupSearchType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class MainController extends AbstractController
{
    private $config;
    public function __construct(ParameterBagInterface $parameterBag)
    {
        $this->config = $parameterBag->get('app');
    }

    /**
     * @Route("/", name="main")
     */
    public function index(Request $request)
    {
        // Constitution tableau des permanences (multi-dimension une ligne pour un mois)

        // Recherche permanences assurées par l'utilisateur (par défaut)
        // Conservation pour affichage date prochaine permanence et nb permanences assurées


        $groupSearch = new GroupSearch();
        $form = $this->createForm(GroupSearchType::class, $groupSearch);
        $form->handleRequest($request);
        if($groupSearch->isFilterGroup()) {
            // Si sélection d'affichage par groupe constitution tableau groupe

        }

        return $this->render('main/index.html.twig', [
            'controller_name' => 'MainController',
            'titre' => $this->config['titre'],
            'form' => $form->createView(),
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
