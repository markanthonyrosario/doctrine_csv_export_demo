<?php

require_once "bootstrap.php";

$productRepository = $entityManager->getRepository('Product');
$products = $productRepository->findAll();

foreach ($products as $product) {
    echo '#' . $product->getId();
    echo ' ';
    echo $product->getName();
    echo ' (' . $product->getOwnerName() . ')';
    echo " - ". getMemoryUsage();
    echo "\n";
}

// with 400k rows this consumes a constant 646.01 MB
// this is because doctrine loads all the results into the memory before we iterate on it.

