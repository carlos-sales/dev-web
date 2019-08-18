<?php

$where = '';

if(!empty($_REQUEST['placa'])) {
    $where = "WHERE v.placa LIKE '%{$_REQUEST['placa']}%'";
}

$db = new Database();

if($db->connect()) {

    $dados = $db->sqlQueryArray(
        "SELECT
            v.nome,
            v.placa,
            v.vel_maxima
        FROM veiculo v
        {$where}"
    );

    echo json_encode(array(
        'status' => 'success',
        'data' => $dados
    ));

} else {
    echo json_encode(array(
        'status' => 'failure',
        'message' => 'Erro ao conectar ao banco'
    ));
}