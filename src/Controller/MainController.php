<?php

namespace App\Controller;

use App\Repository\ArticleRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class MainController extends AbstractController
{
    #[Route('/', name: 'app_main')]
    public function index(ArticleRepository $articleRepository): Response
    {
        $articles = $articleRepository->findAll(); 

        return $this->render('main/index.html.twig', [
            "articles" => $articles
        ]);
    }

    #[Route('/article/{id}', name: 'app_article')]
    public function article(ArticleRepository $articleRepository, int $id): Response
    {
        $article = $articleRepository->findOneBy(["id" => $id]);
        return $this->render('main/article.html.twig', [
            "article" => $article
        ]);
    }

    #[Route('/about', name: 'app_about')]
    public function about(): Response
    {
        return $this->render('main/about.html.twig', []);
    }
}
