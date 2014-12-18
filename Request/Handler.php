<?php

namespace Lemon\RestBundle\Request;

use JMS\Serializer\SerializationContext;
use JMS\Serializer\SerializerInterface;
use Lemon\RestBundle\Object\Envelope\EnvelopeFactory;
use Lemon\RestBundle\Object\Exception\InvalidException;
use Lemon\RestBundle\Object\Exception\NotFoundException;
use Lemon\RestBundle\Object\Registry;
use Lemon\RestBundle\Object\Repository\RepositoryInterface;
use Lemon\RestBundle\Serializer\ConstructorFactory;
use Negotiation\FormatNegotiatorInterface;
use Psr\Log\LoggerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\HttpException;

class Handler
{
    /**
     * @var RepositoryInterface
     */
    protected $repository;

    /**
     * @var Registry
     */
    protected $registry;

    /**
     * @var EnvelopeFactory
     */
    protected $envelopeFactory;

    /**
     * @var ConstructorFactory
     */
    protected $serializer;

    /**
     * @var \Negotiation\FormatNegotiatorInterface
     */
    protected $negotiator;

    /**
     * @var LoggerInterface
     */
    protected $logger;

    /**
     * @param RepositoryInterface $repository
     * @param Registry $registry
     * @param EnvelopeFactory $envelopeFactory
     * @param SerializerInterface $serializer
     * @param FormatNegotiatorInterface $negotiator
     * @param LoggerInterface $logger
     */
    public function __construct(
        RepositoryInterface $repository,
        Registry $registry,
        EnvelopeFactory $envelopeFactory,
        ConstructorFactory $serializer,
        FormatNegotiatorInterface $negotiator,
        LoggerInterface $logger
    ) {
        $this->repository = $repository;
        $this->registry = $registry;
        $this->envelopeFactory = $envelopeFactory;
        $this->serializer = $serializer;
        $this->negotiator = $negotiator;
        $this->logger = $logger;
    }

    /**
     * @param Request $request
     * @param Response $response
     * @param string $resource
     * @param \Closure $callback
     * @return Response
     */
    public function handle(Request $request, Response $response, $resource, $callback)
    {
        $accept = $this->negotiator->getBest($request->headers->get('Accept'));

        $format = $this->negotiator->getFormat($accept->getValue());
        
        if ($format == 'html') {
            $format = 'json';
        }

        $response->headers->set('Content-Type', $accept->getValue());

        $class = $this->registry->getClass($resource);

        try {
            $this->repository->setClass($class);

            $object = $this->serializer->create(
                $request->isMethod('patch') ? 'doctrine' : 'default'
            )->deserialize(
                $request->getContent(),
                $class,
                $format
            );

            $data = $this->envelopeFactory->create(
                $callback($this->repository, $object)
            )->export();
        } catch (InvalidException $e) {
            $response->setStatusCode(400);
            $data = array(
                "code" => 400,
                "message" => $e->getMessage(),
                "errors" => $e->getErrors(),
            );
        } catch (NotFoundException $e) {
            $response->setStatusCode(404);
            $data = array(
                "code" => 404,
                "message" => $e->getMessage(),
            );
        } catch (HttpException $e) {
            $response->setStatusCode($e->getStatusCode());
            $data = array(
                "code" => $e->getStatusCode(),
                "message" => $e->getMessage(),
            );
        } catch (\Exception $e) {
            $this->logger->critical($e);

            $response->setStatusCode(500);
            $data = array(
                "code" => 500,
                "message" => $e->getMessage(),
            );
        }

        $context = SerializationContext::create();

        if ($accept->hasParameter('version')) {
            $context->setVersion($accept->getParameter('version'));
        }

        $output = $this->serializer->create('default')->serialize($data, $format, $context);

        $response->setContent($output);

        return $response;
    }
}
