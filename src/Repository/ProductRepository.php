<?php

namespace App\Repository;

use App\Entity\Product;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\ORM\Tools\Pagination\Paginator;
use Doctrine\ORM\QueryBuilder;

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
        $queryBuilder = $this->createQueryBuilder('p');

        $this->findSorted($queryBuilder, $sort, $order);
        $this->findFiltered($queryBuilder, $filterField, $filterValue);
        $this->findPaginated($queryBuilder, $offset, $limit);

        return new Paginator($queryBuilder->getQuery());
    }

    public function findSortedFiltered(string $sort, string $order, string $filterField, string $filterValue): array
    {
        $queryBuilder = $this->createQueryBuilder('p');
        $this->findSorted($queryBuilder, $sort, $order);
        $this->findFiltered($queryBuilder, $filterField, $filterValue);
        return $queryBuilder->getQuery()->getResult();
    }

    private function findSorted(QueryBuilder $queryBuilder, string $sort, string $order): void
    {
        $allowedSorts = ['code', 'name', 'price'];
        if (!in_array($sort, $allowedSorts)) {
            $sort = 'name';
        }

        $queryBuilder->orderBy('p.' . $sort, $order);
    }

    private function findFiltered(QueryBuilder $queryBuilder, string $filterField, string $filterValue): void
    {
        if (empty($filterValue)) {
            return;
        }

        switch ($filterField) {
            case 'brand':
                $queryBuilder
                    ->leftJoin('p.brand', 'b')
                    ->andWhere('b.name LIKE :filterValue');
                break;
            case 'material':
                $queryBuilder
                    ->leftJoin('p.material', 'm')
                    ->andWhere('m.name LIKE :filterValue');
                break;
            default:
                $queryBuilder
                    ->andWhere('p.name LIKE :filterValue');
        }

        $queryBuilder->setParameter('filterValue', '%' . $filterValue . '%');
    }

    private function findPaginated(QueryBuilder $queryBuilder, int $offset, int $limit): void
    {
        $queryBuilder->setFirstResult($offset)->setMaxResults($limit);
    }

}
