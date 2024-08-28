<?php 


namespace ReportFPDF\Tabela;

use ReportFPDF\ArrayIterator;

/**
 * @package ReportFPDF\Tabela;
 *
 * Class LinhaList
 *
 * @author Anailson Mota anailsonmota@deso-se.com.br
 * @version 1.0.0
 */
class LinhaList extends ArrayIterator
{
	/**
	 * Adiciona uma nova linha na lista
	 *
	 * @param Linha $oLinha
	 *
	 * @author Anailson Mota anailsonmota@deso-se.com.br
	 * @since 1.0.0
	 */
	public function add(Linha $oLinha) 
	{
		$iLinha = $oLinha->getLinha();
		parent::attach($oLinha, $iLinha);
	}

	/**
	 * Remove o valor de uma determinada coluna
	 *
	 * @param string $sColuna
	 *
	 * @author Anailson Mota anailsonmota@deso-se.com.br
	 * @since 1.0.0
	 */
	public function removerColuna(string $sColuna) {
		foreach ($this as $oLinha) {
			$oLinha->removerCelula($sColuna);
		}
	}

	/**
	 * Agrupa as linhas pelo valor de uma determinada coluna
	 *
	 * @param string $sColuna
	 * @return array (@see LinhaList[])
	 *
	 * @author Anailson Mota anailsonmota@deso-se.com.br
	 * @since 1.0.0
	 */
	public function agruparPorValorColuna(string $sColuna): array {
		return $this->reduzir(function(array $aLinhas, Linha $oLinha) use ($sColuna) {
			$sValor = $oLinha->getValor($sColuna);
			$loLinhas = $aLinhas[$sValor] ?? new LinhaList;
			$loLinhas->add($oLinha);
			$aLinhas[$sValor] = $loLinhas;
			return $aLinhas;
		}, []);
	}
}
