<?php

namespace App\Controller;

use App\Entity\Article;
use App\Entity\Category;
use App\Entity\Comment;
use App\Entity\User;
use App\Form\ArticleType;
use App\Form\CategorieType;
use App\Form\CommentType;
use App\Repository\ArticleRepository;
use App\Repository\CategoryRepository;
use App\Repository\CommentRepository;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AdminController extends AbstractController
{
    // #[Route('/admin', name: 'admin')]
    // public function index(): Response
    // {
    //     return $this->render('admin/index.html.twig', []);
    // }

    // ///////////////////////////////////////////////////////////
    // // GESTION DES ARTICLES
    // ///////////////////////////////////////////////////////////

    // #[Route('/admin/articles', name: 'admin_articles')]
    // public function adminArticles(ArticleRepository $repo, EntityManagerInterface $em)
    // {
    //     // récupération des nom des colonnes SQL
    //     $colonnes = $em->getClassMetadata(Article::class)->getFieldNames();
    //     dump($colonnes);
    //     // récupérations de tout les articles
    //     $articles = $repo->findAll();
    //     dump($articles);
        
    //     return $this->render('admin/admin_articles.html.twig', [
    //         'articles' => $articles,
    //         'colonnes' => $colonnes
    //     ]);
    // }
    
    // #[Route('/admin/article/new', name: 'admin_new_article')]
    // #[Route('/admin/{id}/edit-article', name: 'admin_edit_article')]
    // public function editArticle(Request $request, EntityManagerInterface $manager, Article $article = null)
    // {
    //     // dump($article);
    //     // la classe Request contient les données véhiculées par les superglobales ($_POST, $_GET ...)
    //     // $article = new Article; // je crée un objet Article vide prêt à être rempli
    //     if(!$article)
    //     {
    //         $article = new Article;
    //         $article->setCreatedAt(new \DateTime()); // ajout de la date à l'insertion de l'article
    //     }
    //     $form = $this->createForm(ArticleType::class, $article);
    //     // createForm() permet de récupérer un formulaire
    //     // dump($request); // permet d'afficher les données de l'objet $request
    //     $form->handleRequest($request);
    //     // handleRequest() permet d'insérer les données du formulaire dans l'objet $article
    //     // Pour pouvoir insérer les données en BDD, on récupère le manager et on ajoute le code d'insertion
    //     if($form->isSubmitted() && $form->isValid())
    //     {
    //         $manager->persist($article); // prépare l'insertion de l'article
    //         $manager->flush(); // on exécute la requête d'insertion 
    //         // cette méthode permet de nous rediriger vers la page de notre article nouvellement crée
    //         $this->addFlash('success', "✅ Article mis à jour avec succès.");
    //         return $this->redirectToRoute('admin_articles');
    //     }
    //     return $this->render('blog/form.html.twig', [
    //         'formArticle' => $form->createView(),
    //         // createView() renvoie un objet représentant l'affichage du formulaire
    //         'editMode' => $article->getId() !== NULL 
    //         // si nous sommes sur la route /new : editMode = 0
    //         // sinon, editMode = 1
    //     ]);
    // }
    
    // #[Route('/admin/{id}/delete-article', name: 'admin_delete_article')]
    // public function deleteArticle(Article $article, EntityManagerInterface $manager)
    // {
    //     $manager->remove($article);
    //     $manager->flush();

    //     // on envoi un message d'alerte vers la vue
    //     $this->addFlash('success', "✅ Article supprimé avec succès.");
    //     return $this->redirectToRoute('admin_articles');
    // }

    // ///////////////////////////////////////////////////////////
    // // GESTION DES CATEGORIES
    // ///////////////////////////////////////////////////////////

    // #[Route('/admin/categories', name: 'admin_categories')]
    // public function adminCategories(CategoryRepository $repo, EntityManagerInterface $em)
    // {
    //     // récupération des nom des colonnes SQL
    //     $colonnes = $em->getClassMetadata(Category::class)->getFieldNames();
    //     dump($colonnes);
    //     // récupérations de toute les catégories
    //     $categories = $repo->findAll();
    //     dump($categories);
        
    //     return $this->render('admin/admin_categories.html.twig', [
    //         'categories' => $categories,
    //         'colonnes' => $colonnes
    //     ]);
    // }

    // #[Route('/admin/categorie/new', name: 'admin_new_categorie')]
    // #[Route('/admin/{id}/edit-categorie', name: 'admin_edit_categorie')]
    // public function editCategorie(Request $request, EntityManagerInterface $manager, Category $categorie = null)
    // {
    //     // dump($categorie);
    //     // la classe Request contient les données véhiculées par les superglobales ($_POST, $_GET ...)
    //     // $categorie = new Article; // je crée un objet Article vide prêt à être rempli
    //     if(!$categorie)
    //     {
    //         $categorie = new Category;
    //     }
    //     $form = $this->createForm(CategorieType::class, $categorie);
    //     // createForm() permet de récupérer un formulaire
    //     // dump($request); // permet d'afficher les données de l'objet $request
    //     $form->handleRequest($request);
    //     // handleRequest() permet d'insérer les données du formulaire dans l'objet $categorie
    //     // Pour pouvoir insérer les données en BDD, on récupère le manager et on ajoute le code d'insertion
    //     if($form->isSubmitted() && $form->isValid())
    //     {
    //         $manager->persist($categorie); // prépare l'insertion de l'categorie
    //         $manager->flush(); // on exécute la requête d'insertion 
    //         // cette méthode permet de nous rediriger vers la page de notre categorie nouvellement crée
    //         $this->addFlash('success', "✅ Catégorie mis à jour avec succès.");
    //         return $this->redirectToRoute('admin_categories');
    //     }
    //     return $this->render('blog/category-form.html.twig', [
    //         'formCategory' => $form->createView(),
    //         // createView() renvoie un objet représentant l'affichage du formulaire
    //         'editMode' => $categorie->getId() !== NULL 
    //         // si nous sommes sur la route /new : editMode = 0
    //         // sinon, editMode = 1
    //     ]);
    // }

    // #[Route('/admin/{id}/delete-categorie', name: 'admin_delete_categorie')]
    // public function deleteCategorie(Category $categorie, EntityManagerInterface $manager)
    // {
    //     $manager->remove($categorie);
    //     $manager->flush();

    //     // on envoi un message d'alerte vers la vue
    //     $this->addFlash('success', "✅ Catégorie supprimée avec succès.");
    //     return $this->redirectToRoute('admin_categories');
    // }

    // ///////////////////////////////////////////////////////////
    // // GESTION DES MEMBRES
    // ///////////////////////////////////////////////////////////

    // #[Route('/admin/membres', name: 'admin_membres')]
    // public function adminMembres(UserRepository $repo, EntityManagerInterface $em)
    // {
    //     // récupération des nom des colonnes SQL
    //     $colonnes = $em->getClassMetadata(User::class)->getFieldNames();
    //     dump($colonnes);
    //     // récupérations de tout les membres
    //     $membres = $repo->findAll();
    //     dump($membres);
        
    //     return $this->render('admin/admin_membres.html.twig', [
    //         'membres' => $membres,
    //         'colonnes' => $colonnes
    //     ]);
    // }

    // #[Route('/admin/{id}/delete-membre', name: 'admin_delete_membre')]
    // public function deleteMembre(User $user, EntityManagerInterface $manager)
    // {
    //     $manager->remove($user);
    //     $manager->flush();

    //     // on envoi un message d'alerte vers la vue
    //     $this->addFlash('success', "✅ Le membre à bien été supprimé.");
    //     return $this->redirectToRoute('admin_membres');
    // }

    // ///////////////////////////////////////////////////////////
    // // GESTION DES MEMBRES
    // ///////////////////////////////////////////////////////////

    // #[Route('/admin/commentaires', name: 'admin_commentaires')]
    // public function adminCommentaires(CommentRepository $repo, EntityManagerInterface $em)
    // {
    //     // récupération des nom des colonnes SQL
    //     $colonnes = $em->getClassMetadata(Comment::class)->getFieldNames();
    //     dump($colonnes);
    //     // récupérations de toute les catégories
    //     $commentaires = $repo->findAll();
    //     dump($commentaires);
        
    //     return $this->render('admin/admin_commentaires.html.twig', [
    //         'commentaires' => $commentaires,
    //         'colonnes' => $colonnes
    //     ]);
    // }

    // #[Route('/admin/comment/new', name: 'admin_new_comment')]
    // #[Route('/admin/{id}/edit-comment', name: 'admin_edit_comment')]
    // public function editComment(Request $request, EntityManagerInterface $manager, Comment $comment = null)
    // {
    //     // dump($categorie);
    //     // la classe Request contient les données véhiculées par les superglobales ($_POST, $_GET ...)
    //     // $categorie = new Article; // je crée un objet Article vide prêt à être rempli
    //     if(!$comment)
    //     {
    //         $comment = new Comment;
    //         $comment->setCreatedAt(new \DateTime()); // ajout de la date à l'insertion de l'article
    //     }
    //     $form = $this->createForm(CommentType::class, $comment);
    //     // createForm() permet de récupérer un formulaire
    //     // dump($request); // permet d'afficher les données de l'objet $request
    //     $form->handleRequest($request);
    //     // handleRequest() permet d'insérer les données du formulaire dans l'objet $comment
    //     // Pour pouvoir insérer les données en BDD, on récupère le manager et on ajoute le code d'insertion
    //     if($form->isSubmitted() && $form->isValid())
    //     {
    //         $manager->persist($comment); // prépare l'insertion de l'comment
    //         $manager->flush(); // on exécute la requête d'insertion 
    //         // cette méthode permet de nous rediriger vers la page de notre comment nouvellement crée
    //         $this->addFlash('success', "✅ Commentaire mis à jour avec succès.");
    //         return $this->redirectToRoute('admin_commentaires');
    //     }
    //     return $this->render('blog/comment-form.html.twig', [
    //         'formComment' => $form->createView(),
    //         // createView() renvoie un objet représentant l'affichage du formulaire
    //         'editMode' => $comment->getId() !== NULL 
    //         // si nous sommes sur la route /new : editMode = 0
    //         // sinon, editMode = 1
    //     ]);
    // }


    // #[Route('/admin/{id}/delete-commentaire', name: 'admin_delete_commentaire')]
    // public function deleteCommentaire(Comment $commentaire, EntityManagerInterface $manager)
    // {
    //     $manager->remove($commentaire);
    //     $manager->flush();

    //     // on envoi un message d'alerte vers la vue
    //     $this->addFlash('success', "✅ Le commentaire à été supprimé avec succès.");
    //     return $this->redirectToRoute('admin_commentaires');
    // }


}
