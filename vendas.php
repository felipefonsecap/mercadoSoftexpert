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
                <div class="quadro-formulario">
                    <div class="header-formulario">
                       <i class="fa fa-pencil-square-o fa-2x fa-pull-left fa-white" style="padding-top: 5px; padding-left: 10px; padding-right: 5px; width:30px; height: 30px;"></i> 
                       <h4 style="color:white; padding-top: 10px;">REALIZAR VENDA</h4>
                    </div>
                   <div class="filtro-body">
                        <form action="/aeroweb/filtar-movimentacao" method="POST">
                            <div id="listaVenda">
                                <div class="linha item">
                                    <div class="coluna-form">
                                        <div class="col-sm">
                                            <label>
                                                <b>Tipo:</b>
                                            </label>
                                        </div>

                                        <select name="tipo" value="" class="form-element">
                                        </select>
                                    </div>  
                                    <div class="coluna-form">
                                        <div class="col-sm">
                                            <label>
                                                <b>Produto:</b>
                                            </label>
                                        </div>
                                        <div >
                                            <select name="produto" value="" class="form-element">
                                                <option value="1">&nbsp;</option>
                                            </select>
                                        </div>
                                    </div>  
                                    <div class="coluna-form-sm">
                                        <div class="col-sm">
                                            <label>
                                                <b>Quantidade:</b>
                                            </label>
                                        </div>
                                        <div>
                                            <input type="number" min="0" id="quantidade" name="quantidade" value="0" class="form-element">
                                        </div>
                                    </div>  
                                    <div class="coluna-form-sm">
                                        <div >
                                            <label>
                                                <b>Valor Total:</b>
                                            </label>
                                        </div>
                                        <div>
                                            <input type="text" id="valor" name="valor" value="0" class="form-element" readonly="" style="background-color: lightgray">
                                        </div>
                                    </div>  
                                    <div class="coluna-form-sm">
                                        <div >
                                            <label>
                                                <b>Imposto Total:</b>
                                            </label>
                                        </div>
                                        <div>
                                            <input type="text" id="imposto" name="imposto" value="0" class="form-element" readonly="" style="background-color: lightgray">
                                        </div>
                                    </div> 
                                    <div class="coluna-form botoes">  
                                        <div >
                                            <label>
                                                &nbsp;
                                            </label>
                                        </div>
                                        <button class="botao addItem" type="button" style="margin-left: 15px;"> + item </button>
                                    </div>
                                </div>
                            </div>
                            <div class="linha" style="float:left;">
                                <div class="coluna-form">
                                    <div >
                                        <label>
                                            <b>Valor Total Venda:</b>
                                        </label>
                                    </div>
                                    <div>
                                        <input type="text" id="valorTotal" value="0" class="form-element" readonly="" style="background-color: lightgray">
                                    </div>
                                </div>  
                            </div>
                            <div class="linha" style="float:left;">
                                <div class="coluna-form">
                                    <div >
                                        <label>
                                            <b>Imposto Total Venda:</b>
                                        </label>
                                    </div>
                                    <div>
                                        <input type="text" id="impostoTotal" value="0" class="form-element" readonly="" style="background-color: lightgray">
                                    </div>
                                </div>
                            </div>
                            <div class="linha" style="float:left;">
                                <button class="submit" id="salvar" type="button">Concluir venda</button>
                            </div>
                        </form> 
                   </div>
                </div>
            </div>
        </div>
        <script>
            var tipoProduto = [];
            
            $(function(){
                listarTipoProduto();
                setarEventosLinha();
                $(".submit").on('click', function() {
                    salvar();
                });
            });
            
            function listarTipoProduto()
            {
                $.get( "/mercadoSoftexpert/php/TipoProduto/ListarTipoProduto.php", function( data ) {
                    tipoProduto = JSON.parse(data);
                    var $tipoProdutoSelect = $('[name="tipo"]');
                    $tipoProdutoSelect.empty();
                    $tipoProdutoSelect.append('<option value="" imposto="0">Selecione</option>');
                    $.each(JSON.parse(data), function(pos, item) {
                        $tipoProdutoSelect.append('<option value="'+item.id+'" imposto="'+item.imposto+'">'+item.nome+'</option>');
                    });
                    $tipoProdutoSelect.val('');
                });
            }
            
            function filtrarProduto(elemento)
            {
                var tipo = $(elemento).val();
                var pai = $(elemento).closest('.item');
                $.get( "/mercadoSoftexpert/php/Produto/ListarProdutoPorTipo.php?tipo="+tipo, function( data ) {
                    tipoProduto = JSON.parse(data);
                    var $produtoSelect = $(pai).find('[name="produto"]');
                    $produtoSelect.empty();
                    $produtoSelect.append('<option value="0" preco="0">Selecione</option>');
                    $.each(JSON.parse(data), function(pos, item) {
                        $produtoSelect.append('<option value="'+item.id+'" preco="'+item.valor+'">'+item.nome+'</option>');
                    });
                });
            }
            
            
            function calcularValorTotal(linha)
            {
                var preco = linha.find('[name="produto"] option:selected').attr('preco');
                var quantidade = linha.find('[name="quantidade"]').val();
                var total = preco * quantidade;
                linha.find('[name="valor"]').val(total.toFixed(2));
                calcularValorTotalVenda();
            }
            
            function calcularImpostoTotal(linha)
            {
                var imposto = linha.find('[name="tipo"] option:selected').attr('imposto');
                var preco = linha.find('[name="produto"] option:selected').attr('preco');
                var quantidade = linha.find('[name="quantidade"]').val();
                var total = preco ? (imposto * quantidade * preco / 100) : 0.00;
                linha.find('[name="imposto"]').val(total.toFixed(2));
                calcularImpostoTotalVenda();
            }
            
            function removerLinha(botao)
            {
                $(botao).closest(".item").remove();
                if ($(".botoes").length == 1) {
                    $(".removeItem").remove();
                }
                calcularImpostoTotalVenda();
                calcularValorTotalVenda();
            }
            
            function novaLinha() 
            { 
                if ($(".botoes").length == 1) {
                    $(".botoes").append('<button class="botao-danger removeItem" type="button" style="margin-left: 15px;"> - item </button>');
                    $('.removeItem').on('click', function() {
                        removerLinha(this);
                    });
                }
               
                $("#listaVenda").append($(".item:first").clone());
                
                setarEventosLinha();
            }
            
            function setarEventosLinha()
            {                
                $(".addItem:last").on('click', function() {
                    novaLinha();
                }); 
        
                $(".botoes:last .removeItem").on('click', function() {
                    removerLinha(this);
                });
                
                $('[name="tipo"]').change(function(){
                    filtrarProduto(this);
                    calcularImpostoTotal($(this).closest('.item'));
                });
                
                $('[name="produto"]').on('change', function(){
                   calcularValorTotal($(this).closest('.item')); 
                });
                
                $('[name="quantidade"]').on('change', function(){
                   calcularValorTotal($(this).closest('.item'));
                   calcularImpostoTotal($(this).closest('.item'));
                });
                
                resetarValoresLinha($(".item:last"));
            }
            
            function resetarValoresLinha(linha)
            {
                linha.find('select').val('');
                linha.find('input').val('0');
            }
            
            function calcularValorTotalVenda()
            {
                var total = 0;
                $.each($('[name="valor"]'), function(pos, item) {
                    total += parseFloat($(item).val());
                });
                
                $("#valorTotal").val(total.toFixed(2));
            }
            
            function calcularImpostoTotalVenda()
            {
                var total = 0;
                $.each($('[name="imposto"]'), function(pos, item) {
                    total += parseFloat($(item).val());
                });
                
                $("#impostoTotal").val(total.toFixed(2));
            }
            
            function salvar()
            {
                var vetorVenda = [];
                    $.each($(".item"), function(pos, item) {
                       var objVenda = {
                           "produto_id" : $(item).find('[name="produto"]').val(),
                           "tipo_produto_id" : $(item).find('[name="tipo"]').val(),
                           "quantidade" : $(item).find('[name="quantidade"]').val(),
                           "valor_unitario" : $(item).find('[name="produto"] option:selected').attr('preco'),
                           "imposto_unitario" : $(item).find('[name="tipo"] option:selected').attr('imposto')
                       };
                       vetorVenda.push(objVenda);
                   });
                   $.post("/mercadoSoftexpert/php/Venda/CadastrarVenda.php",
                    {
                        lista : vetorVenda
                    },
                    function(data, status){
                        console.log(data);
                        if (data == "sucesso") {
                            //atualizarLista();
                        }
                        alert("Data: " + data + "\nStatus: " + status);
                    });
            }
        </script>
    </body>
</html>
