Cmp.RelFuncionario = function() {
    
    var private = {

        render: function() {

            Cmp.createInput({
                id: 'inputNome',
                renderTo: '#divInputNome',
                label: 'Nome do funcionário',
                width: '300px'
            });

            Cmp.createButton({
                id: 'btnBuscar',
                renderTo: '#divBtnConsultar',
                text: 'Buscar',
                handler: function() {
                    private.buscar();
                }
            });

            Cmp.createGrid({
                id: 'gridDadosFuncionario',
                renderTo: '#divCmpGridFuncionario',
                header: [
                    {
                        text: 'Nome',
                        field: 'nome'
                    }, {
                        text: 'Função',
                        field: 'funcao',
                        width: 200
                    }
                ]
            });
        },

        buscar: function() {
            Cmp.showLoading();

            Cmp.request({
                url: 'index.php?mdl=relFuncionario&file=ds_funcionario.php',
                params: {
                    nome: Cmp.get('inputNome').getValue()
                },
                success: function(res) {
                    Cmp.hideLoading();
                    if(res.status == 'success') {
                        Cmp.get('gridDadosFuncionario').loadData(res.data);
                    } else {
                        Cmp.showErrorMessage(res.message || 'Ocorreu um erro na requisição');
                    }
                }
            });
        }

    };

    this.init = function() {
        private.render();
    }

}