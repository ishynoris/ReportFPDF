<?php 


namespace ReportFPDF\Tabela;

use ReportFPDF\PDF\Fonte;

/**
 * @package ReportFPDF\Tabela;
 *
 * Class ConfiguracaoLinha
 *
 * @author Anailson Mota anailsonmota@deso-se.com.br
 * @version 1.0.0
 */
class ConfiguracaoLinha
{
	/** @var float $fAltura = 5 */
	private $fAltura;

	/** @var Fonte $oFonte = null */
	private $oFonte;

	/**
	 * Construtor
	 *
	 * @param float $fAltura = 5
	 * @param Fonte $oFonte = null
	 *
	 * @author Anailson Mota anailsonmota@deso-se.com.br
	 * @since 1.0.0
	 */
	public function __construct(float $fAltura = 5, Fonte $oFonte = null) 
	{
		$this->fAltura = $fAltura;
		$this->oFonte = $oFonte ?? new Fonte("Arial");
	}

	/**
	 * Retorna a altura da linha
	 *
	 * @return float
	 *
	 * @author Anailson Mota anailsonmota@deso-se.com.br
	 * @since 1.0.0
	 */
	public function getAltura(): float 
	{
		return $this->fAltura;
	}

	/**
	 * Retorna a fonte da linha
	 *
	 * @return Fonte
	 *
	 * @author Anailson Mota anailsonmota@moobi.com.br
	 * @since 1.0.0
	 */
	public function getFonte(): Fonte {
		return $this->oFonte;
	}
}
