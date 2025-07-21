CREATE DATABASE IF NOT EXISTS loja;
USE loja;

-- Tabela de produtos
CREATE TABLE produtos (
                          id INT AUTO_INCREMENT PRIMARY KEY,
                          nome VARCHAR(255),
                          descricao TEXT,
                          preco DECIMAL(10,2),
                          estoque INT DEFAULT 0,
                          created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Tabela de pedidos
CREATE TABLE pedidos (
                         id INT AUTO_INCREMENT PRIMARY KEY,
                         cliente_nome VARCHAR(255),
                         cliente_email VARCHAR(255),
                         endereco TEXT,
                         cep VARCHAR(20),
                         frete DECIMAL(10,2),
                         subtotal DECIMAL(10,2),
                         desconto DECIMAL(10,2),
                         total DECIMAL(10,2),
                         cupom_usado VARCHAR(50),
                         status ENUM('pendente', 'pago', 'enviado') DEFAULT 'pendente',
                         criado_em TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Itens do pedido
CREATE TABLE pedido_itens (
                              id INT AUTO_INCREMENT PRIMARY KEY,
                              pedido_id INT,
                              produto_id INT,
                              quantidade INT,
                              preco_unitario DECIMAL(10,2),
                              FOREIGN KEY (pedido_id) REFERENCES pedidos(id),
                              FOREIGN KEY (produto_id) REFERENCES produtos(id)
);

-- Tabela de cupons
CREATE TABLE cupons (
                        id INT AUTO_INCREMENT PRIMARY KEY,
                        codigo VARCHAR(50) UNIQUE,
                        valor DECIMAL(10,2),
                        minimo DECIMAL(10,2),
                        validade DATE
);

-- Inserção de produtos de exemplo
INSERT INTO produtos (nome, descricao, preco, estoque) VALUES
                                                           ('Camiseta Branca', 'Camiseta básica de algodão branca.', 49.90, 100),
                                                           ('Calça Jeans', 'Calça jeans azul escuro.', 89.90, 50),
                                                           ('Tênis Esportivo', 'Tênis para corrida com amortecimento.', 199.90, 30);

-- Cupom de teste
INSERT INTO cupons (codigo, valor, minimo, validade) VALUES
    ('DESCONTO10', 10.00, 50.00, DATE_ADD(CURDATE(), INTERVAL 30 DAY));
