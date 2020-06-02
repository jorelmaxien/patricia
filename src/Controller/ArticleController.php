<?php

namespace App\Controller;

use FOS\RestBundle\Controller\FOSRestController;
use App\Entity\Article;
use FOS\RestBundle\Controller\Annotations as Rest;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;

class ArticleController extends FOSRestController
{
    /**
     * @Rest\Get(
     *     path = "/articles/{id}",
     *     name = "app_article_show",
     *     requirements = {"id"="\d+"}
     * )
     * @Rest\View
     */
    public function showAction(Article $article)
    {
        return $this->handleView($this->view($article));
    }


    /**
     * @Rest\Get(path="/articles", name="article_list")
     * @Rest\View
     */
    public function listAction()
    {
     $articles = $this->getDoctrine()->getRepository('App:Article')->findAll();

      return $this->handleView($this->view($articles));
        
    }

    /**
     * @Rest\Post(
     *    path = "/articles",
     *    name = "app_article_create"
     * )
     * @Rest\View
     * @ParamConverter("article", converter="fos_rest.request_body")
     */
    public function createAction(Article $article)
    {
        $em = $this->getDoctrine()->getManager();

        $em->persist($article);
        $em->flush();
        
        return $this->handleView($this->view($article));
        
    }
}
