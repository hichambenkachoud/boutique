<?php

namespace App\Repository;

use App\Dto\SearchProduct;
use App\Entity\Product;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Product>
 *
 * @method Product|null find($id, $lockMode = null, $lockVersion = null)
 * @method Product|null findOneBy(array $criteria, array $orderBy = null)
 * @method Product[]    findAll()
 * @method Product[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ProductRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Product::class);
    }

    public function save(Product $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Product $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    /**
     * @return Product[] Returns an array of Product objects
     */
    public function findWithFilters(SearchProduct $searchProduct): array
    {
        $qb = $this->createQueryBuilder('p')
            ->select('c', 'p')
            ->join('p.category', 'c');

        if (!empty($searchProduct->keyWord)) {
            $qb->andWhere('p.description LIKE :val1 OR p.description LIKE :val2')
                ->setParameter('val1', $searchProduct->keyWord)
                ->setParameter('val2', $searchProduct->keyWord);
        }

        if (!empty($searchProduct->categories)) {
            $qb->andWhere('p.id IN (:ids)')
                ->setParameter('ids', $searchProduct->categories);
        }

        return $qb->getQuery()
            ->getResult();
    }

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
