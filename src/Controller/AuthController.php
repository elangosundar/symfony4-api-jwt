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
use App\Security\UserProvider;

// use App\Security\WebserviceUser;
// use App\Security\WebserviceUserProvider;

use Symfony\Component\Security\Core\User\UserProviderInterface;
use Lexik\Bundle\JWTAuthenticationBundle\Services\JWTManagerInterface;

class AuthController extends FOSRestController
{
    // /**
    //  * @var UserProviderInterface
    //  */
    // protected $userProvider;

    // /**
    //  * @var JWTManagerInterface
    //  */
    // protected $jwtManager;

    // /**
    //  * @var EventDispatcherInterface
    //  */
    // protected $dispatcher;

    // /**
    //  * @var string
    //  */
    // protected $userIdentityField;

    // /**
    //  * @var string
    //  */
    // private $userIdClaim;

    // /**
    //  * @param UserProviderInterface    $userProvider
    //  * @param JWTManagerInterface      $jwtManager
    //  * @param EventDispatcherInterface $dispatcher
    //  * @param string                   $userIdClaim
    //  */
    // public function __construct(
    //     UserProviderInterface $userProvider,
    //     //JWTManagerInterface $jwtManager,
    //     EventDispatcherInterface $dispatcher
    //     //$userIdClaim
    // ) {
    //     $this->userProvider      = $userProvider;
    //     //$this->jwtManager        = $jwtManager;
    //     $this->dispatcher        = $dispatcher;
    //     $this->userIdentityField = 'username';
    //     //$this->userIdClaim       = $userIdClaim;
    // }
    
    public function userAuthenticationVerify(User $user, EventDispatcherInterface $dispatcher ){
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
                    return $response;
                }
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
}
