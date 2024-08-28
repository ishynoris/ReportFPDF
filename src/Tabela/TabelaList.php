<?php 

namespace ReportFPDF\Tabela;

use ReportFPDF\ArrayIterator;

/**
 * @package ReportFPDF\Tabela;
 *
 * Class TabelaList
 *
 * @author Anailson Mota anailsonmota@deso-se.com.br
 * @version 1.0.0
 */
class TabelaList extends ArrayIterator
{
	/**
	 * Adiciona uma nova tabela na lista
	 *
	 * @param Tabela $oTabela
	 *
	 * @author Anailson Mota anailsonmota@deso-se.com.br
	 * @since 1.0.0
	 */
	public function add(Tabela $oTabela) {
		$sTitulo = $oTabela->getTitulo();
		parent::attach($oTabela, $sTitulo);
	}

	/**
	 * Ordena as tabelas por pelo seu título de forma crescente
	 *
	 * @return TabelaList
	 *
	 * @author Anailson Mota anailsonmota@deso-se.com.br
	 * @since 1.0.0
	 */
	public function ordenarPorNomeCres(): TabelaList 
	{
		return $this->ordenar(function(Tabela $oTabela1, Tabela $oTabela2) {
			return strcmp($oTabela1->getTitulo(), $oTabela2->getTitulo());
		});
	}
}
