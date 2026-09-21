<?php

if (isset($_GET["salario"])) {

    $salario = $_GET["salario"];

    $inss = $salario * 0.08;
    $ir = $salario * 0.075;
    $transporte = $salario * 0.06;

    $liquido = $salario - $inss - $ir - $transporte;

    echo "<h2>Salário Líquido: R$ " . number_format($liquido, 2, ',', '.') . "</h2>";

}

?>