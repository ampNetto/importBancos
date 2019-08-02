<?php
class ImportBancosENT extends jnENT {
	public function __construct() {
		parent::__construct ();
		
// 				$this->setNovoCampo ( "imb_banco", jnENT::TYPE_INTEGER, "Banco" );
		
				$this->setNovoCampo("imb_arquivo", jnENT::TYPE_VARCHAR, "Arquivo");
				$this->setCampoFile("imb_arquivo","");
		
// 				$this->setPropriedade("imb_banco", jnENT::PROP_FK, new BancoDAO());
// 				$this->setPropriedade("imb_banco", jnENT::PROP_AUTOCOMPLETE, "banco");
		
				$this->setDescricao ( "banc_nome" );
		$this->setNomeTela ( "Importação para Banco" );
	}
}
/**
 *	CREATE TABLE financas.import_banco_tabela
 *(
 *imb_id SERIAL PRIMARY KEY,
 *imb_banco INTEGER,
 *imb_arquivo VARCHAR
 *)
 **/