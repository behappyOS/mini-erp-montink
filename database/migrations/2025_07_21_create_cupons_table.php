<?php

require_once 'Migration.php';
class CreateCuponsTable extends Migration {
    public function up() {
        $sql = "CREATE TABLE IF NOT EXISTS cupons (
            id INT AUTO_INCREMENT PRIMARY KEY,
            codigo VARCHAR(50) UNIQUE NOT NULL,
            desconto DECIMAL(5,2) NOT NULL,
            ativo TINYINT(1) DEFAULT 1,
            criado_em TIMESTAMP DEFAULT CURRENT_TIMESTAMP
        ) ENGINE=INNODB;";

        $this->pdo->exec($sql);
    }
}
