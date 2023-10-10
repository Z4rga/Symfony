<?php

namespace App\Repository;

use App\Entity\Author3;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Author3>
 *
 * @method Author3|null find($id, $lockMode = null, $lockVersion = null)
 * @method Author3|null findOneBy(array $criteria, array $orderBy = null)
 * @method Author3[]    findAll()
 * @method Author3[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class Author3Repository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Author3::class);
    }

//    /**
//     * @return Author3[] Returns an array of Author3 objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('a')
//            ->andWhere('a.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('a.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?Author3
//    {
//        return $this->createQueryBuilder('a')
//            ->andWhere('a.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
