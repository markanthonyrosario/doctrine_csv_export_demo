<?php
// src/ProductOwner.php
/**
 * @Entity @Table(name="product_owner")
 */
class ProductOwner
{
    /**
     * @Id @GeneratedValue @Column(type="integer")
     * @var int
     */
    protected $id;
    /**
     * @Column(type="string")
     * @var string
     */
    protected $name;

    /**
     * @OneToMany(targetEntity="Product", mappedBy="productOwner")
     * @var Product[] An ArrayCollection of Product objects.
     **/
    protected $products;

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
}