<?php

namespace App\Controller\Admin;

use App\Entity\Group;
use App\Entity\Permanence;
use App\Entity\User;
use App\Repository\PermanenceRepository;
use App\Repository\UserRepository;
use App\Services\Affectation;
use Doctrine\ORM\EntityManagerInterface;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class GroupCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Group::class;
    }

    public function configureActions(Actions $actions): Actions
    {
        return $actions
            ->update(Crud::PAGE_INDEX, Action::NEW, function (Action $action) {
                return $action->setIcon('fa fa-group')->setLabel('Ajout');
            })
            ;
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->setEntityLabelInSingular('Groupe')
            ->setEntityLabelInPlural('Groupes')
            ->setPageTitle('index', '%entity_label_plural%')
            ->setSearchFields(null)
            ->setDefaultSort(['name'=>'ASC']);;
    }

    public function configureFields(string $pageName): iterable
    {
        $id = IdField::new('id')->hideOnIndex();
        $nom = TextField::new('name', 'Intitulé');
        $users = AssociationField::new('users', 'Animateurs réguliers')
            ->setFormTypeOptions([
                'query_builder' => function (UserRepository $ur) {
                    return $ur->createQueryBuilder('u')
                        ->andWhere('u.animRegulier = 1')
                        ->orderBy('u.name', 'ASC');
                },
            ]);
        $permanences = AssociationField::new('permanences', 'Permanences')
            ->setFormTypeOptions([
            'query_builder' => function (PermanenceRepository $pr) {
                return $pr->createQueryBuilder('p')
                    ->orderBy('p.date', 'ASC');
            },
        ]);

        if (Crud::PAGE_INDEX === $pageName) {
            return [$nom, $users, $permanences];
        } elseif (Crud::PAGE_DETAIL === $pageName) {
            return [$id, $nom, $users, $permanences];
        } elseif (Crud::PAGE_NEW === $pageName) {
            return [$nom, $users, $permanences];
        } elseif (Crud::PAGE_EDIT === $pageName) {
            return [$nom, $users, $permanences];
        }
        return [];
    }

    public function updateEntity(EntityManagerInterface $entityManager, $entityInstance): void
    {
        $affect = new Affectation($entityManager);

        // Traitement Users retirés du groupe
        $snapshot = $entityInstance->getUsers()->getSnapshot();
        foreach ($snapshot as $i => $user) {
            if (!$entityInstance->getUsers()->contains($user)) {
                $affect->initUserGroupPermanences($user, $user->getGroup());
                $user->setGroup(null);
            }
        }
        // Traitement Users du groupe
        foreach ($entityInstance->getUsers() as $i => $user) {
            if ($entityInstance !== $user->getGroup() && !empty($user->getGroup())) {
                $affect->initUserGroupPermanences($user, $user->getGroup());
            }
            $user->setGroup($entityInstance);
            $affect->setUserGroupPermanences($user, false);
        }

        // Traitement Permanences retirées du groupe
        $snapshot = $entityInstance->getPermanences()->getSnapshot();
        foreach ($snapshot as $i => $permanence) {
            if (!$entityInstance->getPermanences()->contains($permanence)) {
                $affect->initPermanences($permanence, $permanence->getGroup());
                $permanence->setGroup(null);
            }
        }
        // Traitement Permanences du groupe
        foreach ($entityInstance->getPermanences() as $i => $permanence) {
            if ($entityInstance !== $permanence->getGroup() && !empty($permanence->getGroup())) {
                $affect->initPermanences($permanence, $permanence->getGroup());
            }
            $permanence->setGroup($entityInstance);
            $affect->setPermanences($permanence, false);
        }

        parent::updateEntity($entityManager, $entityInstance);
    }
}
