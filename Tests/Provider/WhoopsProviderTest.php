<?php
namespace Am\WhoopsBundle\Tests\Provider;

use Am\WhoopsBundle\Provider\WhoopsProvider;

class WhoopsProviderTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var WhoopsProvider
     *
     * The provider to be unit tested
     **/
    private $whoopsProvider;
    private $resourcesPath;
    private $request;

    public function testLaunch()
    {
        $this->request
            ->expects($this->exactly(2))
            ->method('get')
            ->with($this->logicalOr(
                 $this->equalTo('_route'),
                 $this->equalTo('_controller')
             ))
            ->will($this->returnCallback(array($this, 'returnRequestValue')))
        ;

        $this->request
            ->expects($this->once())
            ->method('hasSession')
            ->will($this->returnValue(true))
        ;

        $result = $this->whoopsProvider->launch($this->request, 404);

        $this->assertInstanceOf('Whoops\Run', $result);
    }

    public function testGetResourcesPath()
    {
        $this->assertSame($this->whoopsProvider->getResourcesPath(), $this->resourcesPath);
    }

    protected function setUp()
    {
        $this->resourcesPath = __DIR__.'/../';
        $this->whoopsProvider = new WhoopsProvider($this->resourcesPath);
        $this->request = $this
            ->getMockBuilder('Symfony\Component\HttpFoundation\Request')
            ->setMethods(array('get','hasSession'))
            ->getMock()
        ;
    }

    protected function tearDown()
    {
        $this->resourcesPath = null;
        $this->whoopsProvider = null;
        $this->request = null;
    }

    public function returnRequestValue($key)
    {
        return '';
    }
}
