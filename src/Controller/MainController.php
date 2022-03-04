<?php

namespace App\Controller;

use App\Repository\ArticleRepository;
use App\Repository\CategorieRepository;
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
    public function article(ArticleRepository $articleRepository, int $id): Response
    {
        $article = $articleRepository->findOneBy(["id" => $id]);
        return $this->render('main/article.html.twig', [
            "article" => $article,
        ]);
    }

    #[Route('/about', name: 'app_about')]
    public function about(): Response
    {
        return $this->render('main/about.html.twig', []);
    }
}
