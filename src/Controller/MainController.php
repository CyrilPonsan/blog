<?php

namespace App\Controller;

use App\Entity\Commentaire;
use App\Entity\User;
use App\Form\CommentaireType;
use App\Form\LoginType;
use App\Repository\ArticleRepository;
use App\Repository\CategorieRepository;
use App\Repository\CommentaireRepository;
use App\Repository\UserRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
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

    #[Route('/article-{id}', name: 'app_article')]
    public function article(UserRepository $userRepository, Request $request, ManagerRegistry $doctrine, ArticleRepository $articleRepository, CommentaireRepository $commentaireRepository, int $id): Response
    {
        $article = $articleRepository->findOneBy(["id" => $id]);
        if (session_status() === 0) :
            session_start();
        endif;
        if (!isset($_SESSION['vues']) || !in_array($id, $_SESSION['vues'])) :
            if (!isset($_SESSION['vues'])) :
                dd($_SESSION['vues']);
                $_SESSION['vues'] = array();
            endif;
            $manager = $doctrine->getManager();
            $article->setNbreVues($article->getNbreVues() + 1);
            $manager->flush();
            array_push($_SESSION['vues'], $id);
        endif;
        $total = count($commentaireRepository->findBy(["article" => $id]));
/*
        $commForm = $this->createForm(CommentaireType::class);
        $commForm->handleRequest($request);

        if ($commForm->isSubmitted() && $commForm->isValid()) :
            $comm = $commForm->getData();
            $comm->setDate(new \DateTime());
            $comm->setPublie(true);
            $comm->setArticle($article);
            $comm->setUser($userRepository->findBy(["pseudo" => "tata"])[0]);
            $manager = $doctrine->getManager();
            $manager->persist($comm);
            $manager->flush();
            return $this->redirectToRoute('app_article', ["id" => $id]);
        endif;
*/
        return $this->render('main/article.html.twig', [
            "article" => $article,
            "total" => $total,
            //"commForm" => $commForm->createView(),
        ]);
    }

    #[Route('/about', name: 'app_about')]
    public function about(): Response
    {
        session_start();
        if (isset($_SESSION['vues'])) :
            unset($_SESSION['vues']);
        endif;
        return $this->render('main/about.html.twig', []);
    }


    /*
    #[Route('/connexion', name: 'app_connexion')]
    public function connexion(Request $request, UserRepository $userRepository): Response
    {
        $user = new User();
        $form = $this->createForm(LoginType::class, $user);
        $form->handleRequest($request);
        if ($form->isSubmitted()) :
            $request = $form->getData();
            dd($request);
            $formUser = strip_tags($request['pseudo']);
            $formPasswd = strip_tags($request['password']);
            $user = $userRepository->findOneBy(['pseudo' => $formUser]);
            if ($user !== null && $user->getPassword() === $formPasswd) :
                return $this->redirectToRoute('app_connexionOk');
            endif;
        endif;

        return $this->renderForm('main/connexion.html.twig', [
            'form' => $form,
        ]);
    }

    #[Route('/connexionOk', name: 'app_connexionOk')]
    public function connexionOk(): Response
    {
        return $this->render('main/connexionOk.html.twig', []);
    }
    */
}
