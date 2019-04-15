<?php

namespace App\Entity;

use Symfony\Component\Validator\Constraints as Assert;

class ProductSearch
{
    /**
     * @var string|null
     */
    private $product;

    /**
     * @return null|string
     */
    public function getProduct()
    {
        return $this->product;
    }

    /**
     * @param null|string $product
     * @return ProductSearch
     */
    public function setProduct($product)
    {
        $this->product = $product;
        return $this;
    }
}