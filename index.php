<?php
    require('php/Utils.php');
    require('php/Database.php');

    if(!empty($_REQUEST['mdl']) && !empty($_REQUEST['file'])) {

        require("pages/{$_REQUEST['mdl']}/{$_REQUEST['file']}");

    } else {
        require('pages/header.php');
        require('pages/menu.php');
        echo '<main role="main" class="container">';

        if(!empty($_REQUEST['page'])) {
    
            switch($_REQUEST['page']) {
    
                case 'relVeiculo':
                    require('pages/relVeiculo/veiculo.php');
                    JSRequire('relVeiculo', 'RelVeiculo.js');
                    break;
    
                case 'relFuncionario':
                    require('pages/relFuncionario/funcionario.php');
                    JSRequire('relFuncionario', 'RelFuncionario.js');
                    break;

                case 'relVeiculosAcimaVelocidade':
                    require('pages/relVeiculosAcimaVelocidade/veiculosacimavelocidade.php');
                    JSRequire('relVeiculosAcimaVelocidade', 'RelVeiculosAcimaVelocidade.js');
                    break;
    
            }
    
        } else {
            require('pages/home/home.php');
        }
        
        echo '</main>';
        require('pages/footer.php');
    }