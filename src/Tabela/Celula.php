<?php 

namespace ReportFPDF\Tabela;

/**
 * @package ReportFPDF\Tabela
 *
 * Class Celula
 *
 * @author Anailson Mota anailsonmota@moobi.com.br
 * 
 * @version 1.0.0
 */ 
class Celula 
{ 
	/** @var string $sValor */
	private $sValor;

	/** @var Coluna $oColuna */
	private $oColuna;

	/** @var Linha $oLinha */
	private $oLinha;

	/**
	 * Construtor
	 *
	 * @param string $sValor
	 * @param Coluna $oColuna
	 * @param Linha $oLinha
	 *
	 * @author Anailson Mota anailsonmota@moobi.com.br
	 * @since 1.0.0
	 */
	public function __construct(Coluna $oColuna, Linha $oLinha) 
	{
		$this->oColuna = $oColuna;
		$this->oLinha = $oLinha;
		$this->sValor = $oLinha->getValor($oColuna->getTitulo());
	}
	
	/**
	 * Retorna o valor da célula
	 *
	 * @return string
	 *
	 * @author Anailson Mota anailsonmota@moobi.com.br
	 * @since 1.0.0
	 */
	public function getValor(): string {
		return $this->sValor;
	}

	/**
	 * Retorna a coluna referente a celula
	 *
	 * @return Coluna
	 *
	 * @author Anailson Mota anailsonmota@moobi.com.br
	 * @since 1.0.0
	 */
	public function getColuna(): Coluna {
		return $this->oColuna;
	}

	/**
	 * Retorna a linha referente a celula
	 *
	 * @return Linha
	 *
	 * @author Anailson Mota anailsonmota@deso-se.com.br
	 * @since 1.0.0
	 */
	public function getLinha(): Linha {
		return $this->oLinha;
	}
}
