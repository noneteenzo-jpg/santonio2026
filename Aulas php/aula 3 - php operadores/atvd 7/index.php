<?php

$nota1 = (float) $_POST["nota1"];
$nota2 = (float) $_POST["nota2"];

$media = ($nota1 + $nota2) / 2;

echo "<h1>Resultado</h1>";

echo "Nota 1: $nota1 <br>";
echo "Nota 2: $nota2 <br>";
echo "Média: " . number_format($media, 2) . "<br><br>";

if ($media >= 60) {
    echo "Aluno APROVADO!";
} elseif ($media >= 40) {
    echo "Aluno em RECUPERAÇÃO!";
} else {
    echo "Aluno REPROVADO!";
}

?>