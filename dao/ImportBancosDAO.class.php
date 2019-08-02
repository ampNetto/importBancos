<?php

class ImportBancosDAO extends jnDAO{
	
	public function setImporBanco($imb_banco, $imb_ano, $imb_mes, $imb_cod_cosif, $imb_desc_cosif, $imb_cod_rubrica, $imb_desc_rubrica, $imb_saldo_anterior, $imb_debito, $imb_credito, $imb_saldo_atual){
		$sql="
			INSERT INTO public.cosif
					(
					banc_id,
					imb_ano,
					imb_mes, 
					imb_cod_cosif, 
					imb_desc_cosif, 
					imb_cod_rubrica, 
					imb_desc_rubrica, 
					imb_saldo_anterior, 
					imb_debito, 
					imb_credito, 
					imb_saldo_atual
					)
				VALUES
 					(
 					{$imb_banco},
					{$imb_ano},
					{$imb_mes}, 
					'{$imb_cod_cosif}', 
					'{$imb_desc_cosif}', 
					'{$imb_cod_rubrica}', 
					'{$imb_desc_rubrica}', 
					{$imb_saldo_anterior}, 
					{$imb_debito} ,
					{$imb_credito} ,
					{$imb_saldo_atual}
					)
					RETURNING imb_id";

		// Prepara a query
		$stm = $this->conex->prepare ( $sql );
// 		var_dump($sql);die;
		// Executa a query
		if ($stm->execute ()) {
			return $stm->fetchAll ( PDO::FETCH_ASSOC );
		} else {
			return array ();
		}
		
	}
	public function getDadoBanco($imb_banco, $imb_ano, $imb_mes, $imb_cod_cosif, $imb_desc_cosif, $imb_cod_rubrica, $imb_desc_rubrica, $imb_saldo_anterior, $imb_debito, $imb_credito, $imb_saldo_atual){
		$sql = "
			SELECT
				*
			FROM
				public.cosif
			WHERE 
					banc_id = {$imb_banco}
					AND imb_ano = {$imb_ano}
					AND imb_mes = {$imb_mes}
					AND imb_cod_cosif = '{$imb_cod_cosif}'
					AND imb_desc_cosif = '{$imb_desc_cosif}'
					AND imb_cod_rubrica = '{$imb_cod_rubrica}'
					AND imb_desc_rubrica = '{$imb_desc_rubrica}'
					AND imb_saldo_anterior = {$imb_saldo_anterior}
					AND imb_debito = {$imb_debito}
					AND imb_credito = {$imb_credito}
					AND imb_saldo_atual = {$imb_saldo_atual}
			";
		
		// Prepara a query
		$stm = $this->conex->prepare ( $sql );

		// Executa a query
		if ($stm->execute ()) {
			return $stm->fetchAll ( PDO::FETCH_ASSOC );
		} else {
			return array ();
		}
	}
}
