<?php

namespace App\Repository;

use App\Entity\Centre;
use App\Entity\ProduitStock;
use App\Entity\TypeProduit;
use App\Entity\Produit;
use App\Entity\Stock;
use App\Form\ProduitType;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\Query\Expr\GroupBy;
use Doctrine\Persistence\ManagerRegistry;

use function PHPSTORM_META\type;

/**
 * @method ProduitStock|null find($id, $lockMode = null, $lockVersion = null)
 * @method ProduitStock|null findOneBy(array $criteria, array $orderBy = null)
 * @method ProduitStock[]    findAll()
 * @method ProduitStock[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 * @method ProduitStock|null getProduit($produit, $stock)
 * @method ProduitStock|null getEtatStockProduit($stock)
 */
class ProduitStockRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ProduitStock::class);
    }

    // /**
    //  * @return ProduitStock[] Returns an array of ProduitStock objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('p.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?ProduitStock
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */

    //Cette fonction permet de rechercher un produit dans la table produitStock en fonction du produit et le stock
    public function getProduit(Produit $produit,Stock $stock)
    {
        return $this->createQueryBuilder('s')
            //->select('p.id')
            ->join('s.user','user')
            ->join('s.fournisseur ','f')
            ->join('s.produit ','produit')
            ->join('s.stock ','stock')
            ->join('produit.type','type')
            ->select("f.id,f.nom,f.prenom,f.tel,f.adresse,type.type,type.id,produit.id,produit.designation,s.id,s.PUA,s.PUV,s.quantite,stock.nom,user.id,user.nom,user.prenom")
            ->Where('s.produit = :produit')
            ->andWhere('s.stock = :stock')
            ->andWhere('s.quantite > :quantite')
            ->setParameters(['produit'=> $produit,'stock'=>$stock,'quantite'=>0])
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }

    //Etat du stock
    public function getEtatStockProduit(Stock $stock,Centre $centre)
    {
        return $this->createQueryBuilder('p')
            ->join('p.produit','produit')
            ->join('produit.type','type')
            ->join('type.centre','centre')
            ->select("SUM(p.quantite) as total,produit.designation,type.type")
            ->andWhere('p.stock = :stock')
            ->andWhere('type.centre = :centre')
            ->groupBy('produit.designation,produit.type')
            ->setParameters(['stock'=>$stock,'centre'=>$centre])
            ->getQuery()
            ->getResult()
        ;
    }

    public function getAll(Centre $centre)
    {
        return $this->createQueryBuilder('s')
            ->join('s.stock','stock')
            ->join('s.user','user')
            ->join('s.produit','produit')
            ->join('s.fournisseur','f')
            ->join('produit.type','type')
            ->Where('user.centre = :centre')
            ->select("f.id as idf,f.nom as nomf,f.prenom as prenomf,f.tel as telf,f.adresse as adressef,type.type,type.id as idt,produit.id as idp,produit.designation,s.id,s.PUA,s.PUV,s.quantite,stock.nom as noms,stock.id as ids,user.id as idUser,user.nom as nomUser,user.prenom as prenomUser,produit.id as idP")
            ->setParameter('centre', $centre)
            ->orderBy('s.id', 'DESC')
            ->getQuery()
            ->getResult()
        ;
    }

    public function getOneProduitStock($id)
    {
        return $this->createQueryBuilder('s')
            ->join('s.stock','stock')
            ->join('s.user','user')
            ->join('s.produit','produit')
            ->join('s.fournisseur','f')
            ->join('produit.type','type')
            ->Where('s.id = :id')
            ->select("f.id as idf,f.nom as nomf,f.prenom as prenomf,f.tel as telf,f.adresse as adressef,type.type,type.id as idt,produit.id as idp,produit.designation,s.id,s.PUA,s.PUV,s.quantite,stock.nom as noms,user.id as idUser,user.nom as nomUser,user.prenom as prenomUser")
            ->setParameter('id', $id)
            ->orderBy('s.id', 'DESC')
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
}
