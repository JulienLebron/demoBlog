<?php

namespace App\Controller\Admin;

use App\Entity\Article;
use Doctrine\ORM\EntityManagerInterface;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextareaField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class ArticleCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Article::class;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            TextField::new('title', 'Titre'),
            ImageField::new('image')->setBasePath('images/articles')->setUploadedFileNamePattern('[slug]-[timestamp].[extension]')->setUploadDir('public\images\articles')->setRequired(false),
            TextareaField::new('content', 'Contenu')->onlyOnForms(),
            DateTimeField::new('createdAt', 'Date de création')->setFormat("d/M/Y à H:m:s")->hideOnForm(),
            AssociationField::new('category', 'Catégorie'),
            DateTimeField::new('updatedAt', 'Date de mise à jour')->setFormat("d/M/Y à H:m:s")->hideOnForm(),
            TextEditorField::new('content', 'Contenu'),
        ];
    }

    public function createEntity(string $entityFqcn)
    {
        // createEntity() est exécutée lorsque je clique sur add article
        // elle permet d'exécuter du code avant d'afficher la page du form de création
        // ici, je définis une date de création et de mise à jour

        $article = new Article;
        $article->setCreatedAt(new \DateTime())
                ->setUpdatedAt(new \DateTime());
        return $article;
    }

    public function updateEntity(EntityManagerInterface $entityManager, $entityInstance): void
    {
        // updateEntity() est exécutée lors de la soumission du formulaire de mise à jour
        $isFile = $entityInstance->getImage();

        if(!$isFile)
        {
            // cette image doit être placée dans le dossier des images articles
            $entityInstance->setImage('defaut.jpg');
        }

        $entityInstance->setUpdatedAt(new \DateTime());
        $entityManager->persist($entityInstance);
        $entityManager->flush();
    }


}
