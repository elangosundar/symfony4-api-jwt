<?php
namespace App\Controller\v2;

use FOS\RestBundle\Controller\Annotations\Version;
use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\Controller\Annotations\Route;
use FOS\RestBundle\Controller\Annotations\Get;
use FOS\RestBundle\Controller\Annotations\NamePrefix;
use JMS\Serializer\Annotation\Since;

use FOS\RestBundle\View\View;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\HttpFoundation\JsonResponse;


/**
 * @Version("v2")
 * @NamePrefix("v2")
 */
class ShareController extends FOSRestController
{
    public function getTestAction()
    {
        return new Response("Test2 Version Started...!");
    }
}
