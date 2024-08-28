<?php 

namespace ReportFPDF\Tabela;

/**
 * @package ReportFPDF\Tabela;
 *
 * Class ConfiguracaoColuna
 *
 * @author Anailson Mota anailsonmota@deso-se.com.br
 * @version 1.0.0
 */
class ConfiguracaoColuna
{
	/** @var float $fLargura */
	private $fLargura;

	/** @var string $sAlinhamento */
	private $sAlinhamento;

	/**
	 * Construtor
	 *
	 * @param float $fLargura = 0
	 * @param string $sAlinhamento = "C"
	 *
	 * @author Anailson Mota anailsonmota@deso-se.com.br
	 * @since 1.0.0
	 */
	public function __construct(float $fLargura = 0, string $sAlinhamento = "C")
	{
		$this->fLargura = $fLargura;
		$this->sAlinhamento = $sAlinhamento;
	}

	/**
	 * Retorna largura da coluna
	 *
	 * @return float
	 *
	 * @author Anailson Mota anailsonmota@deso-se.com.br
	 * @since 1.0.0
	 */
	public function getLargura(): float {
		return $this->fLargura;
	}

	/**
	 * Retorna largura da coluna
	 *
	 * @return float
	 *
	 * @author Anailson Mota anailsonmota@deso-se.com.br
	 * @since 1.0.0
	 */
	public function setLargura(float $fLargura): ConfiguracaoColuna 
	{
		$this->fLargura = $fLargura;
		return $this;
	}

	/**
	 * Retorna alinhamento da coluna
	 *
	 * @return string
	 *
	 * @author Anailson Mota anailsonmota@deso-se.com.br
	 * @since 1.0.0
	 */
	public function getAlinhamento(): string {
		return $this->sAlinhamento;
	}
}
