<?php 

namespace ReportFPDF\PDF;

/**
 * @package ReportFPDF\PDF;
 *
 * Class Borda
 *
 * @author Anailson Mota anailsonmota@deso-se.com.br
 * @version 1.0.0
 */
class Borda
{
	/** @var string $sCorHexadecimal */
	private $sCorHexadecimal; 

	/** @var string $sEstilo = "BT" */
	private $sEstilo;

	/**
	 * Construtor
	 *
	 * @param string $sCorHexadecimal
	 * @param string $sEstilo = "BT"
	 *
	 * @author Anailson Mota anailsonmota@deso-se.com.br
	 * @since 1.0.0
	 */
	public function __construct(string $sCorHexadecimal, string $sEstilo = "")
	{
		$this->sCorHexadecimal = $sCorHexadecimal;
		$this->sEstilo = $sEstilo;
	}

	/**
	 * Verifica se possui a borda superior
	 *
	 * @return bool
	 *
	 * @author Anailson Mota anailsonmota@deso-se.com.br
	 * @since 1.0.0
	 */
	public function hasBordaSuperior(): bool 
	{
		return strpos($this->sEstilo, "T") !== false;
	}

	/**
	 * Verifica se possui borda inferior
	 *
	 * @return bool
	 *
	 * @author Anailson Mota anailsonmota@deso-se.com.br
	 * @since 1.0.0
	 */
	public function hasBordaInferior(): bool 
	{
		return strpos($this->sEstilo, "B") !== false;
	}

	/**
	 * Retorna a cor no padrão RGB
	 *
	 * @return array
	 *
	 * @author Anailson Mota anailsonmota@deso-se.com.br
	 * @since 1.0.0
	 */
	public function getCorRGB(): array 
	{
		return CoresHexadecimal::converteHexadecimalParaRGB($this->sCorHexadecimal);
	}
}
