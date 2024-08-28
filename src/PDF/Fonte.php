<?php

namespace ReportFPDF\PDF;

/**
 * @package ReportFPDF\PDF;
 *
 * Class Fonte
 *
 * @author Anailson Mota anailsonmota@deso-se.com.br
 * @version 1.0.0
 */
class Fonte
{
	/** @var string $sFont */
	private $sFont;

	/** @var string $sEstilo = "" */
	private $sEstilo;

	/** @var float $fTamanho = 10 */
	private $fTamanho; 

	/** @var string $sCor */
	private $sCor;

	/** @var string $sCorFundo */
	private $sCorFundo;

	/** @var Borda $oBorda */
	private $oBorda;

	/**
	 * Construtor
	 *
	 * @param string $sFont
	 * @param string $sEstilo = ""
	 * @param float $fTamanho = 10
	 *
	 * @author Anailson Mota anailsonmota@deso-se.com.br
	 * @since 1.0.0
	 */
	public function __construct(string $sFont, string $sEstilo = "", float $fTamanho = 10)
	{
		$this->sFont = $sFont;
		$this->sEstilo = $sEstilo;
		$this->fTamanho = $fTamanho;
		$this->sCor = CoresHexadecimal::PRETO;
	}

	/**
	 * Constrói uma instância da fonte SourceSans
	 *
	 * @param string $sEstilo = ""
	 * @param float $fTamanho = 10
	 * @return Fonte
	 *
	 * @author Anailson Mota anailsonmota@deso-se.com.br
	 * @since 1.0.0
	 */
	public static function SourceSans(string $sEstilo = "", float $fTamanho = 10): Fonte 
	{
		return new Fonte("sourcesans", $sEstilo, $fTamanho);
	}

	/**
	 * Retorna o nome da fonte
	 *
	 * @return string
	 *
	 * @author Anailson Mota anailsonmota@moobi.com.br
	 * @since 1.0.0
	 */
	public function getNome(): string {
		return $this->sFont;
	}

	/**
	 * Retorna o estilo da fonte
	 *
	 * @return string
	 *
	 * @author Anailson Mota anailsonmota@moobi.com.br
	 * @since 1.0.0
	 */
	public function getEstilo(): string {
		return $this->sEstilo;
	}

	/**
	 * Retorna o tamanho da fonte
	 *
	 * @return float
	 *
	 * @author Anailson Mota anailsonmota@moobi.com.br
	 * @since 1.0.0
	 */
	public function getTamanho(): float {
		return $this->fTamanho;
	}

	/**
	 * Retorna a cor da fonte no padrão RGB
	 *
	 * @return array
	 *
	 * @author Anailson Mota anailsonmota@moobi.com.br
	 * @since 1.0.0
	 */
	public function getCorRGB(): array  {
		return CoresHexadecimal::converteHexadecimalParaRGB($this->sCor);
	}

	/**
	 * Altera a cor da fonte no formato hexadecimal
	 *
	 * @param string $sCor
	 *
	 * @author Anailson Mota anailsonmota@moobi.com.br
	 * @since 1.0.0
	 */
	public function setCor(string $sCor): Fonte {
		$this->sCor = $sCor;
		return $this;
	}

	/**
	 * Retorna a cor de fundo da fonte em RGB
	 *
	 * @return array 
	 *
	 * @author Anailson Mota anailsonmota@moobi.com.br
	 * @since 1.0.0
	 */
	public function getCorFundoRGB(): array  {
		return CoresHexadecimal::converteHexadecimalParaRGB($this->sCorFundo);
	}

	/**
	 * Altera a cor de fundo no padrão Hexadecimal
	 *
	 * @param string $sCorFundo
	 *
	 * @author Anailson Mota anailsonmota@moobi.com.br
	 * @since 1.0.0
	 */
	public function setCorFundo(string $sCorFundo): Fonte {
		$this->sCorFundo = $sCorFundo;
		return $this;
	}

	/**
	 * Retorna as inforamções de borda da fonte
	 *
	 * @return Borda 
	 *
	 * @author Anailson Mota anailsonmota@moobi.com.br
	 * @since 1.0.0
	 */
	public function getBorda(): ?Borda  {
		return $this->oBorda;
	}

	/**
	 * Altera as inforamções de borda da fonte
	 *
	 * @param Borda $oBorda
	 *
	 * @author Anailson Mota anailsonmota@moobi.com.br
	 * @since 1.0.0
	 */
	public function setBorda(Borda $oBorda): Fonte {
		$this->oBorda = $oBorda;
		return $this;
	}
}
