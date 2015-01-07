<?php
namespace Lemon\RestBundle\Search;

use Lemon\RestBundle\Event\PreSearchEvent;

class EventListener
{
    protected $container;

    public function setContainer($container)
    {
        $this->container = $container;
        return $this;
    }

    protected function getContainer()
    {
        return $this->container;
    }

    public function onPreSearchEvent(PreSearchEvent $event)
    {
        $adapter = $this->getContainer()->getParameter('lemon_rest.search_adapter');
        if(!is_null($adapter)) {

        }
    }
}
