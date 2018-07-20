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

$response = new \Symfony\Component\HttpFoundation\StreamedResponse(function() use ($iterableResult) {
    $csv = '';
    $csv .= "\n\n initial memory usage: ". getMemoryUsage();
    echo $csv; $csv = '';
    foreach ($iterableResult as $row) {
        $product = array_pop($row);
        $csv .= '#' . $product['id'];
        $csv .= ' ';
        $csv .= $product['productName'];
        $csv .= ' (' . $product['ownerName'] . ')';
        $csv .= " - ". getMemoryUsage();
        $csv .= "\n";
        echo $csv; $csv = '';
    }
    $csv .= "\n\n final memory usage: ". getMemoryUsage();
    echo $csv; $csv = '';
});

$response->headers->set('Content-Type', 'text/csv');
$response->headers->set('Content-Disposition', 'attachment; filename="export_from_doctrine_demo.csv"');
$response->send();

// with 400k rows this consumes a constant 2mb
// this is because we are streaming the data directly into the user's browsers instead of our php server's memory


