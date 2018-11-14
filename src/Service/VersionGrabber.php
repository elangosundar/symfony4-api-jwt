<?php 

namespace App\Service;
use Symfony\Component\HttpFoundation\RequestStack;

class VersionGrabber  
{
    const DEFAULT_VERSION = 1;

    /**
     * @var RequestStack
     */
    private $requestStack;

    /**
     * @param RequestStack $requestStack
     */
    public function __construct(RequestStack $requestStack)
    {
        $this->requestStack = $requestStack;
    }

    /**
     * Get the current version used by the API.
     *
     * @return int
     */
    public function grabVersion()
    {
        return "2";
        //return DEFAULT_VERSION;
    }
}
