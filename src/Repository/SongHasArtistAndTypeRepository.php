<?php

namespace App\Repository;

use App\Entity\SongHasArtistAndType;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<SongHasArtistAndType>
 *
 * @method SongHasArtistAndType|null find($id, $lockMode = null, $lockVersion = null)
 * @method SongHasArtistAndType|null findOneBy(array $criteria, array $orderBy = null)
 * @method SongHasArtistAndType[]    findAll()
 * @method SongHasArtistAndType[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class SongHasArtistAndTypeRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, SongHasArtistAndType::class);
    }

    public function add(SongHasArtistAndType $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(SongHasArtistAndType $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

//    /**
//     * @return SongHasArtistAndType[] Returns an array of SongHasArtistAndType objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('s')
//            ->andWhere('s.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('s.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?SongHasArtistAndType
//    {
//        return $this->createQueryBuilder('s')
//            ->andWhere('s.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
