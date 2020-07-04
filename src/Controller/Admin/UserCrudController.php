<?php

namespace App\Controller\Admin;

use App\Entity\User;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\Field;
use EasyCorp\Bundle\EasyAdminBundle\Field\IntegerField;
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
            ->setSearchFields(['id', 'login', 'nom', 'mail']);
    }

    public function configureFields(string $pageName): iterable
    {
        $login = TextField::new('login');
        $password = TextField::new('password');
        $nom = TextField::new('nom');
        $mail = TextField::new('mail');
        $animRegulier = Field::new('anim_regulier');
        $animGroup = AssociationField::new('anim_group');
        $permanences = AssociationField::new('permanences');
        $echanges = AssociationField::new('echanges');
        $echangePropos = AssociationField::new('echangePropos');
        $id = IntegerField::new('id', 'ID');

        if (Crud::PAGE_INDEX === $pageName) {
            return [$id, $login, $nom, $mail, $animRegulier, $animGroup, $permanences];
        } elseif (Crud::PAGE_DETAIL === $pageName) {
            return [$id, $login, $password, $nom, $mail, $animRegulier, $animGroup, $permanences, $echanges, $echangePropos];
        } elseif (Crud::PAGE_NEW === $pageName) {
            return [$login, $password, $nom, $mail, $animRegulier, $animGroup, $permanences, $echanges, $echangePropos];
        } elseif (Crud::PAGE_EDIT === $pageName) {
            return [$login, $password, $nom, $mail, $animRegulier, $animGroup, $permanences, $echanges, $echangePropos];
        }
    }
}
