<?php

namespace App\Repository;

use App\Entity\PresenceEleve;
use DateTime;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<PresenceEleve>
 *
 * @method PresenceEleve|null find($id, $lockMode = null, $lockVersion = null)
 * @method PresenceEleve|null findOneBy(array $criteria, array $orderBy = null)
 * @method PresenceEleve[]    findAll()
 * @method PresenceEleve[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PresenceEleveRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, PresenceEleve::class);
    }

    public function add(PresenceEleve $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(PresenceEleve $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    

    public function findByToday(string $date, string $date2)
    {
        $entityManager = $this->getEntityManager();

        $query = $entityManager->createQuery(
            'SELECT p
            FROM App\Entity\PresenceEleve p
            WHERE p.date
            BETWEEN :date1 
            AND :datebe
            '
        )->setParameter('date1', $date)
        ->setParameter('datebe', $date2);

        // returns an array of Product objects
        return $query->getResult();
    }

//    /**
//     * @return PresenceEleve[] Returns an array of PresenceEleve objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('p')
//            ->andWhere('p.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('p.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?PresenceEleve
//    {
//        return $this->createQueryBuilder('p')
//            ->andWhere('p.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
