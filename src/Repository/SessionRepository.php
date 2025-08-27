<?php

namespace App\Repository;

use App\Entity\Session;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;

/**
 * @extends ServiceEntityRepository<Session>
 */
class SessionRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Session::class);
    }

    /**
    * @return Session[] Returns an array of past Session objects
    */
    public function findPastSessions(): array
    {
        $now = new \DateTimeImmutable();
        return $this->createQueryBuilder('s')
            ->andWhere('s.dateFin < :today')
            ->setParameter('today', $now)  //, Types::DATETIME_IMMUTABLE)
            ->orderBy('s.id', 'ASC')
        //    ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
        
    }

    /**
    * @return Session[] Returns an array of active Session objects
    */
    public function findActiveSessions(): array
    {
        $now = new \DateTimeImmutable();
        return $this->createQueryBuilder('s')
            ->andWhere('s.dateDebut <= :today')
            ->andWhere('s.dateFin >= :today')
            ->setParameter('today', $now)  //, Types::DATETIME_IMMUTABLE)
            ->orderBy('s.id', 'ASC')
        //    ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }

    /**
    * @return Session[] Returns an array of future Session objects
    */
    public function findFutureSessions(): array
    {
        $now = new \DateTimeImmutable();
        return $this->createQueryBuilder('s')
            ->andWhere('s.dateDebut > :today')
            ->setParameter('today', $now)  //, Types::DATETIME_IMMUTABLE)
            ->orderBy('s.id', 'ASC')
        //    ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }










    //    /**
    //  * @return Session[]
    //  */
    // public function findPastSessions(?\DateTimeImmutable $now = null): array
    // {
    //     // "Passée" = la session est complètement terminée : endAt < maintenant
    //     $now ??= new \DateTimeImmutable('now'); // opérateur de coallescence d'affectation - si now is null, then now = 'now'
    //     return $this->createQueryBuilder('s') 
    //         ->andWhere('s.endAt < :now') // prédicat
    //         ->setParameter('now', $now, Types::DATETIME_IMMUTABLE)
    //         ->orderBy('s.endAt', 'DESC') // les plus récentes d'abord
    //         ->getQuery()
    //         ->getResult();
    // }
    
    //    public function findOneBySomeField($value): ?Session
    //    {
        //        return $this->createQueryBuilder('s')
        //            ->andWhere('s.exampleField = :val')
        //            ->setParameter('val', $value)
        //            ->getQuery()
        //            ->getOneOrNullResult()
        //        ;
        //    }
        
    }
