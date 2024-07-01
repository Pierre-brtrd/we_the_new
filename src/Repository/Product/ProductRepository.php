<?php

namespace App\Repository\Product;

use App\Entity\Product\Model;
use App\Entity\Product\Product;
use App\Filter\ProductFilter;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Knp\Component\Pager\Pagination\PaginationInterface;
use Knp\Component\Pager\Paginator;
use Knp\Component\Pager\PaginatorInterface;

/**
 * @extends ServiceEntityRepository<Product>
 */
class ProductRepository extends ServiceEntityRepository
{
    public function __construct(
        ManagerRegistry $registry,
        private PaginatorInterface $pagination
    ) {
        parent::__construct($registry, Product::class);
    }

    public function findPaginateOrderByDate(int $maxPerPage, int $page, ?string $search = null): PaginationInterface
    {
        $query = $this->createQueryBuilder('p')
            ->orderBy('p.createdAt', 'DESC');

        if ($search) {
            $query->andWhere('p.name LIKE :search')
                ->setParameter('search', "%$search%");
        }

        return $this->pagination->paginate(
            $query->getQuery(),
            $page,
            $maxPerPage
        );
    }

    public function findShopLatest(int $max): array
    {
        return $this->createQueryBuilder('p')
            ->addSelect('p, m')
            ->where('p.enable = true')
            ->join('p.model', 'm')
            ->orderBy('p.createdAt', 'DESC')
            ->setMaxResults($max)
            ->getQuery()
            ->getResult();
    }

    public function findShopPaginateOrderByDate(int $maxPerPage, int $page, ?string $search = null, ?Model $model = null): PaginationInterface
    {
        $query = $this->createQueryBuilder('p')
            ->andWhere('p.enable = true')
            ->orderBy('p.createdAt', 'DESC');

        if ($search) {
            $query->andWhere('p.name LIKE :search')
                ->setParameter('search', "%$search%");
        }

        if ($model) {
            $query->andWhere('p.model = :model')
                ->setParameter('model', $model);
        }

        return $this->pagination->paginate(
            $query->getQuery(),
            $page,
            $maxPerPage
        );
    }

    public function createListShop(ProductFilter $productFilter, ?Model $model = null): PaginationInterface
    {
        $query = $this->createQueryBuilder('p')
            ->andWhere('p.enable = true');

        if ($productFilter->getName()) {
            $query->andWhere('p.name LIKE :name')
                ->setParameter('name', "%{$productFilter->getName()}%");
        }

        if ($productFilter->getSort() && $productFilter->getSort() !== 'price') {
            $query->orderBy($productFilter->getSort(), $productFilter->getDirection() ?? 'ASC');
        } elseif ($productFilter->getSort() === 'price') {
            $query
                ->join('p.productVariants', 'pv')
                ->groupBy('p')
                ->orderBy('pv.priceHT', $productFilter->getDirection() ?? 'ASC');
        }

        if ($model) {
            $query->andWhere('p.model = :model')
                ->setParameter('model', $model);
        }

        return $this->pagination->paginate(
            $query->getQuery(),
            $productFilter->getPage(),
            $productFilter->getLimit()
        );
    }

    //    /**
    //     * @return Product[] Returns an array of Product objects
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

    //    public function findOneBySomeField($value): ?Product
    //    {
    //        return $this->createQueryBuilder('p')
    //            ->andWhere('p.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
