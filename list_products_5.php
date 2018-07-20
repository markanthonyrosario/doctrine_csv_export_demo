<?php

require_once "bootstrap.php";

$pdo = $entityManager->getConnection()->getWrappedConnection();
$pdo->setAttribute(PDO::MYSQL_ATTR_USE_BUFFERED_QUERY, false);

$queryBuilder = $entityManager->createQueryBuilder();
$queryBuilder->select('product.id,product.name as productName,owner.name as ownerName')
    ->from(Product::class, 'product')
    ->leftJoin(ProductOwner::class,'owner','WITH','owner.id = product.productOwner');
    ;

$query = $queryBuilder->getQuery();
$query->setMaxResults(405000);
$iterableResult = $query->iterate(null,\Doctrine\ORM\Query::HYDRATE_ARRAY);

foreach ($iterableResult as $row) {
    $product = array_pop($row);
    echo '#' . $product['id'];
    echo $product['productName'];    echo ' ';

    echo ' (' . $product['ownerName'] . ')';
    echo " - ". getMemoryUsage();
    echo "\n";
}

// with 400k rows this consumes a constant 6 MB
// this is because doctrine loads the results into the memory one by one and we do not use objects

