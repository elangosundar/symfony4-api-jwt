<?php
namespace App\Controller\v1;

use FOS\RestBundle\Controller\Annotations\Version;
use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\Controller\Annotations\Route;
use FOS\RestBundle\Controller\Annotations\View;
use FOS\RestBundle\Controller\Annotations\Get;
use FOS\RestBundle\Controller\Annotations\NamePrefix;

/**
 * @Version("v1")
 * @NamePrefix("v1")
 */
class ShareController extends FOSRestController
{
    public function getTestAction()
    {
        $output = array();
        echo "test1"; exit;
        //$view = $this->view($output, 200);
        //return $this->handleView($view);
    }
}
