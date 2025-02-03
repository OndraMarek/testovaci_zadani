<?php

namespace App\Repository;

use App\Entity\Product;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\ORM\Tools\Pagination\Paginator;

/**
 * @extends ServiceEntityRepository<Product>
 */
class ProductRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Product::class);
    }

    public function findPaginatedSortedFiltered(int $offset, int $limit, string $sort, string $order, string $filterField, string $filterValue)
    {
        $allowedSorts = ['code', 'name', 'price'];
        if (!in_array($sort, $allowedSorts)) {
            $sort = 'name';
        }

        $queryBuilder = $this->createQueryBuilder('p')
            ->orderBy('p.' . $sort, $order)
            ->setFirstResult($offset)
            ->setMaxResults($limit);

        if ($filterValue) {
            if ($filterField === 'brand') {
                $queryBuilder
                    ->leftJoin('p.brand', 'b')
                    ->andWhere('b.name LIKE :filterValue')
                    ->setParameter('filterValue', '%' . $filterValue . '%');
            } elseif ($filterField === 'material') {
                $queryBuilder
                    ->leftJoin('p.material', 'm')
                    ->andWhere('m.name LIKE :filterValue')
                    ->setParameter('filterValue', '%' . $filterValue . '%');
            } else {
                $queryBuilder
                    ->andWhere('p.name LIKE :filterValue')
                    ->setParameter('filterValue', '%' . $filterValue . '%');
            }
        }

        return new Paginator($queryBuilder->getQuery());
    }
}
