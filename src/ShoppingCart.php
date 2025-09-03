<?php

class ShoppingCart
{
    private array $products;
    private array $cart;

    public function __construct()
    {
        $this->products = [
            ['id' => 1, 'name' => 'Camiseta', 'price' => 59.90, 'stock' => 10],
            ['id' => 2, 'name' => 'Calça Jeans', 'price' => 129.90, 'stock' => 5],
            ['id' => 3, 'name' => 'Tênis', 'price' => 199.90, 'stock' => 3]
        ];

        $this->cart = [];
    }

    // Método para encontrar um produto pelo ID
    public function findProductById($id)
    {
        foreach ($this->products as $product) {
            if ($product['id'] === $id) {
                return $product;
            }
        }
        return null;
    }

    public function addItem($productId, $quantity)
    {
        $foundProduct = $this->findProductById($productId);

        if (!$foundProduct) {
            echo "Erro: Produto com ID {$productId} não encontrado.<br>";
            return;
        }

        if ($quantity <= 0) {
            echo "Erro: Quantidade inválida para o produto {$foundProduct['name']}.<br>";
            return;
        }

        $currentQuantityInCart = $this->cart[$productId]['quantity'] ?? 0;
        if (($currentQuantityInCart + $quantity) > $foundProduct['stock']) {
            echo "Erro: Estoque insuficiente para o produto {$foundProduct['name']}.<br>";
            return;
        }

        if (isset($this->cart[$productId])) {
            $this->cart[$productId]['quantity'] += $quantity;
        } else {
            $this->cart[$productId] = ['quantity' => $quantity];
        }

        $productIndex = array_search($foundProduct, $this->products);
        $this->products[$productIndex]['stock'] -= $quantity;

        echo "Sucesso: Adicionado {$quantity} de {$foundProduct['name']} ao carrinho.<br>";
    }
    public function removeItem($productId)
    {
        if (!isset($this->cart[$productId])) {
            echo "Erro: Produto com ID {$productId} não foi encontrado no carrinho.<br>";
            return;
        }

        $quantityToRemove = $this->cart[$productId]['quantity'];

        unset($this->cart[$productId]);

        $foundProduct = $this->findProductById($productId);
        if ($foundProduct) {
            $productIndex = array_search($foundProduct, $this->products);
            $this->products[$productIndex]['stock'] += $quantityToRemove;
        }

        echo "Sucesso: Produto com ID {$productId} foi removido do carrinho e estoque devolvido.<br>";
    }

    public function listItems()
    {
        echo "<br>Itens no Carrinho</br>";
        if (empty($this->cart)) {
            echo "O carrinho está vazio.</br>";
            return;
        }

        $total = 0;
        foreach ($this->cart as $productId => $cartItem) {
            $foundProduct = $this->findProductById($productId);
            if ($foundProduct) {
                $subtotal = $foundProduct['price'] * $cartItem['quantity'];
                $total += $subtotal;

                echo "
                - Produto: {$foundProduct['name']}<br> 
                - Quantidade: {$cartItem['quantity']}<br> 
                - Preço Unitário: R$ " . number_format($foundProduct['price'], 2, ',', '.') . "<br> 
                - Subtotal: R$ " . number_format($subtotal, 2, ',', '.') . "</br>";
            }
        }
        echo "Total do Carrinho: R$ " . number_format($total, 2, ',', '.') . "<br>";
    }
}