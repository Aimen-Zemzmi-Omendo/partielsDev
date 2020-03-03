<?php

namespace App\Controller;

use App\Entity\Article;
use App\Form\ArticleFormType;
use App\Repository\ArticleRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ArticleController extends AbstractController
{
    private $articleRepository;

    public function __construct(ArticleRepository $articleRepository){
        $this->articleRepository = $articleRepository;
    }
    /**
     * @Route("/article-list", name="article-list")
     */
    public function index(){
        $articleList = $this->articleRepository->findAll();
        return $this->render('article/index.html.twig', [
            'articleList' => $articleList,
        ]);
    }


    /**
     * @Route("/article-create", name="article-create")
     * @param Request $request
     * @return Response
     */

    public function createArticleAction(Request $request): Response{
        $article = new Article();
        $form = $this->createForm( ArticleFormType::class, $article);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($article);
            $entityManager->flush();
            return $this->redirectToRoute('article-list');
        }
        return $this->render('article/createArticle.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/article/{id}", name="article")
     * @param int $id
     * @param Request $request
     * @return Response
     */
    public function showUser(int $id, Request $request){
        $article = $this->articleRepository->find($id);
        $form = $this->createForm(ArticleFormType::class, $article);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            $entityManger = $this->getDoctrine()->getManager();
            $entityManger->persist($article);
            $entityManger->flush();
            $this->addFlash('notification', "L'article a bien été modifié !");
        }
        return $this->render('article/article.html.twig', [
            'article' => $article,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/delete_article/{id}", name="delete_article")
     * @param Article $article
     * @return RedirectResponse
     */
    public function deleteArticle(Article $article){
        $entityManger = $this->getDoctrine()->getManager();
        $entityManger->remove($article);
        $entityManger->flush();
        $this->addFlash('notification', "L'article a bien été supprimé !");
        return $this->redirectToRoute("article-list");
    }
}
