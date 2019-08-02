<div class="tab-content">
	<div class="table_dados">
		<div class="nav-tabs-custom">
			<ul class="nav nav-tabs">
				<form name="upload" enctype="multipart/form-data" method="post"
					action="importbancos_cadastro.php?acao=importArquivos">
					<div rel="campo_imb_banco" class="div_campo col-sm-6">
						<label class="inputObrigatorio">Banco</label> <br> <input
							type="text"
							class="inputInteger codAutocomplete form-control input-sm"
							name="imb_banco" rel="imb_banco" id="imb_banco"
							readonly="readonly" value=""> <input type="text"
							class="inputAutocomplete form-control input-sm  ui-autocomplete-input"
							ac="banco" name="busca_imb_banco" id="busca_imb_banco"
							rel="imb_banco" value="" autocomplete="off"><i
							tabindex="-1" title="Listar Todos" class="fa fa-fw fa-angle-down"
							style="cursor: pointer; margin-left: -30px; margin-top: 7px; position: absolute; font-size: 18px;"></i>
					</div>
					<div rel="campo_imb_arquivo" class="div_campo col-sm-6">
						<label class="inputObrigatorio">Arquivo</label> <i> (*) </i> <br>
						<div class="file-input file-input-new">
							<div class="kv-upload-progress hide">
								<div class="progress">
									<div
										class="progress-bar progress-bar-success progress-bar-striped active"
										role="progressbar" aria-valuenow="0" aria-valuemin="0"
										aria-valuemax="100" style="width: 0%;">0%</div>
								</div>
							</div>
							<div class="input-group ">
								<div class="input-group-btn">
									<div tabindex="500" class="btn btn-primary btn-file">
										<i class="glyphicon glyphicon-folder-open"></i>
										&nbsp;Procurar… <input
											class="inputVarchar form-control input-sm" type="file"
											name="arquivo[]" id="campo_upload" multiple="multiple">
									</div>
								</div>
							</div>
						</div>
					</div>
					<br>
					<div class="botoesAcao col-sm-12">
						<button class="btn btn-success" type="submit" value="Enviar">
							<i class="fa fa-save"></i> Enviar
						</button>
						<button class="btn btn-danger" type="button"
							name="cancelarCadastro" id="cancelarCadastro" value="Cancelar">
							<i class="fa fa-times"></i> Limpar
						</button>
					</div>
					 <br>
				</form>
			</ul>
		</div>
	</div>
</div>

<!-- The Modal -->
<div class="modal" id="myModal">
	<div class="modal-dialog">
		<div class="modal-content">

			<!-- Modal body -->
			<div align="center"><h4> Carregando</h4></div>
		</div>

	</div>
</div>



