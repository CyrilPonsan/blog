<?php

namespace App\Controller;

use App\Repository\ArticleRepository;
use App\Repository\CategorieRepository;
use App\Repository\CommentaireRepository;
use App\Repository\UserRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class MainController extends AbstractController
{
    #[Route('/', name: 'app_main')]
    public function index(CategorieRepository $categorieRepository): Response
    {
        $cat = $categorieRepository->findAll();

        return $this->render('main/index.html.twig', [
            "categories" => $cat,
        ]);
    }

    #[Route('/categorie{id}', name: 'app_categorie')]
    public function categorie(CategorieRepository $categorieRepository, ArticleRepository $articleRepository, int $id): Response
    {
        $cat = $categorieRepository->findOneBy(["id" => $id]);
        $articles = $articleRepository->findBy(["categorie" => $id]);
        return $this->render('main/categorie.html.twig', [
            "categorie" => $cat,
            "articles" => $articles,
        ]);
    }

    #[Route('/article{id}', name: 'app_article')]
    public function article(ManagerRegistry $doctrine, ArticleRepository $articleRepository, CommentaireRepository $commentaireRepository, int $id): Response
    {
        session_start();
        $article = $articleRepository->findOneBy(["id" => $id]);
        if (!isset($_SESSION['vues']) || !in_array($id, $_SESSION['vues'])) :
            $manager = $doctrine->getManager();
            $article->setNbreVues($article->getNbreVues() + 1);
            $manager->flush();
            $_SESSION['vues'] = array();
            array_push($_SESSION['vues'], $id);
        endif;
        $commentaires = $commentaireRepository->findBy(["article" => $id]);

        return $this->render('main/article.html.twig', [
            "article" => $article,
            "commentaires" => $commentaires,
            "total" => count($commentaires),
        ]);
    }

    #[Route('/about', name: 'app_about')]
    public function about(): Response
    {
        session_start();
        session_destroy();
        return $this->render('main/about.html.twig', []);
    }

    #[Route('/compte', name: 'app_compte')]
    public function compte(): Response
    {
        return $this->render('main/compte.html.twig', []);
    }
}
