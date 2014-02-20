<?php
/**
 * @author Mickaël Andrieu <mickael.andrieu@sensiolabs.com>
 */
namespace Am\WhoopsBundle\EventListener;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Event\GetResponseForExceptionEvent;
use Symfony\Component\HttpKernel\Event\FilterResponseEvent;
use Symfony\Component\HttpKernel\KernelEvents;
use Am\WhoopsBundle\Provider\WhoopsProvider;

class ExceptionListener
{
    protected $dispatcher;
    protected $whoopsProvider;

    public function __construct(WhoopsProvider $whoopsProvider)
    {
        $this->whoopsProvider = $whoopsProvider;
    }

    public function onKernelException(GetResponseForExceptionEvent $event)
    {
        $exception = $event->getException();
        $whoops = $this->whoopsProvider->launch($event->getRequest(), $exception->getStatusCode());
        $whoopsResponse = $whoops->handleException($exception);
        $event->setResponse(new Response($whoopsResponse));

        $filterEvent = new FilterResponseEvent($event->getKernel(), $event->getRequest(), $event->getRequestType(), $event->getResponse());
        $event->getDispatcher()->dispatch(KernelEvents::TERMINATE, $filterEvent);
    }
}
