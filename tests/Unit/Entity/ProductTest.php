<?php


namespace App\Tests\Unit\Entity;


use App\Entity\Product;
use App\Entity\Brand\Farmitoo;
use App\Entity\Vat\VatCountry;
use PHPUnit\Framework\TestCase;

class ProductTest extends TestCase
{
    private $product;

    public function setUp(): void
    {
        $this->product = new Product('title', 100, new Farmitoo(new VatCountry(1.20)));
    }

    public function testGetTitle()
    {
        $this->assertEquals('title', $this->product->getTitle());
    }

    public function testGetBrand()
    {
        $this->assertInstanceOf(Farmitoo::class, $this->product->getBrand());
    }

    public function testGetPrice()
    {
        $this->assertEquals(100, $this->product->getPrice());
    }
}
