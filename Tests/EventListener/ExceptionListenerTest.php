<?php
namespace Am\WhoopsBundle\Tests\EventListener;

use Am\WhoopsBundle\EventListener\ExceptionListener;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Kernel\Kernel;
use Symfony\Component\EventDispatcher\EventDispatcher;
use Whoops\Run;

class ExceptionListenerTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var ExceptionListener
     *
     * The listener to be unit tested
     **/
    private $exceptionListener;
    private $event;
    private $whoopsProvider;
    private $whoopsRun;
    private $kernel;

    public function testOnKernelException()
    {
        $this->event
            ->expects($this->once())
            ->method('getException')
            ->will($this->returnValue(new NotFoundHttpException()))
        ;

        $this->event
            ->expects($this->exactly(2))
            ->method('getRequest')
            ->will($this->returnValue(new Request()))
        ;

        $this->event
            ->expects($this->once())
            ->method('getKernel')
            ->will($this->returnValue($this->kernel))
        ;

        $this->whoopsProvider
            ->expects($this->once())
            ->method('handleException')
            ->will($this->returnValue('foo'))
        ;

        $this->event
            ->expects($this->once())
            ->method('setResponse')
            ->will($this->returnValue($this->whoopsProvider->handleException()))
        ;

        $this->event
            ->expects($this->once())
            ->method('getResponse')
            ->will($this->returnValue(new Response('foo')))
        ;

        $this->event
            ->expects($this->once())
            ->method('getDispatcher')
            ->will($this->returnValue(new EventDispatcher()))
        ;

        $this->whoopsProvider
            ->expects($this->once())
            ->method('launch')
            ->will($this->returnValue($this->whoopsRun))
        ;

        $this->listener->onKernelException($this->event);
    }

    protected function setUp()
    {
        $this->event = $this
            ->getMockBuilder('Symfony\Component\HttpKernel\Event\GetResponseForExceptionEvent')
            ->disableOriginalConstructor()
            ->setMethods(array(
                'getException',
                'getKernel',
                'getRequest',
                'getRequestType',
                'getDispatcher',
                'getResponse',
                'setResponse'
                )
            )
            ->getMock()
        ;

        $this->whoopsProvider = $this
            ->getMockBuilder('Am\WhoopsBundle\Provider\WhoopsProvider')
            ->disableOriginalConstructor()
            ->setMethods(array('launch', 'handleException'))
            ->getMock()
        ;

        $this->whoopsRun = new Run();

        $this->kernel = $this
            ->getMockBuilder('Symfony\Component\HttpKernel\HttpKernel')
            ->disableOriginalConstructor()
            ->getMock()
        ;

        $this->listener = new ExceptionListener($this->whoopsProvider);
    }

    protected function tearDown()
    {
        $this->event = null;
        $this->listener = null;
        $this->whoopsProvider = null;
        $this->whoopsRun = null;
        $this->kernel = null;
    }
}
