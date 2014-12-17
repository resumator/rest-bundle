<?php
namespace Lemon\RestBundle\Object\Repository;

use Lemon\RestBundle\Event\ObjectEvent;
use Lemon\RestBundle\Event\PostSearchEvent;
use Lemon\RestBundle\Event\PreSearchEvent;
use Lemon\RestBundle\Event\RestEvents;
use Symfony\Component\EventDispatcher\EventDispatcher;

class EventAwareRepository implements RepositoryInterface
{
    /**
     * @var RepositoryInterface
     */
    private $repository;

    /**
     * @var EventDispatcher
     */
    private $eventDispatcher;

    /**
     * @param RepositoryInterface $repository
     * @param EventDispatcher $eventDispatcher
     */
    public function __construct(
        RepositoryInterface $repository,
        EventDispatcher $eventDispatcher)
    {
        $this->repository = $repository;
        $this->eventDispatcher = $eventDispatcher;
    }

    /**
     * @return RepositoryInterface
     */
    public function getRepository()
    {
        return $this->repository;
    }

    /**
     * @return EventDispatcher
     */
    public function getEventDispatcher()
    {
        return $this->eventDispatcher;
    }

    /**
     * @inheritdoc
     */
    public function setClass($class)
    {
        return $this->repository->setClass($class);
    }

    /**
     * @inheritdoc
     */
    public function getClass()
    {
        return $this->repository->getClass();
    }

    /**
     * @inheritdoc
     */
    public function search(array $criteria)
    {
        $this->eventDispatcher->dispatch(RestEvents::PRE_SEARCH, new PreSearchEvent($criteria));

        $results = $this->repository->search($criteria);

        $this->eventDispatcher->dispatch(RestEvents::POST_SEARCH, new PostSearchEvent($results));

        return $results;
    }

    /**
     * @inheritdoc
     */
    public function create($object)
    {
        $this->eventDispatcher->dispatch(RestEvents::PRE_CREATE, new ObjectEvent($object));

        $object = $this->repository->create($object);

        $this->eventDispatcher->dispatch(RestEvents::POST_CREATE, new ObjectEvent($object));

        return $object;
    }

    /**
     * @inheritdoc
     */
    public function retrieve($id)
    {
        return $this->repository->retrieve($id);
    }

    /**
     * @inheritdoc
     */
    public function update($object)
    {
        // TODO: How can we get the original object into the event?

        $this->eventDispatcher->dispatch(RestEvents::PRE_UPDATE, new ObjectEvent($object/*, $original*/));

        $this->repository->update($object);

        $this->eventDispatcher->dispatch(RestEvents::POST_UPDATE, new ObjectEvent($object/*, $original*/));

        return $object;
    }

    /**
     * @inheritdoc
     */
    public function partialUpdate($object)
    {
        return $this->repository->partialUpdate($object);
    }

    /**
     * @inheritdoc
     */
    public function delete($id)
    {
        $object = $this->retrieve($id);

        $this->eventDispatcher->dispatch(RestEvents::PRE_DELETE, new ObjectEvent($object));

        $this->repository->delete($id);

        $this->eventDispatcher->dispatch(RestEvents::POST_DELETE, new ObjectEvent($object));
    }
}
