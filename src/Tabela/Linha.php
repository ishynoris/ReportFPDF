<?php 


namespace ReportFPDF\Tabela;

use ReportFPDF\ArrayIterator;
use Iterator;

/**
 * @package ReportFPDF\Tabela;
 *
 * Class Linha
 *
 * @author Anailson Mota anailsonmota@deso-se.com.br
 * @version 1.0.0
 */
class Linha
{
	/** @var int $iLinha */
	private $iLinha;

	/** @var array $aCelulas */
	private $aCelulas;

	/** @var array $aColunas */
	private $aColunas = [];

	/** @var ConfiguracaoLinha $oConfig */
	private $oConfig;

	/** @var bool $bCabecalho */
	private $bCabecalho = false;

	/**
	 * Construtor
	 *
	 * @param string $sTitulo
	 *
	 * @author Anailson Mota anailsonmota@deso-se.com.br
	 * @since 1.0.0
	 */
	public function __construct(int $iLinha, ConfiguracaoLinha $oConfig = null) {
		$this->iLinha = $iLinha;
		$this->oConfig = $oConfig;
	}

	/**
	 * Retorna o numero da linha
	 *
	 * @return int
	 *
	 * @author Anailson Mota anailsonmota@deso-se.com.br
	 * @since 1.0.0
	 */
	public function getLinha(): int {
		return $this->iLinha;
	}

	/**
	 * Retorna o nome da coluna
	 *
	 * @return string
	 *
	 * @author Anailson Mota anailsonmota@deso-se.com.br
	 * @since 1.0.0
	 */
	public function addCelula(string $sColuna, string $sValor) {
		$this->aColunas[$sColuna] = $sColuna;
		return $this->aCelulas[$sColuna] = trim($sValor);
	}

	/**
	 * Retorna a célula para uma determinada coluna
	 *
	 * @param Coluna $oColuna
	 * @return Celula
	 *
	 * @author Anailson Mota anailsonmota@deso-se.com.br
	 * @since 1.0.0
	 */
	public function getCelula(Coluna $oColuna): Celula {
		return new Celula($oColuna, $this);
	}

	/**
	 * 
	 *
	 * @param 
	 * @return 
	 * @throws 
	 *
	 * @author Anailson Mota anailsonmota@deso-se.com.br
	 * @since 1.0.0
	 */
	public function hasColuna(string $sColuna): bool 
	{
		if (empty($this->aColunas)) {
			return false;
		}
		return isset($this->aColunas[$sColuna]) || in_array($sColuna, $this->aColunas);
	}

	/**
	 * Retorna o valor da linha para uma determinada coluna
	 *
	 * @param string $sColuna
	 * @return string
	 *
	 * @author Anailson Mota anailsonmota@deso-se.com.br
	 * @since 1.0.0
	 */
	public function getValor(string $sColuna): string {
		return $this->aCelulas[$sColuna] ?? "";
	}

	/**
	 * Retorna o iterador de linhas
	 *
	 * @return ArrayIterator
	 *
	 * @author Anailson Mota anailsonmota@deso-se.com.br
	 * @since 1.0.0
	 */
	public function getIterator(): ArrayIterator {
		return new ArrayIterator($this->aCelulas);
	}

	/**
	 * Retorna a configuração da linha
	 *
	 * @return ConfiguracaoLinha
	 *
	 * @author Anailson Mota anailsonmota@deso-se.com.br
	 * @since 1.0.0
	 */
	public function getConfiguracao(): ConfiguracaoLinha
	{
		return $this->oConfig ?? new ConfiguracaoLinha;
	}

	/**
	 * Preenche a linha com as colunas já definidas
	 *
	 * @param ColunaList $loColunas
	 *
	 * @author Anailson Mota anailsonmota@deso-se.com.br
	 * @since 1.0.0
	 */
	public function preencherColunas(ColunaList $loColunas) 
	{
		foreach ($loColunas as $sColuna => $oColuna) {
			$this->addCelula($sColuna, "");
		}
	}

	/**
	 * Remove a célula de uma determinada coluna
	 *
	 * @param string $sColuna
	 *
	 * @author Anailson Mota anailsonmota@deso-se.com.br
	 * @since 1.0.0
	 */
	public function removerCelula(string $sColuna) {
		unset($this->aCelulas[$sColuna]);
	}

	/**
	 * Altera informação da linha ser um cabecalho
	 *
	 * @return Linha
	 *
	 * @author Anailson Mota anailsonmota@deso-se.com.br
	 * @since 1.0.0
	 */
	public function setCabecalho(bool $bCabecalho): Linha {
		$this->bCabecalho = $bCabecalho;
		return $this;
	}

	/**
	 * Verifica se a linha representa um cabecalho da tabela
	 *
	 * @return bool
	 *
	 * @author Anailson Mota anailsonmota@deso-se.com.br
	 * @since 1.0.0
	 */
	public function isCabecalho(): bool {
		return $this->bCabecalho;
	}

	/**
	 * Retorna uma linha completa, evitando colunas sem valor
	 *
	 * @param ColunaList $loColunas
	 * @return Linha
	 *
	 * @author Anailson Mota anailsonmota@deso-se.com.br
	 * @since 1.0.0
	 */
	public function getLinhaCompleta(ColunaList $loColunas): Linha 
	{
		$oLinhaCompleta = new Linha($this->iLinha, $this->oConfig);
		$oLinhaCompleta->bCabecalho = $this->bCabecalho;

		/** @var Coluna $oColuna */
		foreach ($loColunas as $oColuna) {
			$sColuna = $oColuna->getTitulo();
			$mValor =  $this->getValor($sColuna);
			$oLinhaCompleta->addCelula($sColuna, $mValor);
		}
		return $oLinhaCompleta;
	}
}
