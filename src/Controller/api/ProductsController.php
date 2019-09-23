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

use App\Document\Products;

class ProductsController extends FOSRestController
{

    /**
     * Method used for fetch records from products id
     */
    public function getProducts(string $id = null)
    {
        $dm = $this->get('doctrine_mongodb')->getManager();
        $repository = $dm->getRepository(Products::class);
        if ($id != null)
            $products = $repository->findBy(['id' => $id]);
        else
            $products = $repository->findAll();
//echo "<pre>";print_R($products);exit;
        return View::create($products, Response::HTTP_CREATED, []);
    }

    /**
     * @return array
     */
    public function addProducts(Request $request)
    {
        $product = new Products();
        $product->setProductName($request->get('ProductName'));
        $product->setProductDescription($request->get('ProductDescription'));
        $product->setProductPrice($request->get('ProductPrice'));
        $product->setProductQty($request->get('ProductQty'));
        $product->setStatus($request->get('status'));

        if (is_object($product)) {
            $dm = $this->get('doctrine_mongodb')->getManager();
            $dm->persist($product);
            $dm->flush();
        }
        return View::create($product, Response::HTTP_CREATED, []);
    }

    /**
     * Method will used for delete the products
     */
    public function deleteProducts(string $id = null)
    {
        $dm = $this->get('doctrine_mongodb')->getManager();
        $product = $dm->getRepository(Products::class)->find($id);

        if ($product != NULL) {
            $dm->remove($product);
            $dm->flush();
            return View::create("Deleted Successfully", Response::HTTP_OK, []);
        } else {
            return View::create("No data Found", Response::HTTP_OK, []);
        }
    }

}
