<?php

require_once 'Product.php';

class ShoppingCart
{
    private float $discount = 0.0;
    private array $products;
    private array $cart = [];

    public function __construct(array $products)
    {
        $this->products = $products;
    }

    private function findProductById($id): ?Product
    {
        foreach ($this->products as $product) {
            if ($product->getId() === $id) {
                return $product;
            }
        }
        return null;
    }

    public function addItem(int $productId, int $quantity): string
    {
        $product = $this->findProductById($productId);
        if (!$product) {
            return "Erro: Produto com ID {$productId} não encontrado.";
        }

        $currentQuantityInCart = $this->cart[$productId]['quantity'] ?? 0;
        if (($currentQuantityInCart + $quantity) > $product->getStock()) {
            return "<br>Erro: Estoque insuficiente para o produto {$product->getName()}.<br>";
        }

        $product->decrementStock($quantity);

        if (isset($this->cart[$productId])) {
            $this->cart[$productId]['quantity'] += $quantity;
        } else {
            $this->cart[$productId] = ['quantity' => $quantity];
        }

        return "<br>Sucesso: Adicionado {$quantity} de {$product->getName()} ao carrinho.<br>";
    }

    public function removeItem(int $productId): string
    {
        if (!isset($this->cart[$productId])) {
            return "";
        }

        $quantityToRemove = $this->cart[$productId]['quantity'];
        unset($this->cart[$productId]);

        $product = $this->findProductById($productId);
        if ($product) {
            $product->incrementStock($quantityToRemove);
        }
        return "";
    }

    public function calculateTotal(): float
    {
        $total = 0;
        foreach ($this->cart as $productId => $cartItem) {
            $product = $this->findProductById($productId);
            if ($product) {
                $subtotal = $product->getPrice() * $cartItem['quantity'];
                $total += $subtotal;
            }
        }
        if ($this->discount > 0) {
            $total -= $total * $this->discount;
        }

        return $total;
    }

    public function listItems(): string
    {
        $output = "<br>Itens no Carrinho<br>";
        if (empty($this->cart)) {
            $output .= "O carrinho está vazio.\n";
            return "";
        }

        foreach ($this->cart as $productId => $cartItem) {
            $product = $this->findProductById($productId);
            if ($product) {
                $subtotal = $product->getPrice() * $cartItem['quantity'];
                $output .= "- Produto: {$product->getName()}<br>";
                $output .= "  - Quantidade: {$cartItem['quantity']}<br>";
                $output .= "  - Preço Unitário: R$ " . number_format($product->getPrice(), 2, ',', '.') . "<br>";
                $output .= "  - Subtotal: R$ " . number_format($subtotal, 2, ',', '.') . "<br>";
            }
        }

        $finalTotal = $this->calculateTotal();
        $output .= "Total do Carrinho: R$ " . number_format($finalTotal, 2, ',', '.') . "<hr>";
        return $output;
    }

    public function applyDiscount(string $coupon): string
    {
        if ($coupon === 'DESCONTO10') {
            $this->discount = 0.10;
            return "";
        }
        return "Cupom inválido.";
    }
}

?>