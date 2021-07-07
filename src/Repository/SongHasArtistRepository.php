<?php

namespace App\Repository;

use App\Entity\SongHasArtist;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method SongHasArtist|null find($id, $lockMode = null, $lockVersion = null)
 * @method SongHasArtist|null findOneBy(array $criteria, array $orderBy = null)
 * @method SongHasArtist[]    findAll()
 * @method SongHasArtist[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class SongHasArtistRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, SongHasArtist::class);
    }

    // /**
    //  * @return SongHasArtist[] Returns an array of SongHasArtist objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('s')
            ->andWhere('s.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('s.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?SongHasArtist
    {
        return $this->createQueryBuilder('s')
            ->andWhere('s.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
