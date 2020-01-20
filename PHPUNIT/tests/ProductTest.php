<?php

use App\Models\Product;
use PHPUnit\Framework\TestCase;

class ProductTest extends TestCase
{
    public function testComputeTVAFoodProduct()
    {
        $product = new Product('Un produit', Product::FOOD_PRODUCT, 20);
        $this->assertSame(1.1, $product->computeTVA());
    }

    public function testComputeTVAOtherProduct()
    {
        $product = new Product('Un autre produit', 'une autre type de produit', 20);
        $this->assertSame(3.92, $product->computeTVA());
    }

    public function testComputeTVAWhenPriceIsNegative()
    {
        $product = new Product('produit', 'type', -12);
        $this->expectException(\LogicException::class);
        $product->computeTVA();
    }


    /**
     * @dataProvider priceForFoodProduct
     */
    public function testComputeTVAFoodProduct2($price, $expectedTva)
    {
        $product = new Product('sas', Product::FOOD_PRODUCT, $price);
        $this->assertSame($expectedTva, $product->computeTVA());
    }

    public function priceForFoodProduct()
    {
        return [
            [0, 0.0],
            [20, 1.1],
            [100, 5.5]
        ];
    }
}
