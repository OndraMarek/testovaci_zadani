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

    public function findPaginatedSorted(int $offset, int $limit, string $sort, string $order)
    {
        $allowedSorts = ['code', 'name', 'price'];
        if (!in_array($sort, $allowedSorts)) {
            $sort = 'name';
        }

        return new Paginator(
            $this->createQueryBuilder('p')
                ->orderBy('p.' . $sort, $order)
                ->setFirstResult($offset)
                ->setMaxResults($limit)
                ->getQuery()
        );
    }
}
