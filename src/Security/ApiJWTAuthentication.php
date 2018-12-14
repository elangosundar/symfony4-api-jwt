<?php 
namespace App\Security;

use App\Security\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Guard\AbstractGuardAuthenticator;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Exception\AuthenticationException;
use Symfony\Component\Security\Core\User\UserProviderInterface;
use Lexik\Bundle\JWTAuthenticationBundle\Encoder\DefaultEncoder;
use Lexik\Bundle\JWTAuthenticationBundle\TokenExtractor\AuthorizationHeaderTokenExtractor;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

use FOS\RestBundle\View\View;
use FOS\RestBundle\Controller\Annotations as FOSRest;
use FOS\RestBundle\Controller\FOSRestController;

use FOS\RestBundle\Controller\Annotations\Version;

use Lexik\Bundle\JWTAuthenticationBundle\Response\JWTAuthenticationSuccessResponse;
use Lexik\Bundle\JWTAuthenticationBundle\Event\AuthenticationSuccessEvent;

use Lexik\Bundle\JWTAuthenticationBundle\Event;

use Lexik\Bundle\JWTAuthenticationBundle\Events;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;

use App\Security\UserProvider;
use Lexik\Bundle\JWTAuthenticationBundle\Services\JWTManagerInterface;
use Symfony\Component\Security\Core\Exception\CustomUserMessageAuthenticationException;


class ApiJWTAuthentication extends AbstractGuardAuthenticator
{
    private $jwtEncoder;

    public function __construct(DefaultEncoder $jwtEncoder)
    {
        $this->jwtEncoder = $jwtEncoder;
    }

    /**
     * Called when authentication is needed, but it's not sent
     */
    public function start(Request $request, AuthenticationException $authException = null)
    {
        $data = array(
            'message' => 'Authentication Required'
        );

        return new JsonResponse($data, Response::HTTP_UNAUTHORIZED);
    }

    /**
     * Called on every request. Return whatever credentials you want to
     * be passed to getUser() as $credentials.
     */
    public function getCredentials(Request $request)
    {
        try {
            $extractor = new AuthorizationHeaderTokenExtractor(
                'Bearer',
                'Authorization'
            );
            
            $token = $extractor->extract($request);
            $tokenName = $this->jwtEncoder->decode($token);

            if(!$tokenName){
                return null;
            }

            return array(
                'token' => $token,
                'userName' => $tokenName["username"]
            );

        } catch (\CustomUserMessageAuthenticationException $e) {
            //throw new CustomUserMessageAuthenticationException($e->getMessage(), 0, $e);
            throw new \Symfony\Component\Security\Core\Exception\BadCredentialsException($e->getMessage(), 0, $e);
        }
    }

    /**
     * Called on every request to decide if this authenticator should be
     * used for the request. Returning false will cause this authenticator
     * to be skipped.
     */
    public function supports(Request $request)
    {
        return $request->headers->has('Authorization');
    }

    public function getUser($credentials, UserProviderInterface $userProvider )
    {
        $userProviderName =  $userProvider->loadUserByUsername($credentials['userName']);
        $apiToken = $credentials['token'];

        if (null === $apiToken) {
            return;
        }

        $userObject = new User();
        return $userObject;
    }
    
    public function checkCredentials($credentials, UserInterface $user)
    {
        return true;
    }

    public function onAuthenticationSuccess(Request $request, TokenInterface $token, $providerKey)
    {
        return null;
    }

    public function onAuthenticationFailure(Request $request, AuthenticationException $exception)
    {
        $data = array(
            'message' => strtr($exception->getMessageKey(), $exception->getMessageData())
        );

        return new JsonResponse($data, Response::HTTP_FORBIDDEN);
    }

    public function supportsRememberMe()
    {
        return false;
    }
}
