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
use EasyCorp\Bundle\EasyAdminBundle\Filter\EntityFilter;

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
            ->setSearchFields(['name', 'email'])
            ->setDefaultSort(['group.name'=>'ASC', 'name'=>'ASC']);
    }

    public function configureFilters(Filters $filters): Filters
    {
        return $filters
            ->add('group')
            ;
    }

    public function configureActions(Actions $actions): Actions
    {
        return $actions
            ->disable('new');
    }

    /**
     * Filtre pour afficher uniquement les animateur réguliers
     * @param SearchDto $searchDto
     * @param EntityDto $entityDto
     * @param FieldCollection $fields
     * @param FilterCollection $filters
     * @return QueryBuilder
     */
    public function createIndexQueryBuilder(SearchDto $searchDto, EntityDto $entityDto, FieldCollection $fields, FilterCollection $filters): QueryBuilder
    {
        $qb = parent::createIndexQueryBuilder($searchDto, $entityDto, $fields, $filters);
        $qb->andWhere('entity.animRegulier = 1');
        return $qb;
    }

    public function configureFields(string $pageName): iterable
    {
        // $id = IntegerField::new('id', 'ID');
        $email = TextField::new('email', 'E-Mail');
        // $password = TextField::new('password');
        $nom = TextField::new('name', 'Nom');
        // $animRegulier = Field::new('animRegulier', 'Animateur régulier');
        $group = AssociationField::new('group', 'Groupe');
        $permanences = AssociationField::new('permanences', 'Nb Permanences');
        // $echanges = AssociationField::new('echanges');
        // $echangePropos = AssociationField::new('echangePropos');

        if (Crud::PAGE_INDEX === $pageName) {
            return [$nom, $email, $group, $permanences];
        } elseif (Crud::PAGE_EDIT === $pageName) {
            return [$nom, $email, $group];
        }
        return [];
    }
}
