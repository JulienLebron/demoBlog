<?php

namespace App\DataFixtures;

use App\Entity\Article;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use App\Entity\Category;
use App\Entity\Comment;

class ArticleFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $faker = \Faker\Factory::create('fr_FR');

        // Créer 3 fausses catégories 
        for($i = 1; $i <= 3; $i++)
        {
            $category = new Category;
            $category->setTitle($faker->sentence());

            $manager->persist($category);

            // créer entre 4 et 6 articles
            for($j = 1; $j <= mt_rand(4,6); $j++) // Créer entre 4 et 6 articles
            {
                $article = new Article(); // on instancie la classe Article 
                $content = '<p>' . join('</p><p>', $faker->paragraphs(5)) . '</p>';
                // join() est alias de la fonction implode()
                // implode() est une fonction prédéfinie qui permet de rassembler les éléments d'un tableau en chaine de caractères avec un séparateur

                $article->setTitle($faker->sentence())
                        ->setContent($content)
                        ->setImage($faker->imageUrl())
                        ->setCreatedAt($faker->dateTimeBetween('-6 months'))
                        ->setCategory($category);
                $manager->persist($article);

                for($k = 1; $k <= mt_rand(4,10); $k++) // Créer entre 4 et 10 commentaires
                {
                    $comment = new Comment;
                    $content = '<p>' . join('</p><p>', $faker->paragraphs(2)) . '</p>';

                    $now = new \DateTime(); // objet datetime avec l'heure et la date du jour
                    $interval = $now->diff($article->getCreatedAt()); // représente l'intervalle entre maintenant et la date de création de l'article
                    $days = $interval->days; // nombre de jours entre maintenant et la date de création de l'article
                    $minimum = '-' . $days . ' days'; // spécifie la date minimale que l'on souhaite inclure dans la requête
                    
                    $comment->setAuthor($faker->name)
                            ->setContent($content)
                            ->setCreatedAt($faker->dateTimeBetween($minimum))
                            ->setArticle($article); // on relie nos commentaires aux articles
                    $manager->persist($comment);
                }
            }
        }
        $manager->flush(); // permet de lancer la requête SQL qui mettra en place les différentes manipulations que nous avons faites ici
        
    }
}
