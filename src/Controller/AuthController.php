<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

use Symfony\Component\Routing\Annotation\Route;
use Lexik\Bundle\JWTAuthenticationBundle\Security\Firewall;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

use FOS\RestBundle\View\View;
use FOS\RestBundle\Controller\Annotations as FOSRest;
use FOS\RestBundle\Controller\FOSRestController;
use Symfony\Component\HttpFoundation\JsonResponse;
use FOS\RestBundle\Controller\Annotations\Version;

use Lexik\Bundle\JWTAuthenticationBundle\Response\JWTAuthenticationSuccessResponse;
use Lexik\Bundle\JWTAuthenticationBundle\Event\AuthenticationSuccessEvent;

use Lexik\Bundle\JWTAuthenticationBundle\Event;
use Symfony\Component\Security\Core\User\UserInterface;
use Lexik\Bundle\JWTAuthenticationBundle\Events;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;

#use App\Entity\User;
use App\Security\User;

class AuthController extends FOSRestController
{
    public function userAuthenticationVerify(User $user, EventDispatcherInterface $dispatcher ){
        echo "<pre>";
        print_R($user);
        $CS_API_URL =  "https://home.stage.pionline.com/clickshare/extAPI1.do?";
        $data = [];
        $params = [
            'CSAuthID'       => "test1",
            'CSAuthKey'      => "abcdefg",
            'CSOp'           => "authenticateUser",
            'CSUsername'     => "mpatel@pionline.com",
            'CSPassword'     => "mpatel@pionline.com",
            "CSAuthReq"      => 1
        ];
        
        $options = [
            CURLOPT_HEADER          => 0,
            CURLOPT_RETURNTRANSFER  => 1,
            CURLOPT_SSL_VERIFYPEER  => 0,
            CURLOPT_SSL_VERIFYHOST  => 0,
            CURLOPT_TIMEOUT         => 100,
            CURLOPT_CONNECTTIMEOUT  => 5
        ];

        $url = implode('', [$CS_API_URL, http_build_query($params)]);

        $request = curl_init($url);
        curl_setopt_array($request, $options);
        $result = json_decode(curl_exec($request), true)['CSResponse'];

        if (!empty($result['response'])) {
            if (!empty(reset($result['response'])['CSAccount']['userId'])) {
                $userObj = reset($result['response'])['CSAccount'];
                
                if($result['responseString'] == "Authenticated" && $result['errorCode'] === '0'){
                    $token = $this->get('lexik_jwt_authentication.encoder')->encode(['username' => $userObj['userName'] ]);
                    $response = new JWTAuthenticationSuccessResponse($token, $data);
                    $event    = new AuthenticationSuccessEvent(['token' => $token],  $user, $response);
                    $dispatcher->dispatch(Events::AUTHENTICATION_SUCCESS, $event);
                    $response->setData($event->getData());
echo "<br>";print_r($response);
exit;
                }

                /* return [
                    'auth'         => $result['errorCode'] === '0',
                    'status'       => $result['errorCode'],
                    'response'     => $result['responseString'],
                    'userId'       => $userObj['userId'],
                    'email'        => $userObj['email'],
                    'nameFirst'    => $userObj['nameFirst'],
                    'nameLast'     => $userObj['nameLast'],
                    'effectivegid' => $userObj['effectivegid'],
                    'accessLevel'  => $userObj['djoeAccessLevel'],
                    'freeIPAccess' => $result['responseString'] === 'FreeAccess',
                    'locked'       => $userObj['locked'],
                    'userType'     => $this->get_user_type(),
                    'appKey'       => $this->ci->encrypt->encode($userObj['userId'], self::APP_KEY),
                    'busind'       => !empty($userObj['busInd']) ? $userObj['busInd'] : null
                ]; */
            } else {
               return array_merge($this->user_obj, ['error' => $result['responseString']]);
            }
        } else {
            return array_merge($this->user_obj, ['error' => 'Unable to connect to Clickshare']);
        }
        exit;
    }

    public function userAuthenticationTest(Request $request)
    {
        return new Response("Test Authentications...!");
    }
    
    /*public function register(Request $request, UserPasswordEncoderInterface $encoder)
    {
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
        return new Response(sprintf('Logged in as %s', $this->getUser()->getUsername()));
    }*/
}
