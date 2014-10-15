<?php
namespace Lemon\RestBundle\Serializer;

use JMS\Serializer\Context;
use JMS\Serializer\GenericSerializationVisitor;

class HtmlSerializationVisitor extends GenericSerializationVisitor
{
    public function getResult()
    {
        $htmlRenderer = new HtmlRenderer();
        return $htmlRenderer->render($this->getRoot());
    }

    public function visitNull($data, array $type, Context $context)
    {
        return '<em>null</em>';
    }
}
