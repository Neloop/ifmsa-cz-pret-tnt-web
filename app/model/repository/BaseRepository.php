<?php

namespace App\Model\Repository;

use App\Exceptions\NotFoundException;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityRepository;

/**
 * Base repository which is used in all derived repositories.
 *
 * @template T
 */
abstract class BaseRepository
{
    /**
     * Doctrine entity manager.
     * @var EntityManagerInterface
     */
    protected $em;
    /**
     * Specific repository per instance.
     * @var EntityRepository<T>
     */
    protected $repository;

    /**
     * Constructor.
     * @param EntityManagerInterface $em
     * @param string $entityType unique entity class name
     */
    public function __construct(EntityManagerInterface $em, string $entityType)
    {
        $this->em = $em;
        /** @var EntityRepository $repository */
        /** @var class-string $entityType */
        $repository = $em->getRepository($entityType);
        $this->repository = $repository;
    }

    /**
     * Find one entity by its identification.
     * @param string $id
     * @return object|null
     */
    public function findOneById(string $id)
    {
        return $this->repository->find($id);
    }

    /**
     * Find all entities which belong to this repository.
     * @return array<object>
     */
    public function findAll(): array
    {
        return $this->repository->findAll();
    }

    /**
     * Find entities which fulfil given parameters and are ordered by given
     * columns.
     * @param array<string, string> $params criteria
     * @param ?array<string, string> $orderBy
     * @return array<object>
     */
    public function findBy(array $params, ?array $orderBy = []): ?array
    {
        return $this->repository->findBy($params, $orderBy);
    }

    /**
     * Find one entity by given parameters.
     * @param array<string, string> $params
     * @return object|null
     */
    public function findOneBy(array $params)
    {
        return $this->repository->findOneBy($params);
    }

    /**
     * Find one entity with given identification or throw exception.
     * @param string $id identification
     * @return object|null
     * @throws NotFoundException if entity cannot be found
     */
    public function findOrThrow(string $id)
    {
        $entity = $this->findOneById($id);
        if (!$entity) {
            throw new NotFoundException("Cannot find '$id'");
        }
        return $entity;
    }

    /**
     * Count elements which fulfil given criteria.
     * @param array<string, string> $criteria
     * @return int
     */
    public function countBy(array $criteria): int
    {
        return $this->repository->count($criteria);
    }

    /**
     * Count all entities within this repository.
     * @return int
     */
    public function countAll(): int
    {
        return $this->repository->count([]);
    }

    /**
     * Persist given entity into database.
     * @param object $entity persisted entity
     * @param bool $autoFlush if true repository will be flushed
     */
    public function persist($entity, $autoFlush = true): void
    {
        $this->em->persist($entity);
        if ($autoFlush === true) {
            $this->flush();
        }
    }

    /**
     * Remove given entity from database.
     * @param object $entity removed entity
     * @param bool $autoFlush if true repository will be flushed
     */
    public function remove($entity, $autoFlush = true): void
    {
        $this->em->remove($entity);
        if ($autoFlush === true) {
            $this->flush();
        }
    }

    /**
     * Flush repository.
     */
    public function flush(): void
    {
        $this->em->flush();
    }
}
