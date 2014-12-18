<?php
namespace Lemon\RestBundle\Serializer;

use JMS\Serializer\SerializationContext;
use Negotiation\FormatNegotiatorInterface;
use Symfony\Component\HttpFoundation\Request;

class JmsResourceSerializer implements ResourceSerializerInterface
{
    /**
     * @var ConstructorFactory
     */
    private $constructorFactory;

    /**
     * @var FormatNegotiatorInterface
     */
    private $formatNegotiator;

    /**
     * @param ConstructorFactory $constructorFactory
     * @param FormatNegotiatorInterface $formatNegotiator
     */
    public function __construct(
        ConstructorFactory $constructorFactory,
        FormatNegotiatorInterface $formatNegotiator)
    {
        $this->constructorFactory = $constructorFactory;
        $this->formatNegotiator = $formatNegotiator;
    }

    /**
     * @return ConstructorFactory
     */
    public function getConstructorFactory()
    {
        return $this->constructorFactory;
    }

    /**
     * @return FormatNegotiatorInterface
     */
    public function getFormatNegotiator()
    {
        return $this->formatNegotiator;
    }

    /**
     * @inheritdoc
     */
    public function serialize($data, $format, Request $request)
    {
        $context = SerializationContext::create();

        $accept = $this->getFormatNegotiator()->getBest($request->headers->get('Accept'));

        if ($accept->hasParameter('version')) {
            $context->setVersion($accept->getParameter('version'));
        }

        return $this->getConstructorFactory()->create('default')->serialize($data, $format, $context);
    }

    /**
     * @inheritdoc
     */
    public function deserialize($data, $type, $format, Request $request)
    {
        return $this->getConstructorFactory()->create(
            $request->isMethod('patch') ? 'doctrine' : 'default'
        )->deserialize(
            $request->getContent(),
            $type,
            $format
        );
    }
}
