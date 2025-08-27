<?php

namespace App\Repository;

use App\Entity\Session;
use App\Entity\Stagiaire;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;

/**
 * @extends ServiceEntityRepository<Stagiaire>
 */
class StagiaireRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Stagiaire::class);
    }

    /**
    * @return Stagiaire[] Returns an array of Stagiaire objects not in the selected Session object
    */

    public function learnersNotInSession(Session $session)  :array
    {
        //$id = $session->getId();

        $queryBuilder = $this->createQueryBuilder();

        $itsIn = $queryBuilder
            ->select('stag')
            ->from('Stagiaire', 'stag')
            ->join()

            ->andWhere('s.id = :valeur')
            ->setParameter('valeur', $id)
            ->orderBy('s.nom', 'ASC')
            //->setMaxResults(10)
            ->getQuery()
            ->getResult()
           ;


           $sub = $qb->select('arl')
          ->from('$MineMyBundle:MineAssetRequestLine', 'arl')
          ->where($qb->expr()->eq('arl.asset_id',1));

$linked = $qb->select('rl')
             ->from('MineMyBundle:MineRequestLine', 'rl')
             ->where($qb->expr()->notIn('rl.request_id',  $sub->getDQL()))
             ->getQuery()
             ->getResult();
        return $allInSession;

    }

    // /**
    // * @return Stagiaire[] Returns an array of Stagiaire objects
    // */
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

/*
selectionner tout les stagaiaires d'une sessions dont l'id est passé en parametre
selectionner tt lesstagires qui ne sont PAS dans le resultat précédent
-> go
https://stackoverflow.com/questions/13957330/where-not-in-query-with-doctrine-query-builder

--->
https://igm.univ-mlv.fr/~dr/XPOSE2014/Symfony/structure.html


*/














    //    /**
    //     * @return Stagiaire[] Returns an array of Stagiaire objects
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

    //    public function findOneBySomeField($value): ?Stagiaire
    //    {
    //        return $this->createQueryBuilder('s')
    //            ->andWhere('s.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
