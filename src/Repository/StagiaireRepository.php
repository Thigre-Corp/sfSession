<?php

namespace App\Repository;

use App\Entity\Stagiaire;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

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

    public function learnersNotInSession()  :array
    {

        return [1,2]
        ;

    }
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
