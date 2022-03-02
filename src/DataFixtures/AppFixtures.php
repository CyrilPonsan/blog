<?php

namespace App\DataFixtures;

use App\Entity\Article;
use App\Entity\Categorie;
use COM;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $cat = new Categorie();
        $cat->setNom("Niouse Taik");
        $manager->persist($cat);

        $article = new Article();
        $article->setTitre("Les ordinateurs en bois");
        $article->setContenu("Lorem ipsum dolor, sit amet consectetur adipisicing elit. Quis aspernatur, praesentium ea harum ipsam quam ut eum cum, odio earum dolor magnam. Eius rerum alias odio magni non, consequatur vero fugiat voluptatibus! Possimus, vel! Excepturi atque distinctio tempora commodi, et non impedit quasi ut, quam laboriosam dignissimos consectetur officiis quidem ipsum placeat. Cupiditate nihil veniam perferendis tempore porro, vero temporibus nisi adipisci cumque harum maiores quod laborum exercitationem ipsa repellat reiciendis delectus nostrum quisquam? Cumque officia totam quasi magni. Quod, quidem obcaecati? Obcaecati tenetur, ipsa perferendis recusandae quia accusantium impedit in rerum sequi hic totam unde delectus aspernatur fuga deserunt.");
        $article->setDate(new \DateTime());
        $article->setImageSrc("burger.png");
        $article->setNbreVues(0);
        $article->setCategorie($cat);
        $manager->persist($article);

        $manager->flush();
    }
}
