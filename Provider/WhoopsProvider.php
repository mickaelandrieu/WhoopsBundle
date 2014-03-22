<?php
namespace Am\WhoopsBundle\Provider;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Whoops\Handler\PrettyPageHandler;
use Whoops\Run;

class WhoopsProvider
{
    protected $resourcesPath;

    public function __construct($resourcesPath)
    {
        $this->resourcesPath = $resourcesPath;
    }

    public function launch(Request $request, $statusCode)
    {
        $whoops = new Run();
        $symfonyHandler = new PrettyPageHandler();

        $symfonyHandler->addDataTable('Symfony Application', array(
            'Status'        => $this->getSessionStatus($statusCode),
            'Route'         => $request->get('_route'),
            'Controller'    => $request->get('_controller'),
            'Session'       => $this->hasSession($request->hasSession())
        ));
        $symfonyHandler->setResourcesPath($this->resourcesPath);
        $whoops->pushHandler($symfonyHandler);
        $whoops->writeToOutput(false);
        $whoops->allowQuit(false);
        $whoops->register();

        return $whoops;
    }

    private function hasSession($boolean)
    {
        return $boolean == true ? 'true' : 'false';
    }

    private function getSessionStatus($statusCode)
    {
        return $statusCode .' : ' . Response::$statusTexts[$statusCode];
    }

    /**
     * Get the Whoops resources path.
     */
    public function getResourcesPath()
    {
        return $this->resourcesPath;
    }
}
