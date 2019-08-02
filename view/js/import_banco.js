$(function(){
	$('.box').remove();
	$('.fa-angle-down').remove();
	$('input:file').click(function(){
		$('#tabelasImport').remove();
	})
	
	$('input:file').change(function () {
		arquivos();
	});
	$('#cancelarCadastro').click(function(){
		$('[rel="imb_banco"]').val('');
		$("#campo_upload").val('');
		$('#tabelasImport').remove();
	});
	$('.btn-success').click(function(){
		var banco = $('#busca_imb_banco').val();
		var arquivo = $("#campo_upload").val();
		if(!banco){
			alert('Selecione um Banco');
			return false;
		}
		if(!arquivo){
			alert('Selecione um Arquivo');
			return false;
		}
			$('#myModal').modal();
	});
});

function arquivos(){
	var files = $("#campo_upload")[0].files;
	
	var tabela = '<div class="col-sm-6" id="tabelasImport">'
					+'<br><br><label>Arquivos a serem Importados</label>' 
					+'<table class="table table-hover table-bordered tableDados">'
						+'<tr class="ColumnTD">'
							+'<th>Posição</th><th>Arquivo</th>'
						+'</tr>'
					+'</table>'
				+'<div>';
		$('.nav-tabs').append(tabela);
	//+'<th>id</th><th>Arquivo</th><th>Info</th>'
	
	for (var i = 0; i < files.length; i++){
		console.log(files[i].name);
		var num = i+1;
		var colunas ='<tr class="ColumnTD">'
			+'<td>'+num+'</td><td>'+files[i].name+'</td>'
		+'</tr>';	
		$('.table').append(colunas);
		//+'<td>'+num+'</td><td>'+files[i].name+'</td><td>'+i+'</td>'
	}
	return false;
}
