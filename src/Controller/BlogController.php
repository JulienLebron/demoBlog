<?php

namespace App\Controller;

use App\Repository\ArticleRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
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

    #[Route('/blog/show/12', name: 'blog_show')]
    public function show()
    {
        return $this->render('blog/show.html.twig');
    }


}
