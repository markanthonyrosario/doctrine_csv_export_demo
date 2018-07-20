<?php
// src/Product.php
/**
 * @Entity @Table(name="products")
 **/
class Product
{
    /** @Id @Column(type="integer") @GeneratedValue **/
    protected $id;
    /** @Column(type="string") **/
    protected $name;

    /**
     * @ManyToOne(targetEntity="ProductOwner",cascade={"persist"},fetch="EAGER")
     * @JoinColumn(name="product_owner", referencedColumnName="id")
     **/
    protected $productOwner;

    public function getId()
    {
        return $this->id;
    }

    public function getName()
    {
        return $this->name;
    }

    public function setName($name)
    {
        $this->name = $name;
    }

    public function getOwnerName(): string
    {
        return $this->productOwner->getName();
    }

    public function setProductOwner(ProductOwner $owner)
    {
        $this->productOwner = $owner;
    }

    public function getOwner(): ProductOwner
    {
        return $this->productOwner;
    }

}