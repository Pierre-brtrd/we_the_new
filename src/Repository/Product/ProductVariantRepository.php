<?php

namespace App\Repository\Product;

use App\Entity\Product\Product;
use App\Entity\Product\ProductVariant;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Knp\Component\Pager\Pagination\PaginationInterface;
use Knp\Component\Pager\PaginatorInterface;

/**
 * @extends ServiceEntityRepository<ProductVariant>
 */
class ProductVariantRepository extends ServiceEntityRepository
{
    public function __construct(
        ManagerRegistry $registry,
        private PaginatorInterface $pagination
    ) {
        parent::__construct($registry, ProductVariant::class);
    }

    public function findCheapestVariant(Product $product): ?ProductVariant
    {
        return $this->createQueryBuilder('pv')
            ->andWhere('pv.product = :product')
            ->setParameter('product', $product)
            ->orderBy('pv.priceHT', 'ASC')
            ->setMaxResults(1)
            ->getQuery()
            ->getOneOrNullResult();
    }

    public function findPaginateOrderByDate(int $maxPerPage, int $page, ?string $search = null, ?Product $product = null): PaginationInterface
    {
        $query = $this->createQueryBuilder('pv')
            ->join('pv.product', 'p')
            ->orderBy('p.createdAt', 'DESC');

        if ($search) {
            $query->andWhere('p.name LIKE :search')
                ->setParameter('search', "%$search%");
        }

        if ($product) {
            $query->andWhere('pv.product = :product')
                ->setParameter('product', $product);
        }

        return $this->pagination->paginate(
            $query->getQuery(),
            $page,
            $maxPerPage
        );
    }

    //    /**
    //     * @return ProductVariant[] Returns an array of ProductVariant objects
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

    //    public function findOneBySomeField($value): ?ProductVariant
    //    {
    //        return $this->createQueryBuilder('p')
    //            ->andWhere('p.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
