<?php
namespace Seo\WhoopsBundle\Provider;

use Whoops\Handler\PrettyPageHandler;
use Whoops\Run;

class WhoopsProvider
{
    public function launch()
    {
        $whoops = new Run();
        $whoops->pushHandler(new PrettyPageHandler());
        $whoops->register();

        return $whoops;
    }
}
