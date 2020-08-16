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
            ->setSearchFields(['login', 'nom', 'mail']);
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
        $login = TextField::new('login', 'Code accès');
        $password = TextField::new('password', 'Mot de passe');
        $nom = TextField::new('nom', 'Nom');
        $mail = TextField::new('mail');
        $animRegulier = BooleanField::new('anim_regulier', 'Animateur Réguliers');
        // $animGroup = AssociationField::new('anim_group');
        $permanences = AssociationField::new('permanences');
        // $echanges = AssociationField::new('echanges');
        // $echangePropos = AssociationField::new('echangePropos');


        if (Crud::PAGE_INDEX === $pageName) {
            return [$id, $login, $nom, $mail, $animRegulier, $permanences];
        } elseif (Crud::PAGE_DETAIL === $pageName) {
            return [$id, $login, $password, $nom, $mail, $animRegulier, $permanences];
        } elseif (Crud::PAGE_NEW === $pageName) {
            return [$login, $password, $nom, $mail, $animRegulier];
        } elseif (Crud::PAGE_EDIT === $pageName) {
            return [$login, $password, $nom, $mail, $animRegulier];
        }
        return [];
    }
}
