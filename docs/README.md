# Projeto de Carrinho de Compras

### Repositório da disciplina de Design Patterns & Clean Code - Prof Valdir

Este projeto implementa um sistema de carrinho de compras simples em PHP, seguindo boas práticas com a organização PSR-12 e os princípios DRY e KISS.

---

### 🧑‍🎓 Nomes dos discentes e RAs

- *Maisa Amaral:* 1997058
- *Samara Adorno:* 2001639

---

### 📂 Estrutura do Projeto

O projeto é dividido em uma estrutura de pastas simples:

- src/ : Contém os arquivos de código-fonte.
    - Product.php: Classe que representa um produto, encapsulando seus atributos (ID, nome, preço, estoque).
    -Stock.php: Classe responsável por gerenciar o controle de estoque de todos os produtos, desacoplando essa lógica da classe Product e ShoppingCart.
    - ShoppingCart.php: Classe que gerencia o carrinho de compras. Contém os métodos para adicionar, remover, listar e calcular o total dos itens.
    - index.php: O arquivo principal para rodar os testes e demonstrar o funcionamento do sistema, agrupando as interações entre as classes.
- README.md: Este arquivo, com a documentação do projeto.

---

### ✨ Funcionalidades Implementadas

O sistema de carrinho de compras oferece as seguintes funcionalidades:

- *Adicionar Item:* Adiciona um produto ao carrinho, validando o estoque e atualizando o total. A validação e o controle de estoque são delegados à classe Stock.
- *Remover Item:* Remove um item do carrinho, devolvendo a quantidade para o estoque através da classe Stock.
- *Listar Itens:* Exibe uma lista detalhada dos produtos no carrinho, com o subtotal de cada um e o total geral.
- *Aplicar Desconto:* .Permite a aplicação de um cupom fixo (DESCONTO10) que reduz o valor total da compra em 10%.

---

### 🛠️ Regras de Negócio e Limitações

- O sistema gerencia o estoque dos produtos de forma que não é possível adicionar mais itens do que o disponível.
- As operações de adicionar e remover itens atualizam o estoque do produto em tempo real, utilizando a lógica da classe Stock.
- As funcionalidades são implementadas usando arrays no arquivo Index.php
- As funcionalidades são implementadas usando classes e objetos, e o princípio da separação de responsabilidades.

---

### 🚀 Como Executar o Projeto

1.  *Instale o XAMPP:* Certifique-se de que o XAMPP (ou similar) está instalado e com o servidor Apache iniciado.
2.  *Clone o Repositório:* Copie os arquivos do projeto para a pasta htdocs do seu XAMPP.
3.  *Acesse no Navegador:* Abra seu navegador e acesse a URL: http://localhost/caminho-para-sua-pasta-do-projeto/src/index.php.

O arquivo index.php contém alguns testes que demonstram o funcionamento de todas as funcionalidades.

---

### 🔍 Casos de Teste (Exemplos de Uso)

*Caso 1 — Usuário adiciona um produto válido*
- *Entrada:* $shoppingCart->addItem(1, 2)
- *Resultado esperado:* O produto "Camiseta" é adicionado ao carrinho com a quantidade 2. O estoque da Camiseta é atualizado.

*Caso 2 — Usuário tenta adicionar além do estoque*
- *Entrada:* $shoppingCart->addItem(3, 10)
- *Resultado esperado:* Uma mensagem de erro "Estoque insuficiente" é exibida.

*Caso 3 — Usuário remove produto do carrinho*
- *Entrada:* $shoppingCart->removeItem(2)
- *Resultado esperado:* O produto "Calça Jeans" é removido do carrinho. O estoque da Calça Jeans é restaurado.

*Caso 4 — Aplicação de cupom de desconto*
- *Entrada:* $shoppingCart->applyDiscount('DESCONTO10')
- *Resultado esperado:* O valor total da compra é reduzido em 10%.