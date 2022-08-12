<?php

namespace App\Repository;

use App\Entity\CustomerUser;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<CustomerUser>
 *
 * @method CustomerUser|null find($id, $lockMode = null, $lockVersion = null)
 * @method CustomerUser|null findOneBy(array $criteria, array $orderBy = null)
 * @method CustomerUser[]    findAll()
 * @method CustomerUser[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CustomerUserRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, CustomerUser::class);
    }

    /**
     * @param CustomerUser $entity
     * @param bool $flush
     * @return void
     */
    public function add(CustomerUser $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    /**
     * @param CustomerUser $entity
     * @param bool $flush
     * @return void
     */
    public function remove(CustomerUser $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }
}
