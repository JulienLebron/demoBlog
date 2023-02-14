<?php

namespace App\Controller;

use App\Entity\Article;
use App\Repository\ArticleRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class BlogController extends AbstractController
{
    #[Route('/blog', name: 'app_blog')]
    public function index(ArticleRepository $repo): Response
    {
        // $repo = $this->getDoctrine()->getRepository(Article::class);
        // la ligne suivante permet de sélectionner tous les articles
        $articles = $repo->findAll();
        // dd($articles);

        return $this->render('blog/index.html.twig', [
            'controller_name' => 'BlogController',
            'articles' => $articles
        ]);
    }

    #[Route('/', name: 'home')]
    public function home(): Response 
    {
        return $this->render('blog/home.html.twig', [
            'title' => 'Bienvenue sur le blog Symfony',
            'age' => 25
        ]);
    }
    
    #[Route('/blog/show/12', name: 'blog_show')]
    public function show()
    {
        return $this->render('blog/show.html.twig');
    }

    
}
