<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Entity\User;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

use Symfony\Component\Routing\Annotation\Route;
use Lexik\Bundle\JWTAuthenticationBundle\Security\Firewall;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

use FOS\RestBundle\View\View;
use FOS\RestBundle\Controller\Annotations as FOSRest;
use FOS\RestBundle\Controller\FOSRestController;
use Symfony\Component\HttpFoundation\JsonResponse;
use FOS\RestBundle\Controller\Annotations\Version;
use FOS\RestBundle\Controller\Annotations\RouteResource;

class AuthController extends FOSRestController
{
    public function register(Request $request, UserPasswordEncoderInterface $encoder)
    {
        echo "leaf";exit;
        $em = $this->getDoctrine()->getManager();
        
        $username = $request->request->get('_username');
        $password = $request->request->get('_password');
        
        $user = new User($username);
        $user->setPassword($encoder->encodePassword($user, $password));
        $em->persist($user);
        $em->flush();

        return new Response(sprintf('User %s successfully created', $user->getUsername()));
    }

    public function authverify(Request $request)
    {
//echo  "Leaf===>";exit;
        return new Response(sprintf('Logged in as %s', $this->getUser()->getUsername()));
    }
    
    public function test1(Request $request)
    {
echo  "Version1===>";exit;
        return new Response(sprintf('Logged in as %s', $this->getUser()->getUsername()));
    }
    
    public function test2(Request $request)
    {
echo  "Verison2===>";exit;
        return new Response(sprintf('Logged in as %s', $this->getUser()->getUsername()));
    }

}
