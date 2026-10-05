<?php

$cadastro = [
    ["nome" => "João", "idade" => 18],
    ["nome" => "Maria", "idade" => 20],
    ["nome" => "Pedro", "idade" => 19]
];

$cadastro[1]["idade"] = 21;

print_r($cadastro);

?>