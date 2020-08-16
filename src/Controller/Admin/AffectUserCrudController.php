<?php

namespace App\Controller\Admin;

use App\Entity\User;
use Doctrine\ORM\QueryBuilder;
use EasyCorp\Bundle\EasyAdminBundle\Collection\FieldCollection;
use EasyCorp\Bundle\EasyAdminBundle\Collection\FilterCollection;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Config\Filters;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Dto\EntityDto;
use EasyCorp\Bundle\EasyAdminBundle\Dto\SearchDto;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\Field;
use EasyCorp\Bundle\EasyAdminBundle\Field\IntegerField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Filter\BooleanFilter;

class AffectUserCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return User::class;
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->setEntityLabelInSingular('Utilisateur / Groupe')
            ->setEntityLabelInPlural('Utilisateurs / Groupes')
            ->setSearchFields(['login', 'nom', 'mail']);
    }

    public function configureActions(Actions $actions): Actions
    {
        return $actions
            ->disable('new');
    }

    public function createIndexQueryBuilder(SearchDto $searchDto, EntityDto $entityDto, FieldCollection $fields, FilterCollection $filters): QueryBuilder
    {
        $qb = parent::createIndexQueryBuilder($searchDto, $entityDto, $fields, $filters);
        $qb->where('entity.anim_regulier = 1');
        return $qb;
    }

    public function configureFields(string $pageName): iterable
    {
        $id = IntegerField::new('id', 'ID');
        $login = TextField::new('login');
        // $password = TextField::new('password');
        $nom = TextField::new('nom');
        $mail = TextField::new('mail');
        $animRegulier = Field::new('anim_regulier');
        $animGroup = AssociationField::new('anim_group');
        $permanences = AssociationField::new('permanences');
        // $echanges = AssociationField::new('echanges');
        // $echangePropos = AssociationField::new('echangePropos');

        if (Crud::PAGE_INDEX === $pageName) {
            return [$nom, $mail, $animGroup, $permanences];
        } elseif (Crud::PAGE_EDIT === $pageName) {
            return [$nom, $mail, $animGroup];
        }
        return [];
    }
}
