<?php

$where = '';

if(!empty($_REQUEST['placa'])) {
    $where = "AND v.placa LIKE '%{$_REQUEST['placa']}%'";
}

$db = new Database();

if($db->connect()) {

    $dados = $db->sqlQueryArray(
        "SELECT  
            v.placa, 
            f.nome, 
            r.data, 
            v.vel_maxima, 
            r.velocidade, 
            concat(ROUND( ( (r.velocidade - v.vel_maxima) * 100 / v.vel_maxima) ), '%') as diff,
            r.latitude, 
            r.longitude 
            FROM rastreamento r 
            INNER JOIN veiculo v ON r.veiculo_id = v.id 
            INNER JOIN funcionario f ON r.funcionario_id = f.id 
            WHERE r.velocidade > v.vel_maxima 
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