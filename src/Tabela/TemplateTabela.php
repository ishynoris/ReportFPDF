<?php 

namespace ReportFPDF\Tabela;

use ReportFPDF\PDF\Borda;
use ReportFPDF\PDF\CoresHexadecimal;
use ReportFPDF\PDF\Fonte;

/**
 * @package ReportFPDF\Tabela;
 *
 * Class TemplateTabela
 *
 * @author Anailson Mota anailsonmota@deso-se.com.br
 * @version 1.0.0
 */
class TemplateTabela
{
	/** @var ConfiguracaoLinha $oConfigCorpo */
	private $oConfigCorpo;

	/** @var ConfiguracaoLinha $oConfigCabecalho */
	private $oConfigCabecalho;

	/** @var ConfiguracaoLinha $oConfigLinhaAgrupamento */
	private $oConfigLinhaAgrupamento;

	/** @var ConfiguracaoColuna $oConfigColunaAgrupamento */
	private $oConfigColunaAgrupamento;

	/** @var ConfiguracaoLinha $oConfigLinhaAgrupamentoSec */
	private $oConfigLinhaAgrupamentoSec;

	/** @var ConfiguracaoColuna $oConfigColunaAgrupamentoSec */
	private $oConfigColunaAgrupamentoSec;
	
	/** @var callable $fnPreProcessarLinha */
	private $fnPreProcessarLinha;

	/**
	 * Retorna um template para tabelas simples
	 *
	 * @return TemplateTabela
	 *
	 * @author Anailson Mota anailsonmota@moobi.com.br
	 * @since 1.0.0
	 */
	public static function Simples(): TemplateTabela {
		$oTemplate = new TemplateTabela;

		$oFonte = Fonte::SourceSans("B", 8)
			->setBorda(new Borda(CoresHexadecimal::CINZA_CLARO, "B"))
			->setCorFundo(CoresHexadecimal::VERDE_ACINZENTADO);
		$oTemplate->setConfigCabecalho(new ConfiguracaoLinha(5, $oFonte))
			->setConfigAgrupamento(
				new ConfiguracaoLinha(8, Fonte::SourceSans("", 10)), 
				new ConfiguracaoColuna(0, "L")
			);

		return $oTemplate;
	}

	/**
	 * Retorna um template com tabelas agrupadas
	 *
	 * @return TemplateTabela
	 *
	 * @author Anailson Mota anailsonmota@moobi.com.br
	 * @since 1.0.0
	 */
	public static function ComAgrupamento(): TemplateTabela {
		$oTemplate = self::Simples();

		$oFonte = Fonte::SourceSans("", 12);
		$oTemplate->setConfigAgrupamento(new ConfiguracaoLinha(5, $oFonte), new ConfiguracaoColuna(0, "L"));

		return $oTemplate;
	}

	/**
	 * Retorna um tempalte com múltiplos agrupamentos de tabela
	 *
	 * @return TemplateTabela
	 *
	 * @author Anailson Mota anailsonmota@moobi.com.br
	 * @since 1.0.0
	 */
	public static function MultiploAgrupamento(): TemplateTabela {
		$oTemplate = self::Simples();

		$oFonte = Fonte::SourceSans("B", 9)
			->setCorFundo(CoresHexadecimal::VERDE_ACINZENTADO)
			->setBorda(new Borda(CoresHexadecimal::CINZA_CLARO, "B"));
		$oTemplate->setConfigAgrupamento(new ConfiguracaoLinha(6, $oFonte), new ConfiguracaoColuna(0, "C"));

		$oFonte = Fonte::SourceSans("", 12);
		$oTemplate->setConfigAgrupamentoSec(new ConfiguracaoLinha(6, $oFonte), new ConfiguracaoColuna(0, "L"));

		return $oTemplate;
	}

	/**
	 * Mescla as configurações de template da tabela
	 *
	 * @param TemplateTabela $oTemplate
	 * @return TemplateTabela
	 *
	 * @author Anailson Mota anailsonmota@deso-se.com.br
	 * @since 1.0.0
	 */
	public function mesclar(TemplateTabela $oTemplate): TemplateTabela
	{
		$this->oConfigCorpo = $oTemplate->oConfigCorpo ?? $this->oConfigCorpo;
		$this->oConfigCabecalho = $oTemplate->oConfigCabecalho ?? $this->oConfigCabecalho;
		$this->oConfigLinhaAgrupamento = $oTemplate->oConfigLinhaAgrupamento ?? $this->oConfigLinhaAgrupamento;
		$this->oConfigColunaAgrupamento = $oTemplate->oConfigColunaAgrupamento ?? $this->oConfigColunaAgrupamento;
		$this->oConfigLinhaAgrupamentoSec = $oTemplate->oConfigLinhaAgrupamentoSec ?? $this->oConfigLinhaAgrupamentoSec;
		$this->oConfigColunaAgrupamentoSec = $oTemplate->oConfigColunaAgrupamentoSec ?? $this->oConfigColunaAgrupamentoSec;
		$this->fnPreProcessarLinha = $oTemplate->fnPreProcessarLinha ?? $this->fnPreProcessarLinha;
		return $this;
	}

	/**
	 * Retorna as configurações de linha de agrupamento
	 *
	 * @return ConfiguracaoLinha 
	 *
	 * @author Anailson Mota anailsonmota@deso-se.com.br
	 * @since 1.0.0
	 */
	public function getConfigLinhaAgrupamento(): ConfiguracaoLinha 
	{
		return $this->oConfigLinhaAgrupamento ?? new ConfiguracaoLinha;
	}

	/**
	 * Retorna as configurações de coluna de agrupamento
	 *
	 * @return ConfiguracaoColuna 
	 *
	 * @author Anailson Mota anailsonmota@deso-se.com.br
	 * @since 1.0.0
	 */
	public function getConfigColunaAgrupamento(): ConfiguracaoColuna 
	{
		return $this->oConfigColunaAgrupamento ?? new ConfiguracaoColuna;
	}

	/**
	 * Altera as configurações de linha de agrupamento
	 *
	 * @param ConfiguracaoLinha 
	 * @param null|ConfiguracaoColuna $oConfigColuna
	 * @return TemplateTabela
	 *
	 * @author Anailson Mota anailsonmota@deso-se.com.br
	 * @since 1.0.0
	 */
	public function setConfigAgrupamento(
		ConfiguracaoLinha $oConfigLinha
		, ConfiguracaoColuna $oConfigColuna = null
	): TemplateTabela 
	{
		$this->oConfigLinhaAgrupamento = $oConfigLinha;
		$this->oConfigColunaAgrupamento = $oConfigColuna;
		return $this;
	}

	/**
	 * Retorna as configurações de linha de agrupamento
	 *
	 * @return ConfiguracaoLinha 
	 *
	 * @author Anailson Mota anailsonmota@deso-se.com.br
	 * @since 1.0.0
	 */
	public function getConfigLinhaAgrupamentoSec(): ConfiguracaoLinha 
	{
		return $this->oConfigLinhaAgrupamentoSec ?? new ConfiguracaoLinha;
	}

	/**
	 * Retorna as configurações de coluna de agrupamento
	 *
	 * @return ConfiguracaoColuna 
	 *
	 * @author Anailson Mota anailsonmota@deso-se.com.br
	 * @since 1.0.0
	 */
	public function getConfigColunaAgrupamentoSec(): ConfiguracaoColuna 
	{
		return $this->oConfigColunaAgrupamentoSec ?? new ConfiguracaoColuna;
	}

	/**
	 * Altera as configurações de linha de agrupamento
	 *
	 * @param ConfiguracaoLinha 
	 * @param null|ConfiguracaoColuna $oConfigColuna
	 * @return TemplateTabela
	 *
	 * @author Anailson Mota anailsonmota@deso-se.com.br
	 * @since 1.0.0
	 */
	public function setConfigAgrupamentoSec(
		ConfiguracaoLinha $oConfigLinha
		, ConfiguracaoColuna $oConfigColuna = null
	): TemplateTabela 
	{
		$this->oConfigLinhaAgrupamentoSec = $oConfigLinha;
		$this->oConfigColunaAgrupamentoSec = $oConfigColuna;
		return $this;
	}

	/**
	 * Retorna as configurações do corpo da tabela
	 *
	 * @return ConfiguracaoLinha 
	 *
	 * @author Anailson Mota anailsonmota@deso-se.com.br
	 * @since 1.0.0
	 */
	public function getConfigCorpo(): ConfiguracaoLinha 
	{
		return $this->oConfigCorpo ?? new ConfiguracaoLinha;
	}

	/**
	 * Altera as configurações do corpo da tabela
	 *
	 * @param ConfiguracaoLinha $oConfigCorpo
	 * @return TemplateTabela
	 *
	 * @author Anailson Mota anailsonmota@deso-se.com.br
	 * @since 1.0.0
	 */
	public function setConfigCorpo(ConfiguracaoLinha $oConfigCorpo): TemplateTabela 
	{
		$this->oConfigCorpo = $oConfigCorpo;
		return $this;
	}

	/**
	 * Retorna as configurações do cabecalho da tabela
	 *
	 * @return ConfiguracaoLinha 
	 *
	 * @author Anailson Mota anailsonmota@deso-se.com.br
	 * @since 1.0.0
	 */
	public function getConfigCabecalho(): ConfiguracaoLinha 
	{
		return $this->oConfigCabecalho ?? new ConfiguracaoLinha;
	}

	/**
	 * Altera as configurações do cabecalho da tabela
	 *
	 * @param ConfiguracaoLinha $oConfigCabecalho
	 * @return TemplateTabela
	 *
	 * @author Anailson Mota anailsonmota@deso-se.com.br
	 * @since 1.0.0
	 */
	public function setConfigCabecalho(ConfiguracaoLinha $oConfigCabecalho): TemplateTabela 
	{
		$this->oConfigCabecalho = $oConfigCabecalho;
		return $this;
	}

	/**
	 * Altera função de pre processamento da linha 
	 *
	 * @param callable $fnFunca
	 * @return Tabela
	 *
	 * @author Anailson Mota anailsonmota@moobi.com.br
	 * @since 1.0.0
	 */
	public function setPreProcessarLinha(callable $fnFuncao): TemplateTabela {
		$this->fnPreProcessarLinha = $fnFuncao;
		return $this;
	}

	/**
	 * Pré-processa a linha antes de montar a tabela
	 *
	 * @param array $aLinha
	 * @return array
	 *
	 * @author Anailson Mota anailsonmota@moobi.com.br
	 * @since 1.0.0
	 */
	public function preProcessarLinha(array $aLinha): array {
		$fnFuncao = $this->fnPreProcessarLinha;
		if (is_callable($fnFuncao)) {
			$aLinha = $fnFuncao($aLinha);
		}
		return $aLinha;
	}
}
