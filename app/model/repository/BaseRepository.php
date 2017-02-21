<?php

namespace App\Model\Repository;

use App\Exceptions\NotFoundException;
use Nette;
use Kdyby\Doctrine\EntityManager;
use Kdyby\Doctrine\EntityRepository;
use Doctrine\Common\Collections\Criteria;

/**
 * Base repository which is used in all derived repositories.
 */
class BaseRepository extends Nette\Object
{
    /**
     * Doctrine entity manager.
     * @var EntityManager
     */
    protected $em;
    /**
     * Specific repository per instance.
     * @var EntityRepository
     */
    protected $repository;

    /**
     * Constructor.
     * @param EntityManager $em
     * @param string $entityType unique entity class name
     */
    public function __construct(EntityManager $em, $entityType)
    {
        $this->em = $em;
        $this->repository = $em->getRepository($entityType);
    }

    /**
     * Find one entity by its identification.
     * @param string $id
     * @return type|NULL
     */
    public function findOneById($id)
    {
        return $this->repository->findOneById($id);
    }

    /**
     * Find all entities which belong to this repository.
     * @return array|NULL
     */
    public function findAll()
    {
        return $this->repository->findAll();
    }

    /**
     * Find entities which fulfil given parameters and are ordered by given
     * columns.
     * @param array $params criteria
     * @param array $orderBy
     * @return array|NULL
     */
    public function findBy($params, $orderBy = [])
    {
        return $this->repository->findBy($params, $orderBy);
    }

    /**
     * Find one entity by given parameters.
     * @param array $params
     * @return array|NULL
     */
    public function findOneBy($params)
    {
        return $this->repository->findOneBy($params);
    }

    /**
     * Find one entity with given identification or throw exception.
     * @param string $id identification
     * @return entity
     * @throws NotFoundException if entity cannot be found
     */
    public function findOrThrow($id)
    {
        $entity = $this->findOneById($id);
        if (!$entity) {
            throw new NotFoundException("Cannot find '$id'");
        }
        return $entity;
    }

    /**
     * Count all entities within this repository.
     * @return int
     */
    public function countAll()
    {
        return $this->repository->countBy();
    }

    /**
     * Persist given entity into database.
     * @param entity $entity persisted entity
     * @param bool $autoFlush if true repository will be flushed
     */
    public function persist($entity, $autoFlush = true)
    {
        $this->em->persist($entity);
        if ($autoFlush === true) {
            $this->flush();
        }
    }

    /**
     * Remove given entity from database.
     * @param entity $entity removed entity
     * @param bool $autoFlush if true repository will be flushed
     */
    public function remove($entity, $autoFlush = true)
    {
        $this->em->remove($entity);
        if ($autoFlush === true) {
            $this->flush();
        }
    }

    /**
     * Flush repository.
     */
    public function flush()
    {
        $this->em->flush();
    }

    /**
     * Get entities matching given criteria.
     * @param Criteria $params
     * @return array|NULL
     */
    public function matching(Criteria $params)
    {
        return $this->repository->matching($params);
    }
}
