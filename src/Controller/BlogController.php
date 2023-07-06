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

class BlogController extends AbstractController
{
    #[Route('/blog', name: 'app_blog')]
    public function index(ArticleRepository $repo): Response
    {
        // pour récupérer le repository, je le pase en paramètre de la méthode index()
        // cela s'appelle une injection de dépendance

        $articles = $repo->findAll();
        // j'utilise la méthode findALl() pour récupérer tous les articles en BDD

        // render() permet d'afficher le contenu d'un template
        return $this->render('blog/index.html.twig', [
            'articles' => $articles // j'envoi les articles vers le template
        ]);
    }

    #[Route('/blog/show/{id}', name: 'blog_show')]
    public function show(ArticleRepository $repo, $id)
    {
        /* Pour sélectionner un article dans la BDD, nous utilisons le principe de route paramètrée. 
        Dans la route, on définie un paramètre de type {id}
        Lorsque nous transmettons dans l'URL par un exmple une route "/blog/9", on envoie un id comme en BDD dans l'url
        Symfony va automatiquement récupérer ce paramètre et le transmettre en argument de la méthode show()*/
        
        $article =  $repo->find($id);
        return $this->render('blog/show.html.twig', [
            'article' => $article
        ]);
    }
    
    #[Route('/blog/new', name: 'blog_create')]
    #[Route('/blog/edit/{id}', name: 'blog_edit')]
    public function form(Request $request, EntityManagerInterface $manager, Article $article = null)
    {
        dump($article);
        // la classe Request contient les données véhiculées par les superglobales ($_POST, $_GET ...)
        // $article = new Article; // je crée un objet Article vide prêt à être rempli
        if(!$article)
        {
            $article = new Article;
            $article->setCreatedAt(new \DateTime()); // ajout de la date à l'insertion de l'article
        }
        $form = $this->createForm(ArticleType::class, $article);
        // createForm() permet de récupérer un formulaire
        dump($request); // permet d'afficher les données de l'objet $request
        $form->handleRequest($request);
        // handleRequest() permet d'insérer les données du formulaire dans l'objet $article
        // Pour pouvoir insérer les données en BDD, on récupère le manager et on ajoute le code d'insertion
        if($form->isSubmitted() && $form->isValid())
        {
            $manager->persist($article); // prépare l'insertion de l'article
            $manager->flush(); // on exécute la requête d'insertion 
            // cette méthode permet de nous rediriger vers la page de notre article nouvellement crée
            return $this->redirectToRoute('blog_show', [
                'id' => $article->getId()
            ]);
        }
        return $this->render('blog/form.html.twig', [
            'formArticle' => $form->createView(),
            // createView() renvoie un objet représentant l'affichage du formulaire
            'editMode' => $article->getId() !== NULL 
            // si nous sommes sur la route /new : editMode = 0
            // sinon, editMode = 1
        ]);
    }
    
    
    
}
