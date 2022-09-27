<?php
/**
 * Julien Rajerison <julienrajerison5@gmail.com>.
 **/

namespace App\Repository;

use App\Entity\User;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method User|null find($id, $lockMode = null, $lockVersion = null)
 * @method User|null findOneBy(array $criteria, array $orderBy = null)
 * @method User[]    findAll()
 * @method User[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class UserRepository extends ServiceEntityRepository
{
    /**
     * UserRepository constructor.
     *
     * @param ManagerRegistry $registry
     */
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, User::class);
    }

    /**
     * @param string $role
     * @param string $etsName
     *
     * @return User[] Returns an array of User objects
     */
    public function findByRoles(string $role, string $etsName)
    {
        return $this->createQueryBuilder('u')
            ->where('u.roles LIKE :role')
            ->andWhere('u.etsName = :etsName')
            ->andWhere('u.deletedAt is NULL')
            ->setParameter('role', '%"'.$role.'"%')
            ->setParameter('etsName', $etsName)
            ->orderBy('u.id', 'ASC')
            ->getQuery()
            ->getResult();
    }

    public function findByImmatriculation(String $im)
    {
        return $this->createQueryBuilder('s')
            ->where('s.imatriculation = :im')
            
            
            
            
            ->setParameter('im', $im)
            
            ->getQuery()
            ->getResult();
    }

    public function findbyTypeRole(string $role)
    {
        return $this->createQueryBuilder('s')

            ->where('s.roles LIKE :role')
           
            ->setParameter('role', '%"'.$role.'"%')
            ->getQuery()
            ->getResult();
    }

    public function findBySession(string $session, string $role)
    {
        return $this->createQueryBuilder('s')

            ->where('s.Session LIKE :session')
            ->andWhere('s.roles LIKE :role')
            ->setParameter('role', '%"'.$role.'"%')
            ->setParameter('session', $session)
            ->getQuery()
            ->getResult();
    }
}
