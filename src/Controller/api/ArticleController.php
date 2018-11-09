<?php
namespace App\Controller\api;

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

use App\Document\Article;

//use Symfony\Component\Security\Core\User\UserInterface;
//use Lexik\Bundle\JWTAuthenticationBundle\Services\JWTTokenManagerInterface;

class ArticleController extends FOSRestController
{
   
    /**
     * Matches /api/articles/{id}
     * 
     * @Route("/api/articles/{id}")
     * Method used for fetch records from articles id
     */
    public function getArticleAction(string $id=null ) 
    {
        $dm = $this->get('doctrine_mongodb')->getManager();
        $repository = $dm->getRepository(Article::class);
        if($id != null)
            $Articles = $repository->findBy(['id' => $id]); 
        else
            $Articles = $repository->findAll();
        
        return View::create($Articles, Response::HTTP_CREATED , []);
    }

    /**
     * Matches /api/article
     * @Route("/api/article")
     *
     * @return array
     */
    public function postArticleAction(Request $request)
    {
        $article = new Article();
        $article->setUserFirstName($request->get('userFirstName'));
        $article->setUserLastName($request->get('userLastName'));

        if (is_object($article))
        {
            $dm = $this->get('doctrine_mongodb')->getManager();
            $dm->persist($article);
            $dm->flush();
        }
        return View::create($article, Response::HTTP_CREATED , []);
    }

    /**
     * Matches /api/delete/{id}
     *
     * @Route("/api/delete/{id}")
     * Method will used for delete the article
     */

    public function deleteArticleAction(string $id=null)
    {
        $dm = $this->get('doctrine_mongodb')->getManager();
        $article = $dm->getRepository(Article::class)->find($id);

        if($article != NULL){
            $dm->remove($article);
            $dm->flush();
            return View::create("Deleted Successfully", Response::HTTP_OK , []);
        }else{
            return View::create("No data Found", Response::HTTP_OK , []);
        }
    }


}
