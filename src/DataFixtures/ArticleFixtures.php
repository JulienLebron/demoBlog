<?php

namespace App\DataFixtures;

use App\Entity\Article;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class ArticleFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        for($i = 1; $i <= 10; $i++)
        {
            $article = new Article();
            // on instancie la class Article() qui se trouve dans le dossier App\Entity
            // Nous pouvons maintenant faire appel au setter pour créer des articles
            $article->setTitle("Titre de l'article n°$i")
                    ->setContent("<p>Contenu de l'article n°$i</p>")
                    ->setImage("https://picsum.photos/250/150")
                    ->setCreatedAt(new \DateTime()); 
            $manager->persist($article);
            // permet de faire persister l'article dans le temps
        }
        $manager->flush();
        // la méthode flush() balance la requête SQL qui mettra en place les différentes manipulations que nous avons fait ici
    }
}
