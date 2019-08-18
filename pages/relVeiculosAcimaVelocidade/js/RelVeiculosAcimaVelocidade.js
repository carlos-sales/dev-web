Cmp.RelVeiculosAcimaVelocidade = function() {
    
    var private = {

        render: function() {

            Cmp.createInput({
                id: 'inputPlaca',
                renderTo: '#divInputPlaca',
                label: 'Placa do veículo',
                width: '200px'
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
                id: 'gridDadosVeiculosAcimaVelocidade',
                renderTo: '#divCmpGridVeiculosAcimaVelocidade',
                header: [
                    {
                        text: 'Placa',
                        field: 'placa',
                        width: 75
                    }, {
                        text: 'Funcionário',
                        field: 'nome',
                        width: 175
                    }, {
                        text: 'Data',
                        field: 'data',
                        width: 150
                    }, {
                        text: 'Vel. Max.',
                        field: 'vel_maxima'
                    }, {
                        text: 'Vel. Reg.',
                        field: 'velocidade'
                    }, {
                        text: 'Diff. Vel.',
                        field: 'diff'
                    }, {
                        text: 'Latitude',
                        field: 'latitude',
                        width: 100
                    }, {
                        text: 'Longitude',
                        field: 'longitude',
                        width: 100
                    }
                ]
            });
        },

        buscar: function() {
            Cmp.showLoading();

            Cmp.request({
                url: 'index.php?mdl=relVeiculosAcimaVelocidade&file=ds_veiculosacimavelocidade.php',
                params: {
                    placa: Cmp.get('inputPlaca').getValue()
                },
                success: function(res) {
                    Cmp.hideLoading();
                    if(res.status == 'success') {
                        Cmp.get('gridDadosVeiculosAcimaVelocidade').loadData(res.data);
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