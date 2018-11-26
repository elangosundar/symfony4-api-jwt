<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Lexik\Bundle\JWTAuthenticationBundle\Security\Firewall;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

use FOS\RestBundle\View\View;
use FOS\RestBundle\Controller\Annotations as FOSRest;
use FOS\RestBundle\Controller\FOSRestController;
use Symfony\Component\HttpFoundation\JsonResponse;
use FOS\RestBundle\Controller\Annotations\Version;

use FOS\RestBundle\Controller\Annotations\Route;
use FOS\RestBundle\Controller\Annotations\Get;
use FOS\RestBundle\Controller\Annotations\NamePrefix;

use JMS\Serializer\Annotation\ExclusionPolicy;
use JMS\Serializer\Annotation\Since;
use JMS\Serializer\Annotation\Until;
use JMS\Serializer\Annotation\SerializedName;

/**
 * @Version("v1")
 * @NamePrefix("v1")
 * 
*/

class TestController extends FOSRestController
{
    /**
     *@Until("1")
    */
    public function test1() 
    {
        echo "testing ===> 1 ===> Block";
        exit;
    }

    /**
     * @Since("2")
     * @SerializedName("test1")

    */
    public function test2() 
    {
        echo "testing===> 2 ===> Block";
        exit;
    }
}

