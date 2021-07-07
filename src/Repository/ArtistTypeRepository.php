<?php

namespace App\Repository;

use App\Entity\ArtistType;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method ArtistType|null find($id, $lockMode = null, $lockVersion = null)
 * @method ArtistType|null findOneBy(array $criteria, array $orderBy = null)
 * @method ArtistType[]    findAll()
 * @method ArtistType[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ArtistTypeRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ArtistType::class);
    }

    // /**
    //  * @return ArtistType[] Returns an array of ArtistType objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('a')
            ->andWhere('a.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('a.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?ArtistType
    {
        return $this->createQueryBuilder('a')
            ->andWhere('a.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
