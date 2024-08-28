<?php 

namespace ReportFPDF\Tabela;

use ReportFPDF\PDF\CalculadoraLayout;
use Exception;

/**
 * @package ReportFPDF\Tabela;
 *
 * Class ConfiguracaoTabela
 *
 * @author Anailson Mota anailsonmota@deso-se.com.br
 * @version 1.0.0
 */
class ConfiguracaoTabela
{
	/** @var ColunaList $loColunas */
	private $loColunas;

	/** @var array $aLarguras */
	private $aLarguras;

	/** @var ConfiguracaoLinha $oConfigCabecalho */
	private $oConfigCabecalho;

	/** @var bool $bQuebraLinha */
	private $bQuebraLinha;

	/**
	 * Construtor
	 *
	 * @param ColunaList $loColunas
	 * @param LinhaList $loLinhas
	 *
	 * @author Anailson Mota anailsonmota@deso-se.com.br
	 * @since 1.0.0
	 */
	public function __construct(ColunaList $loColunas, LinhaList $loLinhas) 
	{
		if ($loColunas->isEmpty()) {
			throw new Exception("A tabela não possui colunas");
		}

		$this->loColunas = $loColunas;
		$this->aLarguras = $this->calcularLarguraColunas();
		$this->bQuebraLinha = false;
	}

	/**
	 * Constrói uma configuração de tabela a partir de uma linha
	 *
	 * @param Linha $oLinha
	 * @return ConfiguracaoTabela
	 *
	 * @author Anailson Mota anailsonmota@deso-se.com.br
	 * @since 1.0.0
	 */
	public static function createFromLinha(Linha $oLinha, ConfiguracaoColuna $oConfigColuna = null): ConfiguracaoTabela {
		$loColunas = new ColunaList;

		$oLinhaIterator = $oLinha->getIterator();
		foreach ($oLinhaIterator as $sColuna => $sValor) {
			/** @var Celula $oCelula */
			$loColunas->add(new Coluna($sColuna, $oConfigColuna));
		}

		$loLinhas = new LinhaList;
		$loLinhas->add($oLinha);
		return new ConfiguracaoTabela($loColunas, $loLinhas);
	}

	/**
	 * Retorna a largura de uma coluna
	 *
	 * @param string $sColuna
	 * @return float
	 *
	 * @author Anailson Mota anailsonmota@deso-se.com.br
	 * @since 1.0.0
	 */
	public function getLargura(string $sColuna): float {
		if (!isset($this->aLarguras[$sColuna])) {
			throw new Exception("Coluna {$sColuna} não configurada");
		}
		return $this->aLarguras[$sColuna];
	}

	/**
	 * Altera a configuração de cabeçalho da tabela
	 *
	 * @param ConfiguracaoLinha $oCabecalho
	 *
	 * @author Anailson Mota anailsonmota@deso-se.com.br
	 * @since 1.0.0
	 */
	public function setConfiguracaoCabecalho(ConfiguracaoLinha $oCabecalho) {
		$this->oConfigCabecalho = $oCabecalho;
		return $this;
	}

	/**
	 * Retorna a largura das colunas em milimetros
	 *
	 * @param CalculadoraLayout $oCalculadora
	 * @return array
	 *
	 * @author Anailson Mota anailsonmota@deso-se.com.br
	 * @since 1.0.0
	 */
	public function getLargurasEmMilimetros(CalculadoraLayout $oCalculadora): array 
	{
		return $this->loColunas->reduzir(function(array $aLarguras, Coluna $oColuna) use ($oCalculadora) {
			$sTitulo = $oColuna->getTitulo();
			$aLarguras[$sTitulo] = $oCalculadora->getLarguraEmMilimetros($oColuna);
			return $aLarguras;
		}, []);
	}

	/**
	 * Retorna as colunas da configuração
	 *
	 * @return ColunaList
	 *
	 * @author Anailson Mota anailsonmota@deso-se.com.br
	 * @since 1.0.0
	 */
	public function getColunas(): ColunaList {
		return $this->loColunas;
	}

	/**
	 * Retorna a linha de cabeçalho da coluna
	 *
	 * @return Linha
	 *
	 * @author Anailson Mota anailsonmota@moobi.com.br
	 * @since 1.0.0
	 */
	public function getCabecalho(): Linha {
		return $this->loColunas->reduzir(function(Linha $oLinha, Coluna $oColuna) {
			$sTitulo = $oColuna->getTitulo();
			$sValor = $oColuna->getAlias();
			$oLinha->addCelula($sTitulo, $sValor);
			return $oLinha;
		}, new Linha(0, $this->oConfigCabecalho));
	}

	/**
	 * Retorna o alinhamento de uma determinada coluna
	 *
	 * @return string
	 *
	 * @author Anailson Mota anailsonmota@deso-se.com.br
	 * @since 1.0.0
	 */
	public function getAlinhamento(string $sColuna): string 
	{
		/** @var Coluna $oColuna */
		$oColuna = $this->loColunas->get($sColuna);
		return $oColuna->getConfiguracao()->getAlinhamento();
	}

	/**
	 * Calcula a largura das colunas
	 *
	 * @return array
	 *
	 * @author Anailson Mota anailsonmota@deso-se.com.br
	 * @since 1.0.0
	 */
	private function calcularLarguraColunas(): array 
	{
		$fTotal = $this->loColunas->getLarguraTotal();
		if ($fTotal > 100) {
			throw new Exception(
				"A soma percentual da largura das colunas ({$fTotal}%) é superior a 100%."
			);
		}

		$aColunasSemPercentual = [];
		$aLarguras = [];

		/** @var Coluna $oColuna */
		foreach ($this->loColunas as $sColuna => $oColuna) {
			$fPercenutal = $oColuna->getConfiguracao()->getLargura();
			if ($fPercenutal <= 0) {
				$aColunasSemPercentual[] = $sColuna;
			}
			$aLarguras[$sColuna] = $fPercenutal;
		}

		$fPercentualDefinido = $this->loColunas->getLarguraTotal();
		$fPercentualRestante = 100 - $fPercentualDefinido;
		$iColunasSemPercentual = count($aColunasSemPercentual);

		$fLarguraColuna = $fPercentualRestante / $iColunasSemPercentual;
		$fLarguraColuna = floor($fLarguraColuna * 100) / 100;
		foreach ($aColunasSemPercentual as $sColuna) {
			$this->loColunas->get($sColuna)->setLargura($fLarguraColuna);
			$aLarguras[$sColuna] = $fLarguraColuna;
		}

		return $aLarguras;
	}

	/**
	 * Retorna uma coluna pelo seu título
	 *
	 * @param string $sColnuna
	 * @return Coluna
	 *
	 * @author Anailson Mota anailsonmota@deso-se.com.br
	 * @since 1.0.0
	 */
	public function getColuna(string $sColnuna): Coluna 
	{
		return $this->loColunas->get($sColnuna);
	}

	/**
	 * Informa se deve aplicar quebra de linha após impressão da tabela
	 *
	 * @param bool $bQuebraLinha
	 * @return ConfiguracaoTabela
	 *
	 * @author Anailson Mota anailsonmota@moobi.com.br
	 * @since 1.0.0
	 */
	public function setQuebraLinhaAposImpressao(bool $bQuebraLinha): ConfiguracaoTabela {
		$this->bQuebraLinha = $bQuebraLinha;
		return $this;
	}
	
	/**
	 * Verifica se deve quebrar linha após impressão da tabela
	 *
	 * @param tipo $bQuebraLinha
	 *
	 * @author Anailson Mota anailsonmota@moobi.com.br
	 * @since 1.0.0
	 */
	public function hasQuebraLinhaAposImpressao(): bool {
		return $this->bQuebraLinha;
	}
}
