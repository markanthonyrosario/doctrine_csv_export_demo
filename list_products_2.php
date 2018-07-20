<?php

require_once "bootstrap.php";

$productRepository = $entityManager->getRepository('Product');
$query = $entityManager->createQuery('select product from \Product product');
$iterableResult = $query->iterate();

foreach ($iterableResult as $row) {
    $product = $row[0];
    echo '#' . $product->getId();
    echo ' ';
    echo $product->getName();
    echo ' (' . $product->getOwnerName() . ')';
    echo " - ". getMemoryUsage();
    echo "\n";

}

// with 400k rows this consumes 8 MB to 627.37 MB
// this is because doctrine loads the results into the memory one by one
// however the objects created are retained into memory

