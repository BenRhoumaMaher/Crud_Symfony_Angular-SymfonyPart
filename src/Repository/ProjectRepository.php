<?php

namespace App\Repository;

use App\Entity\Project;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Project>
 *
 * @method Project|null find($id, $lockMode = null, $lockVersion = null)
 * @method Project|null findOneBy(array $criteria, array $orderBy = null)
 * @method Project[]    findAll()
 * @method Project[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ProjectRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Project::class);
    }

    public function searchProjects(string $searchBy, string $searchText)
    {
        $queryBuilder = $this->createQueryBuilder('p');

        switch ($searchBy) {
            case 'ProjectName':
                $queryBuilder->andWhere('p.projectName LIKE :searchText')
                    ->setParameter('searchText', '%' . $searchText . '%');
                break;
            case 'DateOfStart':
                $queryBuilder->andWhere('p.dateOfStart = :searchText')
                    ->setParameter('searchText', new \DateTime($searchText));
                break;
            case 'ProjectID':
                $queryBuilder->andWhere('p.projectID LIKE :searchText')
                    ->setParameter('searchText', '%' . $searchText . '%');
                break;
            case 'TeamSize':
                $queryBuilder->andWhere('p.teamSize LIKE :searchText')
                    ->setParameter('searchText', '%' . $searchText . '%');
                break;
            default:
                break;
        }

        return $queryBuilder->getQuery()->getResult();
    }

    //    /**
    //     * @return Project[] Returns an array of Project objects
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

    //    public function findOneBySomeField($value): ?Project
    //    {
    //        return $this->createQueryBuilder('p')
    //            ->andWhere('p.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
