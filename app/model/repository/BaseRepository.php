<?php

namespace App\Model\Repository;

use App\Exceptions\NotFoundException;
use Nette;
use Kdyby\Doctrine\EntityManager;
use Kdyby\Doctrine\EntityRepository;

class BaseRepository extends Nette\Object
{
    /**
     * @var EntityManager
     */
    protected $em;
    /**
     * @var EntityRepository
     */
    protected $repository;

    public function __construct(EntityManager $em, $entityType)
    {
        $this->em = $em;
        $this->repository = $em->getRepository($entityType);
    }

    public function get($id)
    {
        return $this->repository->findOneById($id);
    }

    public function findAll()
    {
        return $this->repository->findAll();
    }

    public function findBy($params, $orderBy = [])
    {
        return $this->repository->findBy($params, $orderBy);
    }

    public function findOneBy($params)
    {
        return $this->repository->findOneBy($params);
    }

    public function findOrThrow($id)
    {
        $entity = $this->get($id);
        if (!$entity) {
            throw new NotFoundException("Cannot find '$id'");
        }
        return $entity;
    }

    public function countAll()
    {
        return $this->repository->countBy();
    }

    public function persist($entity, $autoFlush = true)
    {
        $this->em->persist($entity);
        if ($autoFlush === true) {
            $this->flush();
        }
    }

    public function remove($entity, $autoFlush = true)
    {
        $this->em->remove($entity);
        if ($autoFlush === true) {
            $this->flush();
        }
    }

    public function flush()
    {
        $this->em->flush();
    }

    public function matching(Criteria $params)
    {
        return $this->repository->matching($params);
    }
}