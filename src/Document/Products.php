<?php
/*
 * Create User class document for MongoDB
*/

namespace App\Document;

use Doctrine\ODM\MongoDB\Mapping\Annotations as MongoDB;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\Constraints\DateTime;

/**
 * @MongoDB\Document(repositoryClass="App\Repository\ArticleRepository")
 */
class Products
{

    /**
     * @MongoDB\Id
     */
    protected $id;

    /**
     * @MongoDB\Field(type="string", name="ProductName")
     */
    protected $productName;

    /**
     * @MongoDB\Field(type="string", name="ProductDescription")
     */
    protected $productDescription;

    /**
     * @MongoDB\Field(type="string", name="ProductPrice")
     */
    protected $productPrice;

    /**
     * @MongoDB\Field(type="string", name="ProductQty")
     */
    protected $productQty;

    /**
     * @MongoDB\Field(type="string")
     */
    protected $status;

    public function setId($id)
    {
        $this->id = $id;
    }

    public function getId()
    {
        return $this->id;
    }

    public function setProductName($productName)
    {
        $this->productName = $productName;
    }

    public function getProductName()
    {
        return $this->productName;
    }

    public function setProductDescription($productDescription)
    {
        $this->productDescription = $productDescription;
    }

    public function getProductDescription()
    {
        return $this->productDescription;
    }

    public function setProductPrice($productPrice)
    {
        $this->productPrice = $productPrice;
    }

    public function getProductPrice()
    {
        return $this->$productPrice;
    }

    public function setProductQty($productQty)
    {
        $this->productQty = $productQty;
    }

    public function getProductQty()
    {
        return $this->productQty;
    }

    public function setStatus($status)
    {
        $this->status = $status;
    }

    public function getStatus()
    {
        return $this->status;
    }

}
