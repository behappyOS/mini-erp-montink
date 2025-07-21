<?php

require_once 'app/models/Cupom.php';

class CupomController
{
    public function validar($codigo, $subtotal)
    {
        $cupom = new Cupom();
        $valido = $cupom->validar($codigo, $subtotal);

        echo json_encode($valido);
    }
}
