<?php

require_once 'Product.php';

class Stock
{
    private array $products;

    public function __construct(array $products)
    {
        $this->products = $products;
    }

    public function findProductById(int $id): ?Product
    {
        foreach ($this->products as $product) {
            if ($product->getId() === $id) {
                return $product;
            }
        }
        return null;
    }
    
    public function decreaseStock(int $productId, int $quantity): bool
    {
        $product = $this->findProductById($productId);
        
        if ($product && $product->getStock() >= $quantity) {
            $currentStock = $product->getStock();
            $reflection = new ReflectionProperty($product, 'stock');
            $reflection->setAccessible(true);
            $reflection->setValue($product, $currentStock - $quantity);
            return true;
        }
        return false;
    }

    public function increaseStock(int $productId, int $quantity): bool
    {
        $product = $this->findProductById($productId);
        
        if ($product) {
            $currentStock = $product->getStock();
            $reflection = new ReflectionProperty($product, 'stock');
            $reflection->setAccessible(true);
            $reflection->setValue($product, $currentStock + $quantity);
            return true;
        }
        return false;
    }
}