<?php
function redirect($url) {
    header("Location: $url");
    exit;
}

function formatMoney($valor) {
    return "R$ " . number_format($valor, 2, ',', '.');
}
