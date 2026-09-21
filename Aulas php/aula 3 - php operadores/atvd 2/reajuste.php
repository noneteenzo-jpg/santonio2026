<?php
if (isset($_GET["valor"]) && isset($_GET["reajuste"])) {
    $valor = $_GET["valor"];
    $reajuste = $_GET["reajuste"];
    
    $reajuste = $reajuste / 100;
    $porcentaem = $reajuste + 1;
    
    $total = $valor * $porcentaem;
    echo "<h2>Valor do reajuste : $total</h2>";
    
}