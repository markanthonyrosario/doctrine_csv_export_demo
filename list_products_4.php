<?php

require_once "bootstrap.php";

$pdo = $entityManager->getConnection()->getWrappedConnection();
$pdo->setAttribute(PDO::MYSQL_ATTR_USE_BUFFERED_QUERY, false);

$productRepository = $entityManager->getRepository('Product');
$query = $entityManager->createQuery('select product from \Product product');
$iterableResult = $query->iterate();

foreach ($iterableResult as $row) {
    $product = $row[0];
    echo '#' . $product->getId();
    echo ' ';
    echo $product->getName();
    // echo ' (' . $product->getOwnerName() . ')'; // (we cannot lazy load this for now)
    echo " - ". getMemoryUsage();
    echo "\n";
    $entityManager->detach($product);
    $entityManager->flush();
    $entityManager->clear();
}

// with 400k rows this consumes a constant 8 MB
// this is because doctrine loads the results into the memory one by one and we remove objects after we print them
// however we by using unbuffered queries, we lose the ability to lazy load associations because we cannot run other queries while an unbuffered query is active


