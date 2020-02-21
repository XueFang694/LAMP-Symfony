<?php

namespace App\Repository;

use App\Entity\MaPremiereTable;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method MaPremiereTable|null find($id, $lockMode = null, $lockVersion = null)
 * @method MaPremiereTable|null findOneBy(array $criteria, array $orderBy = null)
 * @method MaPremiereTable[]    findAll()
 * @method MaPremiereTable[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class MaPremiereTableRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, MaPremiereTable::class);
    }

    // /**
    //  * @return MaPremiereTable[] Returns an array of MaPremiereTable objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('m')
            ->andWhere('m.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('m.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?MaPremiereTable
    {
        return $this->createQueryBuilder('m')
            ->andWhere('m.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
