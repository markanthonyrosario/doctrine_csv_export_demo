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

$csv = '';
$csv .= "\n\n initial memory usage: ". getMemoryUsage();
foreach ($iterableResult as $row) {
    $product = array_pop($row);
    $csv .= '#' . $product['id'];
    $csv .= ' ';
    $csv .= $product['productName'];
    $csv .= ' (' . $product['ownerName'] . ')';
    $csv .= " - ". getMemoryUsage();
    $csv .= "\n";

}
$csv .= "\n\n final memory usage: ". getMemoryUsage();

$response = new \Symfony\Component\HttpFoundation\Response($csv);
$response->headers->set('Content-Type', 'text/csv');
$response->headers->set('Content-Disposition', 'attachment; filename="export_from_doctrine_demo.csv"');
$response->send();

// with 400k rows this consumes a constant 2mb - 25mb
// this is because we are building the $csv content in the memory
// this is not actually bad, but could be dangerous if our report has more rows and columns


