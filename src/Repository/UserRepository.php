<?php

namespace App\Repository;

use App\Entity\User;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\Security\Core\Exception\UnsupportedUserException;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\PasswordUpgraderInterface;

/**
 * @method User|null find($id, $lockMode = null, $lockVersion = null)
 * @method User|null findOneBy(array $criteria, array $orderBy = null)
 * @method User[]    findAll()
 * @method User[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 * @method User|null lastId()
 * @method User|null getAll()
 * @method User|null rechercherEmploye($value)
 */
class UserRepository extends ServiceEntityRepository implements PasswordUpgraderInterface
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, User::class);
    }

    /**
     * Used to upgrade (rehash) the user's password automatically over time.
     */
    public function upgradePassword(PasswordAuthenticatedUserInterface $user, string $newHashedPassword): void
    {
        if (!$user instanceof User) {
            throw new UnsupportedUserException(sprintf('Instances of "%s" are not supported.', \get_class($user)));
        }

        $user->setPassword($newHashedPassword);
        $this->_em->persist($user);
        $this->_em->flush();
    }

    // /**
    //  * @return User[] Returns an array of User objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('u')
            ->andWhere('u.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('u.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?User
    {
        return $this->createQueryBuilder('u')
            ->andWhere('u.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */

    //Last id
    public function lastId()
    {
        return $this->createQueryBuilder('s')
            ->select('s.id')
            ->orderBy('s.id', 'DESC')
            ->setMaxResults(1)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }

    public function getAll($idCentre)
    {
        return $this->createQueryBuilder('e')
            ->join('e.centre','centre')
            ->select('e.slug,e.id,e.nom,e.prenom,e.tel,centre.nom as nomCentre,e.actif')
            ->where('centre.id=:idCentre')
            ->setParameter('idCentre',$idCentre)
            ->orderBy('e.id','DESC')
            ->getQuery()
            ->getResult()
        ;
    }

    public function getOneUser($idUser)
    {
        return $this->createQueryBuilder('e')
            ->join('e.centre','centre')
            ->select('e.id,e.nom,e.prenom,e.tel,centre.nom as nomCentre,e.actif,e.roles,e.fonction,e.slug')
            ->where('e.slug=:idUser')
            ->setParameter('idUser',$idUser)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }

    //Rechercher un user
    public function rechercherEmploye($value,$idCentre)
    {
        return $this->createQueryBuilder('e')
            ->join('e.centre','centre')
            ->select('e.id,e.nom,e.prenom,e.tel,centre.nom as nomCentre,,e.slug,e.fonction')
            ->where('e.nom LIKE:nom')
            ->orwhere('e.prenom LIKE:prenom')
            ->orwhere('e.tel LIKE:tel')
            ->andwhere('centre.id=:idCentre')
            ->setParameters(['nom'=>'%'.$value.'%','prenom'=>'%'.$value.'%','tel'=>'%'.$value.'%','idCentre'=>$idCentre])
            ->getQuery()
            ->getResult()
        ;
    }

    public function getUser($email)
    {
        return $this->createQueryBuilder('e')
            ->join('e.centre',"c")
            ->select('e.id,e.nom,e.prenom,e.email,e.slug,e.tel,c.id as idCentre,c.nom as nomCentre,c.tel as telCentre,c.adresse as adresseCentre,c.ville as ville,c.pays as pays')
            ->Where('e.email=:email')
            ->setParameter('email', $email)
            ->setMaxResults(1)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    //Rechercher un tel
    public function getTel($tel)
    {
        return $this->createQueryBuilder('e')
            ->select('e.id')
            ->Where('e.tel=:tel')
            ->setParameter('tel', $tel)
            ->setMaxResults(1)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }

    public function getEmail($email)
    {
        return $this->createQueryBuilder('e')
            ->select('e.id')
            ->Where('e.email=:email')
            ->setParameter('email', $email)
            ->setMaxResults(1)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
}
