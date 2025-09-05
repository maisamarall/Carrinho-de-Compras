<?php

require_once 'Product.php';
require_once 'Stock.php';
require_once 'ShoppingCart.php';

$products = [
    new Product(1, 'Camiseta', 59.90, 10),
    new Product(2, 'Calça Jeans', 129.90, 5),
    new Product(3, 'Tênis', 199.90, 3)
];

$stockManager = new Stock($products);
$shoppingCart = new ShoppingCart($stockManager);

echo "Simulação do Carrinho de Compras<hr>";

echo "Adicionando 2 Camisetas (ID 1)";
echo $shoppingCart->addItem(1, 2);
echo $shoppingCart->listItems();

echo "Tentando adicionar 10 Tênis (ID 3)";
echo $shoppingCart->addItem(3, 10);
echo $shoppingCart->listItems();

echo "Adicionando 1 Calça Jeans (ID 2) e aplicando cupom";
echo $shoppingCart->addItem(2, 1);
echo $shoppingCart->applyDiscount('DESCONTO10');
echo $shoppingCart->listItems();

?>