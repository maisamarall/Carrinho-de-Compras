<?php

require_once 'Product.php';
require_once 'Stock.php';

class ShoppingCart
{
    private array $cart = [];
    private Stock $stockManager;
    private float $discount = 0.0;

    public function __construct(Stock $stockManager)
    {
        $this->stockManager = $stockManager;
    }

    public function addItem(int $productId, int $quantity): string
    {
        $product = $this->stockManager->findProductById($productId);

        if (!$product) {
            return "Erro: Produto com ID {$productId} não encontrado.";
        }
        
        $currentQuantityInCart = $this->cart[$productId]['quantity'] ?? 0;
        if (($currentQuantityInCart + $quantity) > $product->getStock()) {
            return "<br>Erro: Estoque insuficiente para o produto {$product->getName()}.<br>";
        }

        if ($this->stockManager->decreaseStock($productId, $quantity)) {
            if (isset($this->cart[$productId])) {
                $this->cart[$productId]['quantity'] += $quantity;
            } else {
                $this->cart[$productId] = ['quantity' => $quantity];
            }
            return "<br>Sucesso: Adicionado {$quantity} de {$product->getName()} ao carrinho.";
        }
        return "";
    }

    public function removeItem(int $productId): string
    {
        if (!isset($this->cart[$productId])) {
            return "<br>Erro: Produto com ID {$productId} não foi encontrado no carrinho.";
        }
        
        $quantityToRemove = $this->cart[$productId]['quantity'];
        unset($this->cart[$productId]);

        if ($this->stockManager->increaseStock($productId, $quantityToRemove)) {
            return "<br>Sucesso: Produto com ID {$productId} foi removido do carrinho e estoque devolvido.";
        }
        return "<br>Erro: Não foi possível remover o item do carrinho.";
    }

    public function calculateTotal(): float
    {
        $total = 0;
        foreach ($this->cart as $productId => $cartItem) {
            $product = $this->stockManager->findProductById($productId);
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
        $output = "Itens no Carrinho<br>";
        if (empty($this->cart)) {
            $output .= "O carrinho está vazio.<br>";
            return $output;
        }

        foreach ($this->cart as $productId => $cartItem) {
            $product = $this->stockManager->findProductById($productId);
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
            return "<br>Cupom aplicado com sucesso. Desconto de 10%.";
        }
        return "Cupom inválido.";
    }
}