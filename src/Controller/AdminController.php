<?php

namespace App\Controller;

use App\Entity\Article;
use App\Form\ArticleType;
use App\Repository\ArticleRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AdminController extends AbstractController
{
    #[Route('/admin', name: 'admin')]
    public function index(): Response
    {
        return $this->render('admin/index.html.twig', []);
    }

    #[Route('/admin/articles', name: 'admin_articles')]
    public function adminArticles(ArticleRepository $repo, EntityManagerInterface $em)
    {
        // récupération des nom des colonnes SQL
        $colonnes = $em->getClassMetadata(Article::class)->getFieldNames();
        dump($colonnes);
        // récupérations de tout les articles
        $articles = $repo->findAll();
        dump($articles);
        
        return $this->render('admin/admin_articles.html.twig', [
            'articles' => $articles,
            'colonnes' => $colonnes
        ]);
    }
    
    #[Route('/admin/article/new', name: 'admin_new_article')]
    #[Route('/admin/{id}/edit-article', name: 'admin_edit_article')]
    public function editArticle(Request $request, EntityManagerInterface $manager, Article $article = null)
    {
        // dump($article);
        // la classe Request contient les données véhiculées par les superglobales ($_POST, $_GET ...)
        // $article = new Article; // je crée un objet Article vide prêt à être rempli
        if(!$article)
        {
            $article = new Article;
            $article->setCreatedAt(new \DateTime()); // ajout de la date à l'insertion de l'article
        }
        $form = $this->createForm(ArticleType::class, $article);
        // createForm() permet de récupérer un formulaire
        // dump($request); // permet d'afficher les données de l'objet $request
        $form->handleRequest($request);
        // handleRequest() permet d'insérer les données du formulaire dans l'objet $article
        // Pour pouvoir insérer les données en BDD, on récupère le manager et on ajoute le code d'insertion
        if($form->isSubmitted() && $form->isValid())
        {
            $manager->persist($article); // prépare l'insertion de l'article
            $manager->flush(); // on exécute la requête d'insertion 
            // cette méthode permet de nous rediriger vers la page de notre article nouvellement crée
            $this->addFlash('success', "✅ Article mis à jour avec succès.");
            return $this->redirectToRoute('admin_articles');
        }
        return $this->render('blog/form.html.twig', [
            'formArticle' => $form->createView(),
            // createView() renvoie un objet représentant l'affichage du formulaire
            'editMode' => $article->getId() !== NULL 
            // si nous sommes sur la route /new : editMode = 0
            // sinon, editMode = 1
        ]);
    }
    
    #[Route('/admin/{id}/delete-article', name: 'admin_delete_article')]
    public function deleteArticle(Article $article, EntityManagerInterface $manager)
    {
        $manager->remove($article);
        $manager->flush();

        // on envoi un message d'alerte vers la vue
        $this->addFlash('success', "✅ Article supprimé avec succès.");
        return $this->redirectToRoute('admin_articles');
    }


}
