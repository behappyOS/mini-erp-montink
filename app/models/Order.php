<?php

class Order{
    public function updateStatus($id, $status) {
        $db = Database::getInstance()->getConnection();
        $stmt = $db->prepare("UPDATE pedidos SET status = ? WHERE id = ?");
        $stmt->execute([$status, $id]);
    }

    public function delete($id) {
        $db = Database::getInstance()->getConnection();
        $db->prepare("DELETE FROM pedidos WHERE id = ?")->execute([$id]);
        $db->prepare("DELETE FROM pedido_itens WHERE pedido_id = ?")->execute([$id]);
    }

}

