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
        echo "leaf==>".$request->request->get('userName');
        return array(
            'token' => $request->headers->get('X-AUTH-TOKEN'),
            'userName' => "Elangovan"
        );
    }

    /**
     * Called on every request to decide if this authenticator should be
     * used for the request. Returning false will cause this authenticator
     * to be skipped.
     */
    public function supports(Request $request)
    {
        //echo 'first ===>';exit;
        return $request->headers->has('X-AUTH-TOKEN');
    }

    public function getUser($credentials, UserProviderInterface $userProvider )
    {
        $apiToken = $credentials['token'];
        $username = $credentials['userName'];
echo "<br>===>".$apiToken;
        if (null === $apiToken) {
            return;
        }
print_R($credentials);
//return;
        $aa = new User($username);
        print_R($aa);
        return $aa;
       
        // $data = $this->jwtEncoder->decode($credentials);
        
        // if (!$data) {
        //     return;
        // }

        // $username = $data['username'];
        
        // $login = $this->em->getRepository($this->loginRepo)
        //             ->findOneBy([
        //                 $this->loginUser => $username
        //             ]);
        
        // $user = new UserDecorator($login);
        
        // if (!$user) {
        //     return;
        // } else {
        //     return $user;
        // }
    }
    
    public function checkCredentials($credentials, UserInterface $user)
    {
        // check credentials - e.g. make sure the password is valid
        // no credential check is needed in this case
        // echo "hey leaf==>";print_R($user);
        // echo $cc;
        // return true to cause authentication success
        return true;
    }

    public function onAuthenticationSuccess(Request $request, TokenInterface $token, $providerKey)
    {
        //echo "<br>".$token;
        echo "<br> <====>".$providerKey;
        //echo '<br>Leafffff';exit;
        // on success, let the request continue
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
