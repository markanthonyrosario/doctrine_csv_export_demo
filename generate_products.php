<?php

require_once "bootstrap.php";

$faker = Faker\Factory::create();
$productOwner = new ProductOwner();
$productOwner->setName($faker->safeEmail);

$batchSize = 5000;
for($i=0;$i<=400000;$i++) {
    $product = new Product();
    $product->setName($faker->domainName);
    $product->setProductOwner($productOwner);
    $entityManager->persist($product);
    if (($i % $batchSize) === 0) {
        $entityManager->flush();
        $entityManager->clear(); // Detaches all objects from Doctrine!
        $productOwner = new ProductOwner();
        $productOwner->setName($faker->safeEmail);
    }
}
$entityManager->flush();
$entityManager->clear();

