<?php 

namespace ReportFPDF\Tabela;

use ReportFPDF\ArrayIterator;

/**
 * @package ReportFPDF\Tabela;
 *
 * Class ColunaList
 *
 * @author Anailson Mota anailsonmota@deso-se.com.br
 * @version 1.0.0
 */
class ColunaList extends ArrayIterator
{
	/** @var float $fLarguraTotal */
	private $fLarguraTotal;

	/**
	 * Adiciona uma nova coluna na lista
	 *
	 * @param Coluna $oColuna
	 * @param $mKey = null
	 *
	 * @author Anailson Mota anailsonmota@deso-se.com.br
	 * @since 1.0.0
	 */
	public function add(Coluna $oColuna, $mKey = null) 
	{
		$mKey = $oColuna->getTitulo();
		parent::attach($oColuna, $mKey);
		$this->fLarguraTotal += $oColuna->getConfiguracao()->getLargura();
	}

	/**
	 * Retorna a largura total das colunas
	 *
	 * @return float
	 *
	 * @author Anailson Mota anailsonmota@deso-se.com.br
	 * @since 1.0.0
	 */
	public function getLarguraTotal(): float {
		return $this->fLarguraTotal;
	}

	/**
	 * Constrói uma lista a partir de um array de Colunas
	 *
	 * @param array $aElementos
	 * @return ColunaList
	 *
	 * @author Anailson Mota anailsonmota@deso-se.com.br
	 * @since 1.0.0
	 */
	public static function create(array $aElementos)
	{
		$loColunas = new ColunaList;
		/** @var Coluna $oColuna */
		foreach ($aElementos as $iPosicao => $oColuna) {
			$oColuna->setPosicao($iPosicao);
			$loColunas->add($oColuna);
		}
		return $loColunas;
	}

	/**
	 * Ordena as colunas do relatório por sua posição
	 *
	 * @return ColunaList
	 *
	 * @author Anailson Mota anailsonmota@deso-se.com.br
	 * @since 1.0.0
	 */
	public function getOrdenadas(): ColunaList
	{
		return $this->ordenar(function(Coluna $oColuna1, Coluna $oColuna2) {
			$iOrdenacao1 = $oColuna1->getPosicao();
			if (is_null($iOrdenacao1)) {
				return 1;
			}

			$iOrdenacao2 = $oColuna2->getPosicao();
			if (is_null($iOrdenacao2)) {
				return -1;
			}

			return $iOrdenacao1 <=> $iOrdenacao2;
		});
	}
}
