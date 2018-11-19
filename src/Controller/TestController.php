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

/**
 * @Version("v1")
 * @NamePrefix("v1")
 * 
*/

class TestController extends FOSRestController
{
    /**
     *@Since("v1")
    */
    public function test1() 
    {
        echo "testing===> Block";
        exit;
    }
}
