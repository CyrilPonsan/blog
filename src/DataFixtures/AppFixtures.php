<?php

namespace App\DataFixtures;

use App\Entity\Article;
use App\Entity\Categorie;
use App\Entity\Commentaire;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class AppFixtures extends Fixture
{
    private $passwordHasher;

    public function __construct(UserPasswordHasherInterface $userPasswordHasherInterface)
    {
        $this->passwordHasher = $userPasswordHasherInterface;
    }

    public function load(ObjectManager $manager): void
    {
        $user = new User();
        $user->setEmail("tata@toto.com");
        $user->setDate(new \DateTime());
        $user->setPseudo("tata");
        $hash = $this->passwordHasher->hashPassword($user, "tata");
        $user->setPassword($hash);
        $manager->persist($user);

        $user1 = new User();
        $user1->setEmail("toto@toto.com");
        $user1->setDate(new \DateTime());
        $user1->setPseudo("toto");
        $hash = $this->passwordHasher->hashPassword($user1, "toto");
        $user1->setPassword($hash);
        $manager->persist($user1);

        $admin = new User();
        $admin->setEmail("admin@admin.toto");
        $admin->setDate(new \DateTime());
        $admin->setPseudo('WonderMecano');
        $hash = $this->passwordHasher->hashPassword($admin, "toto");
        $admin->setPassword($hash);
        $admin->setRoles(['ROLE_ADMIN']);
        $manager->persist($admin);

        for ($i = 1; $i < 4; $i++) :

            $cat = new Categorie();
            $cat->setNom("Niouse Taik-" . $i);
            $manager->persist($cat);

            for ($j = 1; $j < 6; $j++) :

                $article = new Article();
                $article->setTitre("Les ordinateurs en bois " . $i . "-" .$j);
                $article->setContenu("Lorem ipsum dolor, sit amet consectetur adipisicing elit. Quis aspernatur, praesentium ea harum ipsam quam ut eum cum, odio earum dolor magnam. Eius rerum alias odio magni non, consequatur vero fugiat voluptatibus! Possimus, vel! Excepturi atque distinctio tempora commodi, et non impedit quasi ut, quam laboriosam dignissimos consectetur officiis quidem ipsum placeat. Cupiditate nihil veniam perferendis tempore porro, vero temporibus nisi adipisci cumque harum maiores quod laborum exercitationem ipsa repellat reiciendis delectus nostrum quisquam? Cumque officia totam quasi magni. Quod, quidem obcaecati? Obcaecati tenetur, ipsa perferendis recusandae quia accusantium impedit in rerum sequi hic totam unde delectus aspernatur fuga deserunt.");
                $article->setDate(new \DateTime());
                $article->setImageSrc("pc_en_bois.jpg");
                $article->setNbreVues(0);
                $article->setCategorie($cat);
                $article->setUser($user1);
                $manager->persist($article);

                for ($k = 1; $k < 6; $k++) :

                    $comm = new Commentaire();
                    $comm->setDate(new \DateTime());
                    $comm->setContenu($k . " : Le bois c'est bien pour les calculs à virgule flottante lol");
                    $comm->setPublie(false);
                    $comm->setArticle($article);
                    $comm->setUser($user);
                    $manager->persist($comm);

                endfor;

            endfor;

        endfor;

        $manager->flush();
    }
}
