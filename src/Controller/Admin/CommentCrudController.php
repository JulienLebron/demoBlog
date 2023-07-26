<?php

namespace App\Controller\Admin;

use App\Entity\Comment;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextareaField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class CommentCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Comment::class;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            TextareaField::new('content', 'Description')->renderAsHtml()->onlyOnIndex(),
            TextEditorField::new('content', 'Description')->onlyOnForms(),
            DateTimeField::new('createdAt', 'Date de création')->setFormat("d/M/Y à H:m:s")->hideOnForm(),
            AssociationField::new('article', "Titre de l'article"),
            TextField::new('author', 'Auteur'),
        ];
    }

    public function createEntity(string $entityFqcn)
    {
        $comment = new Comment;
        $comment->setCreatedAt(new \DateTime);
        return $comment;
    }
}
