<?php

require_once 'Migration.php';

class CreatePedidosTable extends Migration {
    public function up() {
        $sql = "CREATE TABLE IF NOT EXISTS pedidos (
            id INT AUTO_INCREMENT PRIMARY KEY,
            email_cliente VARCHAR(150) NOT NULL,
            produtos TEXT NOT NULL,
            total DECIMAL(10,2) NOT NULL,
            cep VARCHAR(10) NOT NULL,
            endereco VARCHAR(255) NOT NULL,
            status ENUM('pendente','pago','cancelado') DEFAULT 'pendente',
            data_pedido TIMESTAMP DEFAULT CURRENT_TIMESTAMP
        ) ENGINE=INNODB;";

        $this->pdo->exec($sql);
    }
}
