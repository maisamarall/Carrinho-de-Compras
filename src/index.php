<?php

require_once 'shoppingCart.php';
$carrinhoDeCompras = new ShoppingCart();

echo 'Simulação do Carrinho de Compras<br>';

echo '1. Adicionando 2 Camisetas (ID 1)<br>';
$carrinhoDeCompras->addItem(1, 2);
$carrinhoDeCompras->listItems();
echo '<hr>';

echo '2. Tentando adicionar 10 Tênis (ID 3)<br>';
$carrinhoDeCompras->addItem(3, 10);
$carrinhoDeCompras->listItems();
echo '<hr>';