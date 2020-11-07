<?php

namespace App\Controller\Admin;

use App\Entity\Group;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IntegerField;
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
        $users = AssociationField::new('users');
        $permanences = AssociationField::new('permanences');

        if (Crud::PAGE_INDEX === $pageName) {
            return [$nom];
        } elseif (Crud::PAGE_DETAIL === $pageName) {
            return [$id, $nom, $users, $permanences];
        } elseif (Crud::PAGE_NEW === $pageName) {
            return [$nom];
        } elseif (Crud::PAGE_EDIT === $pageName) {
            return [$nom];
        }
        return [];
    }
}
