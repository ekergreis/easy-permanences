<?php

namespace App\Controller\Admin;

use App\Entity\Permanence;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IntegerField;

class PermanenceCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Permanence::class;
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->setEntityLabelInSingular('Permanence')
            ->setEntityLabelInPlural('Permanences')
            ->setSearchFields(null);
    }

    public function configureActions(Actions $actions): Actions
    {
        return $actions
            ->update(Crud::PAGE_INDEX, Action::NEW, function (Action $action) {
                return $action->setIcon('fa fa-calendar')->setLabel('Ajout');
            })
            ;
    }

    public function configureFields(string $pageName): iterable
    {
        $date = DateField::new('date');
        $groupPermanence = AssociationField::new('group_permanence', 'Groupe animateurs');
        // $id = IntegerField::new('id', 'ID');
        // $userPermanence = AssociationField::new('user_permanence');
        // $echanges = AssociationField::new('echanges');

        if (Crud::PAGE_INDEX === $pageName) {
            return [$date, $groupPermanence];
        } elseif (Crud::PAGE_NEW === $pageName) {
            return [$date, $groupPermanence];
        } elseif (Crud::PAGE_EDIT === $pageName) {
            return [$date, $groupPermanence];
        }
        return [];
    }
}
