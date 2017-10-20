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
                <div class="quadro-formulario" style="height: 250px !important;">
                    <div class="header-formulario">
                       <i class="fa fa-pencil-square-o fa-2x fa-pull-left fa-white" style="padding-top: 5px; padding-left: 10px; padding-right: 5px; width:30px; height: 30px;"></i> 
                       <h4 style="color:white; padding-top: 10px;">NOVO PRODUTO</h4>
                    </div>
                   <div class="filtro-body">
                        <form action="/aeroweb/filtar-movimentacao" method="POST">
                            <div>
                                <div class="linha">
                                    <label>
                                        <b>Nome:</b>
                                    </label>
                                    <input type="text" name="nome" id="nome">
                                </div> 
                                <div class="linha">
                                    <label>
                                        <b>Tipo:</b>
                                    </label>
                                    <select id="tipoProduto" name="tipo" value="">
                                    </select>
                                </div> 
                                <div class="linha">
                                    <label>
                                        <b>Valor:</b>
                                    </label>
                                    <input type="text" name="valor" id="valor">
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
                        <table id="tbProdutos" class="table table-striped table-hover display">
                            <thead>
                                <tr>                                    
                                    <th style="width: 60%" align="left">Nome</th>
                                    <th style="width: 20%" align="left">Tipo</th>
                                    <th style="width: 10%" align="left">Valor</th>
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
            var $tbProdutos;
            $(function(){
                listarTipoProduto();
                $tbProdutos = $("#tbProdutos").DataTable({
                    columns: [
                        { data: 'nome' },
                        { data: 'tipo' },
                        { data: 'valor' },
                        { data: 'id',
                            render: function(data, type, row, meta) {
                                return '<button onClick="clicou('+data+');" style="background-color: Transparent; border: none;"><i class="fa fa-pencil-square-o fa-pull-left"></i></button>';
                            }
                        }
                    ]
                });
                atualizarLista();
                
                $(".submit").click(function(){
                    $.post("/mercadoSoftexpert/php/Produto/CadastroProduto.php",
                    {
                        nome: $("#nome").val(),
                        tipoProdutoId: $("#tipoProduto").val(),
                        valor: $("#valor").val()
                    },
                    function(data, status){
                        if (data == "sucesso") {
                            atualizarLista();
                        }
                        alert("Data: " + data + "\nStatus: " + status);
                    });
                });
            });
            
            function listarTipoProduto()
            {   var $tipoProdutoSelect = $("#tipoProduto");
                $.get( "/mercadoSoftexpert/php/TipoProduto/ListarTipoProduto.php", function( data ) {
                    $.each(JSON.parse(data), function(pos, item) {
                        $tipoProdutoSelect.append('<option value="'+item.id+'">'+item.nome+'</option>');
                    });
                });
            };
            
            function atualizarLista()
            {   $tbProdutos.clear();
                $.get( "/mercadoSoftexpert/php/Produto/ListarProduto.php", function( data ) {
                    var lista = JSON.parse(data);
                    $tbProdutos.rows.add(lista).draw();
                });
            };
        </script>
    </body>
    </body>
</html>
