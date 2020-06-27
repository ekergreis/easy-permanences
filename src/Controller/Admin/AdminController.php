<?php

namespace App\Controller\Admin;

use App\Entity\Group;
use App\Form\GroupeType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/admin-bis")
 */

class AdminController extends AbstractController
{
    /**
     * @var EntityManagerInterface
     */
    private $em;

    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    /**
     * @Route("/", name="admin")
     */
    public function index()
    {
        return $this->render('admin/index.html.twig', [
            'controller_name' => 'AdminController',
        ]);
    }

    /**
     * @Route("/groupe", name="groupe")
     */
    public function groupe(Request $request)
    {
        $group = new Group();
        $formGroup = $this->createForm(GroupeType::class, $group);
        $formGroup->handleRequest($request);

        if($formGroup->isSubmitted() && $formGroup->isValid()) {
            $this->em->persist($group);
            $this->em->flush();
        }

        return $this->render('admin/group.html.twig', [
            'form' => $formGroup->createView(),
        ]);
    }

    /**
     * @Route("/periode-permanences", name="periode_permanences")
     */
    public function setPeriodePermanences()
    {

    }

    /**
     * @Route("/affect-users-groupes", name="affect_user_groupes")
     */
    public function setUsersGroupes()
    {

    }

    /**
     * @Route("/affect-groupes-permanences", name="affect_groupes_permanences")
     */
    public function setGroupesPermanences()
    {

    }


}
