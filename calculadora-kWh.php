<?php

header("Content-Type: application/json; charset=utf-8");

$v_acao = addslashes($_POST["v_acao"]);

if ($v_acao == 'LIST_CALC') {

    $ttl_horas = addslashes($_POST['v_horas']);
    $ttl_dias = addslashes($_POST['v_dias']);
    $ttl_potencia = addslashes($_POST['v_potencia']);
    $v_tarifa_KWh = 1.10;

    $ttl_kwh = $ttl_potencia * $ttl_horas * $ttl_dias / 1000;
    $v_result = $ttl_kwh * $v_tarifa_KWh;
    $vl_ttl = array("valorTotal" => round($v_result, 2));
    $v_json = json_encode($vl_ttl);

    echo $v_json;
}
