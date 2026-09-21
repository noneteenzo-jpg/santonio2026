<?php
if (isset($_GET["quantidade"]) && isset($_GET["valor"])) {
    $quantidade = $_GET["quantidade"];
    $valordoitem = $_GET["valor"];
    $mult = $quantidade * $valordoitem;
    echo "valor total igual a $mult";
}
