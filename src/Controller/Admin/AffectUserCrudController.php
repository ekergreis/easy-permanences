<?php

namespace App\Controller\Admin;

use App\Entity\User;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\Field;
use EasyCorp\Bundle\EasyAdminBundle\Field\IntegerField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class AffectUserCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return User::class;
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->setSearchFields(['id', 'login', 'nom', 'mail']);
    }

    public function configureActions(Actions $actions): Actions
    {
        return $actions
            ->disable('new');
    }

    public function configureFields(string $pageName): iterable
    {
        $nom = TextField::new('nom');
        $mail = TextField::new('mail');
        $animGroup = AssociationField::new('anim_group');
        $id = IntegerField::new('id', 'ID');
        $login = TextField::new('login');
        $password = TextField::new('password');
        $animRegulier = Field::new('anim_regulier');
        $permanences = AssociationField::new('permanences');
        $echanges = AssociationField::new('echanges');
        $echangePropos = AssociationField::new('echangePropos');

        if (Crud::PAGE_INDEX === $pageName) {
            return [$nom, $mail, $animGroup];
        } elseif (Crud::PAGE_DETAIL === $pageName) {
            return [$id, $login, $password, $nom, $mail, $animRegulier, $animGroup, $permanences, $echanges, $echangePropos];
        } elseif (Crud::PAGE_NEW === $pageName) {
            return [$nom, $mail, $animGroup];
        } elseif (Crud::PAGE_EDIT === $pageName) {
            return [$nom, $mail, $animGroup];
        }
    }
}
