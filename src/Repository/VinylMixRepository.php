<?php

namespace App\Repository;

use App\Entity\VinylMix;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\ORM\QueryBuilder;

/**
 * @extends ServiceEntityRepository<VinylMix>
 *
 * @method VinylMix|null find($id, $lockMode = null, $lockVersion = null)
 * @method VinylMix|null findOneBy(array $criteria, array $orderBy = null)
 * @method VinylMix[]    findAll()
 * @method VinylMix[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class VinylMixRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, VinylMix::class);
    }

    public function add(VinylMix $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(VinylMix $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

   /**
    * @return VinylMix[] Returns an array of VinylMix objects
    */
   public function findAllOrderedByVotes(string $genre = null): array
   {
    //    $queryBuilder = $this->createQueryBuilder('mix')
    //         ->orderBy('mix.votes', 'DESC');

        $queryBuilder = $this->addOrderByVotesQueryBuilder();


        if ($genre) {
            $queryBuilder->andWhere('mix.genre = :genre')
            ->setParameter('genre', $genre);
        }

        return $queryBuilder
            ->getQuery()
            ->getResult();
       ;
   }

   /**
    *     this returns QueryBuilder instead of results
    */

    public function createOrderedByVotesQueryBuilder(string $genre = null): QueryBuilder
    {
        $queryBuilder = $this->addOrderByVotesQueryBuilder();
        if ($genre) {
            $queryBuilder->andWhere('mix.genre = :genre')
            ->setParameter('genre', $genre);
        }

        return $queryBuilder;
    }

   private function addOrderByVotesQueryBuilder(QueryBuilder $queryBuilder = null): QueryBuilder
   {
        $queryBuilder = $queryBuilder ?? $this->createQueryBuilder('mix');

        return $queryBuilder->orderBy('mix.votes', 'DESC');
   }

//    public function findOneBySomeField($value): ?VinylMix
//    {
//        return $this->createQueryBuilder('v')
//            ->andWhere('v.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
