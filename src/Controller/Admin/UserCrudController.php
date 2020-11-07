<?php

namespace App\Controller\Admin;

use App\Entity\User;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\BooleanField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class UserCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return User::class;
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->setEntityLabelInSingular('Utilisateur')
            ->setEntityLabelInPlural('Utilisateurs')
            ->setSearchFields(['name', 'email'])
            ->setDefaultSort(['name'=>'ASC']);
    }

    public function configureActions(Actions $actions): Actions
    {
        return $actions
            ->update(Crud::PAGE_INDEX, Action::NEW, function (Action $action) {
                return $action->setIcon('fa fa-user')->setLabel('Ajout');
            })
            ;
    }

    public function configureFields(string $pageName): iterable
    {
        $id = IdField::new('id')->hideOnIndex();
        $email = TextField::new('email', 'E-Mail');
        $password = TextField::new('password', 'Mot de passe');
        $nom = TextField::new('name', 'Nom');
        $animRegulier = BooleanField::new('animRegulier', 'Animateur Réguliers');
        // $animGroup = AssociationField::new('anim_group');
        $permanences = AssociationField::new('permanences', 'Nb Permanences');
        // $echanges = AssociationField::new('echanges');
        // $echangePropos = AssociationField::new('echangePropos');


        if (Crud::PAGE_INDEX === $pageName) {
            return [$id, $nom, $email, $animRegulier, $permanences];
        } elseif (Crud::PAGE_DETAIL === $pageName) {
            return [$id, $email, $password, $nom, $animRegulier, $permanences];
        } elseif (Crud::PAGE_NEW === $pageName) {
            return [$email, $password, $nom, $animRegulier];
        } elseif (Crud::PAGE_EDIT === $pageName) {
            return [$email, $password, $nom, $animRegulier];
        }
        return [];
    }
}
