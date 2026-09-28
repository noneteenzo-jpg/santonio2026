//6 Algoritmo de uma tabuada de 1 a 10 usando for

<?php

for ($numero = 1; $numero <= 10; $numero++) {

    echo "Tabuada do $numero:<br>";

    for ($i = 1; $i <= 10; $i++) {
        $resultado = $numero * $i;

        echo "$numero x $i = $resultado<br>";
    }

    echo "<br>";
}

?>


//7 Programa em PHP para calcular o IMC
<?php

$peso = 70;
$altura = 1.75;

$imc = $peso / ($altura * $altura);

echo "Peso: $peso kg<br>";
echo "Altura: $altura m<br>";
echo "IMC: " . number_format($imc, 2) . "<br>";

if ($imc < 18.5) {
    echo "Classificação: Abaixo do peso";
} elseif ($imc < 25) {
    echo "Classificação: Peso normal";
} elseif ($imc < 30) {
    echo "Classificação: Sobrepeso";
} else {
    echo "Classificação: Obesidade";
}

?>

//9 Programa em PHP com números de 100 a 200, incremento de 2
<?php

for ($i = 100; $i <= 200; $i += 2) {
    echo $i . "<br>";
}

?>

//10 Programa em PHP que apresenta os valores ímpares de 500 a 1000
<?php

for ($i = 500; $i <= 1000; $i++) {

    if ($i % 2 != 0) {
        echo $i . "<br>";
    }

}

?>
