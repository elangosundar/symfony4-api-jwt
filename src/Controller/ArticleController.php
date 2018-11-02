<?php
namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;

use FOS\RestBundle\View\View;
use FOS\RestBundle\Controller\Annotations as FOSRest;
use FOS\RestBundle\Controller\FOSRestController;
use Symfony\Component\HttpFoundation\JsonResponse;

use App\Entity\Article;

class ArticleController extends FOSRestController
{
    /**
     * Matches /articles/{id}
     * 
     * @Route("/articles/{id}")
     * Method will used for Showing the user based on ID for REST
     */
    public function getArticleAction(string $id=null) 
    {
        echo "Normal index ===>Get Loops ==> ";exit;

        /* $dm = $this->get('doctrine_mongodb')->getManager();
        $repository = $dm->getRepository(User::class);
        if($id != null)
            $Users = $repository->findBy(['id' => $id]); 
        else
            $Users = $repository->findAll();
        return View::create($Users, Response::HTTP_CREATED , []); */
    }


    /**
     * Lists all Articles.
     * @FOSRest\Get("/articles")
     *
     * @return array
     */
   /*  public function getArticleAction()
    {
        $repository = $this->getDoctrine()->getRepository(Article::class);
        
        // query for a single Product by its primary key (usually "id")
        $article = $repository->findall();
        
        return View::create($article, Response::HTTP_OK , []);
    } */

    /**
     * Create Article.
     * @FOSRest\Post("/article")
     *
     * @return array
     */
    public function postArticleAction(Request $request)
    {
        $article = new Article();
        $article->setName($request->get('name'));
        $article->setDescription($request->get('description'));
        $em = $this->getDoctrine()->getManager();
        $em->persist($article);
        $em->flush();
        return View::create($article, Response::HTTP_CREATED , []);        
    }
}