<?php

$where = '';

if(!empty($_REQUEST['nome'])) {
    $where = "WHERE f.nome LIKE '%{$_REQUEST['nome']}%'";
}

$db = new Database();

if($db->connect()) {

    $dados = $db->sqlQueryArray(
        "SELECT
            f.nome,
            fc.nome AS funcao
        FROM funcionario f
        INNER JOIN funcao fc ON fc.id = f.funcao_id
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