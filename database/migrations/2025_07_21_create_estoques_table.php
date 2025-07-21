<?php

require_once 'Migration.php';
class CreateEstoquesTable extends Migration {
    public function up() {
        $sql = "CREATE TABLE IF NOT EXISTS estoques (
            id INT AUTO_INCREMENT PRIMARY KEY,
            produto_id INT NOT NULL,
            quantidade INT NOT NULL DEFAULT 0,
            FOREIGN KEY (produto_id) REFERENCES produtos(id) ON DELETE CASCADE
        ) ENGINE=INNODB;";

        $this->pdo->exec($sql);
    }
}
