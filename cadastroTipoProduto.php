<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title></title>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <title>Mercadinho</title>
        <link rel="stylesheet" type="text/css" href="/mercadoSoftexpert/css/geral.css"> 
        <script type="text/javascript" src="/mercadoSoftexpert/bibliotecas/jquery-3.2.1.min.js"></script>
        <link rel="stylesheet" type="text/css" href="/mercadoSoftexpert/bibliotecas/font-awesome/css/font-awesome.min.css"> 
        <link rel="stylesheet" type="text/css" href="/mercadoSoftexpert/bibliotecas/dataTables/jquery.dataTables.min.css">  
        <script type="text/javascript" charset="utf8" src="/mercadoSoftexpert/bibliotecas/dataTables/jquery.dataTables.min.js"></script>
    </head>
    <body>
        <body>   
        <?php include 'cabecalho.php'; ?>
        <div style="width:100%; height: 100%; position: absolute">
            <?php include "menu.php"; ?>
            <div class="conteudo">    
                <div class="quadro-formulario" style="height: 200px !important;">
                    <div class="header-formulario">
                       <i class="fa fa-pencil-square-o fa-2x fa-pull-left fa-white" style="padding-top: 5px; padding-left: 10px; padding-right: 5px; width:30px; height: 30px;"></i> 
                       <h4 style="color:white; padding-top: 10px;">NOVO TIPO</h4>
                    </div>
                   <div class="filtro-body">
                        <form action="/mercadoSoftexpert/php/CadastroTipoProduto.php" method="POST">
                            <div>
                                <div class="linha">
                                    <label>
                                        <b>Tipo:</b>
                                    </label>
                                    <input type="text" name="nome" id="nome">
                                </div>     
                                <div class="linha">
                                    <label>
                                        <b>Imposto(%):</b>
                                    </label>
                                    <input type="number" name="imposto" id="imposto">
                                </div> 
                            </div>
                            <div class="linha">
                                <button class="submit" id="salvar" type="button">Salvar</button>
                            </div>
                        </form> 
                   </div>
                </div>
                <div class="quadro-formulario">
                    <div class="header-formulario">
                        <i class="fa fa-list fa-lg fa-pull-left fa-white" style="padding-top: 14px; padding-left: 10px; padding-right: 5px; width:30px; height: 30px;"></i>
                        <h4 style="color:white; padding-top: 10px;">LISTA DE TIPO DE PRODUTO</h4>
                    </div>
                    <div class="body-formulario">
                        <table id="tbTiposProdutos" class="table table-striped table-hover display">
                            <thead>
                                <tr>                                    
                                    <th style="width: 80%" align="left">Nome</th>
                                    <th style="width: 20%" align="left">Imposto</th>
                                    <th style="width: 10%" align="center">Ações</th>
                                </tr>
                            </thead>
                            <tbody>
                                
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <script>         
            var $tbTiposProdutos;
            $(function(){             
                $tbTiposProdutos = $("#tbTiposProdutos").DataTable({
                    columns: [
                        { data: 'nome' },
                        { data: 'imposto' },
                        { data: 'id',
                            render: function(data, type, row, meta) {
                                return '<button onClick="clicou('+data+');" style="background-color: Transparent; border: none;"><i class="fa fa-pencil-square-o fa-pull-left"></i></button>';
                            }
                        }
                    ]
                });
                
                atualizarLista();
                
                $(".submit").click(function(){
                    $.post("/mercadoSoftexpert/php/TipoProduto/CadastroTipoProduto.php",
                    {
                        nome: $("#nome").val(),
                        imposto: $("#imposto").val()
                    },
                    function(data, status){
                        if (data == "sucesso") {
                            atualizarLista();
                        }
                        alert("Data: " + data + "\nStatus: " + status);
                    });
                });
            });
            
            function atualizarLista()
            {   $tbTiposProdutos.clear();
                $.get( "/mercadoSoftexpert/php/TipoProduto/ListarTipoProduto.php", function( data ) {
                    var lista = JSON.parse(data);
                    $tbTiposProdutos.rows.add(lista).draw();
                });
            };
        </script>
    </body>
    </body>
</html>
