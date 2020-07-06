<?php

namespace App\Controller\Admin;

use App\Entity\Group;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IntegerField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class GroupCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Group::class;
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->setSearchFields(['id', 'nom']);
    }

    public function configureFields(string $pageName): iterable
    {
        $nom = TextField::new('nom');
        $id = IntegerField::new('id', 'ID');
        $userGroup = AssociationField::new('user_group');
        $permanences = AssociationField::new('permanences');

        if (Crud::PAGE_INDEX === $pageName) {
            return [$nom];
        } elseif (Crud::PAGE_DETAIL === $pageName) {
            return [$id, $nom, $userGroup, $permanences];
        } elseif (Crud::PAGE_NEW === $pageName) {
            return [$nom];
        } elseif (Crud::PAGE_EDIT === $pageName) {
            return [$nom];
        }
        return [];
    }
}
