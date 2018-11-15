<?php
namespace App\Controller\v2;

use FOS\RestBundle\Controller\Annotations\Version;
use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\Controller\Annotations\Route;
use FOS\RestBundle\Controller\Annotations\View;
use FOS\RestBundle\Controller\Annotations\Get;
use FOS\RestBundle\Controller\Annotations\NamePrefix;

/**
 * @Version("v2")
 * @NamePrefix("v2")
 */
class ShareController extends FOSRestController
{
    /**
     * @Route("/api/test",condition="request.attributes.get('version') == 'v2'")
     */
    public function getTestAction()
    {
        $output = array();
        echo "test2";exit;
        //$view = $this->view($output, 200);
        //return $this->handleView($view);
    }
}
