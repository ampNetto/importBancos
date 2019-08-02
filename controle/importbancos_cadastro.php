<?php
require_once 'config.php';
// biblioteca para ler arquivo xls, ele nao le xlsx
include '../lib/excel_reader.php';
// biblioteca para ler arquivo xlsx ele nao le xls
include '../lib/SimpleXLSX.php';

// inicio das classe
class ImportBancosCadastro extends jnControleCadastro {
	
// 	variavel private para a mensage de certo errado
	private $msgTipo = array() ;
	/**
	 * Contrutor da classe
	 */
	public function __construct() {
		// Seta os arquivos de controle
		$this->setArquivoCadastro ( "importbancos" );

		// Chama o contrutor da classe pai
		parent::__construct ( new ImportBancosDAO (), true );
	}
	public function doBeforeGeraTemplate() {
		parent::doBeforeGeraTemplate();
		
// 		chamar arquivo import_banco.js para java script
		$this->setExtraJavaScript ( "admin/view/js/import_banco.js" );
// 		chamar nova tela tpl para funcionar a importação
		$this->setExtraTemplate ( "import_banco.tpl" );
		
		
// 		$this->objDAO->getEntidade ()->setCampoFile ( '', 'banco' );
// 		recupera o diretorio para salvar a importação
		$diretorio = "../../uploads/bancos";
// 		se nao tiver o diretorio ira criar um novo
		if (! is_dir ( $diretorio )) {
			mkdir ( "../../uploads/bancos/" );
		}
// 		
	}
	public function acaoDefault(){
		parent::acaoDefault();
// 		recupera na url a ação para importacao
		$acao = $this->_request('acao');
		
		switch ($acao) {
			case 'importArquivos':
				$this->importarArquivos();
				break;
		}
		
	}
	
	public function importarArquivos() {
		
		unset($this->msgTipo);
// 		recupera os arquivos de importação
		$arquivo = isset ( $_FILES ['arquivo'] ) ? $_FILES ['arquivo'] : FALSE;
		$nomeArqui = $arquivo;
// 		recupera o id do banco
		$imb_banco = $_REQUEST['imb_banco'];
// 		salva o undereço que sera importado
		$diretorio = "../../uploads/bancos";
// 		se existir arquivos salva na pasta do diretorio
		if ($arquivo) {
// 			separa a arry para salvar na pasta do diretorio os arquivos
			for($i = 0; $i < count ( $arquivo ['name'] ); $i ++) {
				$destino = $diretorio . "/" . $arquivo ['name'] [$i];
				move_uploaded_file ( $arquivo ['tmp_name'] [$i], $destino );
			}
		}
// 		armazena uma nova variavel o caminho dos arquivos
		$path = $diretorio;
// 		abrir o diretorio
		$diretorio = dir ( $diretorio );
		if($arquivo){
// 			começa a ler os arquivos no diretorio
			while ( $arquivo = $diretorio->read () ) {
// 				criar uma array para separa a extenção e nome
				$extencao = explode ( ".", $arquivo );
				$nomeArqui = $arquivo;
// 				verificase tem a extenção 
				if (isset ( $extencao [2] )) {
// 					verifica qual a extenção se tem o nome e a data no meio da extenção
					if ($extencao [2] == 'xls' && $extencao [0] && strlen ( $extencao [1] ) > 1) {
// 						lança para outra função o arquivo e o banco
						$this->imporForBancoXLS ( $path . '/' . $arquivo, $imb_banco, $arquivo);
					}
// 					verifica qual a extenção se tem o nome e a data no meio da extenção
					if ($extencao [2] == 'xlsx' && $extencao [0] && strlen ( $extencao [1] ) > 1) {
// 						lança para outra função o arquivo e o banco
						$this->imporForBancoXLSX ( $path . '/' . $arquivo, $imb_banco, $arquivo );
					}
				}else{
					$this->msgTipo[] = array(false, $nomeArqui);
				}
				
// 				verifica se tem o nome do arquivo
				if ($extencao [0]) {
// 					exclui do diretorio o arquivo que foi importado
					unlink ( $path . '/' . $arquivo );
				}
			}
		}
// 		unir as array repedidas 
		$msg = array_unique ( $this->msgTipo, SORT_REGULAR );
		
// 		mostrar na tela se foi sucesso ou nao a importação com seue nomes do arquivo
		foreach ($msg as $value){
// 			echo '<pre>';
// 			nome do arquivo é "." nao tem aquivo nenhum com esse nome entao e so pular
			if( $value[1] != '.'){
				if($value[0] == false){
					$this->setMsgErro("Erro ao importar o Arquivo ".$value[1]);
				}else{
					$this->setMsgSucesso("Arquivo ".$value[1]." importados com sucesso!");
				}
			}
			
		}
		// 		retorna a tela de cadastro para importar outros arquivos
		header('Location: importbancos_cadastro.php');exit;
		
	}
// 	função para ler XLSX
	public function imporForBancoXLSX($aqruivo, $imb_banco, $nomeArqui) {
// 		quebar em array o arquivo para recupara a data
		$petaco = explode ( "_", $aqruivo );
// 		quebra a data em array
		$datas = explode ( ".", $petaco [1] );
		
// 		estancia da biblioteca SimpleXLSX e ferifica se esta certo a leitura do Arquivo
// 		e ja salva na variavel as array com o s valores
		if ($xlsx = SimpleXLSX::parse ( $aqruivo )) {
// 			ve a dimenção dos valores
			$dim = $xlsx->dimension ();
			$num_cols = $dim [0];
			$num_rows = $dim [1];
// 			cama outra função para poder salvar
// 								valores,       data,    extenção, id do banco
			$this->extencaoXLS ( $xlsx->rows (), $datas, 'xlsx' , $imb_banco, $nomeArqui);
		} else {
			echo SimpleXLSX::parseError ();
		}
	}
	public function imporForBancoXLS($aqruivo, $imb_banco, $nomeArqui) {
		
// 		estancio da biblioteca para ler o XLS
		$excel = new PhpExcelReader ();
// 		quebar em array o arquivo para recupara a data
		$petaco = explode ( "_", $aqruivo );
// 		quebra a data em array
		$datas = explode ( ".", $petaco [1] );
		
// 		começa a ler o arquivo
		$excel->read ( $aqruivo );
// 		arquivo esta armazenado em uma matriz tem que quebrar para recuperar os valores interno
		foreach ( $excel->sheets as $key => $value ) {
			foreach ( $value as $ky => $val ) {
// 				armazena na variavel de o valor esta vazio
				$pkCount = (is_array ( $val ) ? count ( $val ) : 0);
// 				se não estiver fazio manda para função de salvar
				if ($pkCount != 0) {
// 					cama outra função para poder salvar
// 										valores, data,extenção, id do banco
					$this->extencaoXLS ( $val, $datas, 'xls' , $imb_banco, $nomeArqui);
				}
			}
		}
	}
// 	função para salvar na tabela do banco de dados
	public function extencaoXLS($campos, $datas, $ext, $imb_banco, $nomeArqui) {
// 		var_dump($nomeArqui);die;
		$impDAO = new ImportBancosDAO ();
// 		array para armazenar mensage de true ou false
		$msg = array();
		$i = 0;
// 		foreach para salvar na tabela os valores que estão nas linhas
		foreach ( $campos as $valor ) {
			$i++;
// 				recupera o campo para ver se esta vazio
			$novoCount = (is_array ( $valor ) ? count ( $valor ) : 0);
				// 				se tiver os 8 campos certinho e outras comparaçoes ira salvar na tabela
			if ($novoCount >= 7 && $valor [1] != 'COSIF' && $ext == 'xls') {
// 					verifica se ja foi repedido os falores se "sim" nao salva se "nao" ele salva 
				if (! $impDAO->getDadoBanco ( $imb_banco, $datas [0], $datas [1], $valor [1], $valor [2], $valor [3], $valor [4], $valor [6], $valor [7], $valor [9], $valor [10] )) {
// 						salva na tabel e ja recebe se deu certo ou nao e armazena na array msg
					if (! $impDAO->setImporBanco ( $imb_banco, $datas [0], $datas [1], $valor [1], $valor [2], $valor [3], $valor [4], $valor [6], $valor [7], $valor [9], $valor [10] )) {
						$msg[] = array(true);
					} else {
						$msg[] = array(false);
					}
				}
			}
			$coluna = isset ( $valor [0] ) ? $valor [0] : '';
// 				se tiver os 8 campos certinho e outras comparaçoes ira salvar na tabela
			if ($novoCount >= 7 && $coluna != 'COSIF' && $ext == 'xlsx' && $valor [1]) {
// 					verifica se ja foi repedido os falores se "sim" nao salva se "nao" ele salva 
				if (! $impDAO->getDadoBanco ( $imb_banco, $datas [0], $datas [1], $valor [0], $valor [1], $valor [2], $valor [3], $valor [5], $valor [6], $valor [8], $valor [9] )) {
// 						salva na tabel e ja recebe se deu certo ou nao e armazena na array msg
					if (! $impDAO->setImporBanco ( $imb_banco, $datas [0], $datas [1], $valor [0], $valor [1], $valor [2], $valor [3], $valor [5], $valor [6], $valor [8], $valor [9] )) {
						$msg[] = array(true);
					} else {
						$msg[] = array(false);
					}
				}
			}
		}
// 		var_dump($msg);
// 		verifica se deu erro em algum insert do banco na array
// 		e salvar na variavel $this->msgTipo
		if(in_array(false, $msg)){
			$this->msgTipo[] = array(false, $nomeArqui);
		}else{
			$this->msgTipo[] = array(true, $nomeArqui);
		}
		
// 		destroi a arry
		unset($msg);
	}
}
new ImportBancosCadastro ();
