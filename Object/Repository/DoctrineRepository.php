<?php
namespace Lemon\RestBundle\Object\Repository;

use Doctrine\Bundle\DoctrineBundle\Registry as Doctrine;
use Lemon\RestBundle\Criteria\CollectionFilterCriteriaInterface;
use Lemon\RestBundle\Criteria\CriteriaInterface;
use Lemon\RestBundle\Model\SearchResults;
use Lemon\RestBundle\Object\Exception\NotFoundException;

class DoctrineRepository implements RepositoryInterface
{
    /**
     * @var Doctrine
     */
    private $doctrine;

    /**
     * @var string
     */
    private $class;

    /**
     * @param Doctrine $doctrine
     */
    public function __construct(Doctrine $doctrine)
    {
        $this->doctrine = $doctrine;
    }

    /**
     * @return \Doctrine\Common\Persistence\ObjectManager|object
     */
    private function getManager()
    {
        return $this->doctrine->getManagerForClass($this->class);
    }

    /**
     * @return \Doctrine\Common\Persistence\ObjectRepository
     */
    private function getRepository()
    {
        return $this->getManager()->getRepository($this->class);
    }

    /**
     * @inheritdoc
     */
    public function setClass($class)
    {
        $this->class = $class;
    }

    /**
     * @inheritdoc
     */
    public function getClass()
    {
        return $this->class;
    }

    /**
     * @inheritdoc
     */
    public function search(array $criteria)
    {
        /** @var \Doctrine\ORM\QueryBuilder $qb */
        $qb = $this->getManager()->createQueryBuilder('o');

        $qb
            ->select($qb->expr()->count('o'))
            ->from($this->class, 'o');

        $nonFilterCriteria = array();

        /** @var CriteriaInterface $criterion */
        foreach ($criteria as $criterion) {
            if ($criteria instanceof CollectionFilterCriteriaInterface) {
                $criterion->asDoctrine($qb, 'o');
            } else {
                $nonFilterCriteria[] = $criterion;
            }
        }

        $query = $qb->getQuery();

        $total = $query->getSingleScalarResult();

        $qb->select('o');

        foreach ($nonFilterCriteria as $criterion) {
            $criterion->asDoctrine($qb, 'o');
        }

        $query = $qb->getQuery();

        $objects = $query->execute();

        $results = new SearchResults($objects, $total);

        return $results;
    }

    /**
     * @inheritdoc
     */
    public function create($object)
    {
        $em = $this->getManager();

        $em->persist($object);
        $em->flush();
        $em->refresh($object);

        return $object;
    }

    /**
     * @inheritdoc
     */
    public function retrieve($id)
    {
        if (!($object = $this->getRepository()->findOneBy(array('id' => $id)))) {
            throw new NotFoundException("Object not found");
        }

        return $object;
    }

    /**
     * @inheritdoc
     */
    public function update($object)
    {
        $em = $this->getManager();

        $object = $em->merge($object);

        $em->persist($object);
        $em->flush();
        $em->refresh($object);

        return $object;
    }

    /**
     * @inheritdoc
     */
    public function partialUpdate($object)
    {
        /** @var \Doctrine\ORM\EntityManager $em */
        $em = $this->getManager();

        $em->persist($object);
        $em->flush();
        $em->refresh($object);

        return $object;
    }

    /**
     * @inheritdoc
     */
    public function delete($id)
    {
        $object = $this->retrieve($id);

        $em = $this->getManager();

        $em->remove($object);
        $em->flush();
    }
}
