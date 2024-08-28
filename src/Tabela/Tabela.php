<?php 


namespace ReportFPDF\Tabela;

use ReportFPDF\PDF\Borda;
use ReportFPDF\PDF\CoresHexadecimal;
use ReportFPDF\PDF\Fonte;

/**
 * @package ReportFPDF\Tabela;
 *
 * Class Tabela
 *
 * @author Anailson Mota anailsonmota@deso-se.com.br
 * @version 1.0.0
 */
class Tabela
{
	/** @var string $sTitulo */
	private $sTitulo;

	/** @var bool $bImprimirTitulo */
	private $bImprimirTitulo;

	/** @var bool $bQuebraLinha */
	private $bQuebraLinha;

	/** @var ColunaList $loColunas */
	private $loColunas;

	/** @var LinhaList $loLinhas */
	private $loLinhas;
	
	/** @var TemplateTabela $oTemplate */
	private $oTemplate;

	/** @var ConfiguracaoTabela $oConfig */
	private $oConfig;

	/**
	 * Construtor
	 *
	 * @param string $sTitulo
	 *
	 * @author Anailson Mota anailsonmota@deso-se.com.br
	 * @since 1.0.0
	 */
	public function __construct(string $sTitulo = null, bool $bImprimirTitulo = true, bool $bQuebraLinha = true)
	{
		$this->sTitulo = $sTitulo;
		$this->loColunas = new ColunaList;
		$this->loLinhas = new LinhaList;
		$this->bImprimirTitulo = $bImprimirTitulo && !empty($sTitulo);
		$this->bQuebraLinha = $bQuebraLinha;
		$this->oTemplate = new TemplateTabela;

		$oFonteCorpo = Fonte::SourceSans("", 8)
			->setBorda(new Borda(CoresHexadecimal::CINZA_CLARO, "B"));
		$this->oTemplate->setConfigCorpo(new ConfiguracaoLinha(5, $oFonteCorpo));

		$oFonteCabecalho = Fonte::SourceSans("B", 8)
			->setBorda(new Borda(CoresHexadecimal::CINZA_CLARO, "BT"))
			->setCorFundo(CoresHexadecimal::VERDE_ACINZENTADO);
		$this->oTemplate->setConfigCabecalho(new ConfiguracaoLinha(5, $oFonteCabecalho));


		$oFonteAgrupamento = Fonte::SourceSans("B", 9)
			->setBorda(new Borda(CoresHexadecimal::CINZA_CLARO));
		$this->oTemplate->setConfigAgrupamento(new ConfiguracaoLinha(5, $oFonteAgrupamento), new ConfiguracaoColuna(0, "L"));
	}

	/**
	 * Retorna o título da tabela
	 *
	 * @return string
	 *
	 * @author Anailson Mota anailsonmota@deso-se.com.br
	 * @since 1.0.0
	 */
	public function getTitulo(): string {
		return $this->sTitulo ?? "";
	}

	/**
	 * Informa se o título da tabela deve ser impresso
	 *
	 * @return bool
	 *
	 * @author Anailson Mota anailsonmota@deso-se.com.br
	 * @since 1.0.0
	 */
	public function isImprimirTitulo(): bool 
	{
		return $this->bImprimirTitulo;
	}

	/**
	 * Altera as colunas da tabela
	 *
	 * @param ColunaList $loColunas
	 * @return Tabela
	 *
	 * @author Anailson Mota anailsonmota@deso-se.com.br
	 * @since 1.0.0
	 */
	public function adicionarColuna(Coluna $oColuna): Tabela
	{
		$this->loColunas->add($oColuna);
		return $this;
	}

	/**
	 * Altera as colunas da tabela
	 *
	 * @param ColunaList $loColunas
	 * @return Tabela
	 *
	 * @author Anailson Mota anailsonmota@deso-se.com.br
	 * @since 1.0.0
	 */
	public function setColunas(ColunaList $loColunas): Tabela
	{
		$this->loColunas = $loColunas;
		return $this;
	}

	/**
	 * Retorna o template da tabela
	 *
	 * @return TemplateTabela
	 *
	 * @author Anailson Mota anailsonmota@deso-se.com.br
	 * @since 1.0.0
	 */
	public function getTemplate(): TemplateTabela 
	{
		return $this->oTemplate;
	}

	/**
	 * Altera o templaete da tabela
	 *
	 * @param ConfiguracaoLinha $oConfig
	 * @return Tabela
	 *
	 * @author Anailson Mota anailsonmota@deso-se.com.br
	 * @since 1.0.0
	 */
	public function setTemplate(TemplateTabela $oTemplate): Tabela 
	{
		$this->oTemplate->mesclar($oTemplate);
		return $this;
	}

	/**
	 * Constrói uma tabela com as informações
	 *
	 * @param string $sTitulo
	 * @param array $aaMatriz
	 * @param array $aAlias = []
	 * @return Tabela
	 *
	 * @author Anailson Mota anailsonmota@deso-se.com.br
	 * @since 1.0.0
	 */
	public function popular(array $aaMatriz, array $aAlias = []): Tabela
	{
		$aColunas = array_keys(current($aaMatriz)) ?? [];
		$this->loColunas = $this->addArrayColunas($aColunas, $aAlias);

		$bHasAlias = !empty($aAlias);
		foreach ($aaMatriz as $iLinha => $aLinha) {
			$aLinha = $this->oTemplate->preProcessarLinha($aLinha);

			foreach ($aLinha as $sColuna => $mValor) {
				if ($bHasAlias && !isset($aAlias[$sColuna])) {
					continue;
				}

				$sColuna = $aAlias[$sColuna] ?? $sColuna;
				$this->addCelula($iLinha, $sColuna, $mValor ?? "");
			}
		}
		return $this;
	}

	/**
	 * Verifica se a tabela ja possui uma coluna pelo nome informado
	 *
	 * @param string $sTitulo
	 *
	 * @author Anailson Mota anailsonmota@deso-se.com.br
	 * @since 1.0.0
	 */
	protected function hasColuna(string $sTitulo) {
		return $this->loColunas->has($sTitulo);
	}

	/**
	 * Verifica se a tabela possui a linha informada
	 *
	 * @return bool
	 *
	 * @author Anailson Mota anailsonmota@deso-se.com.br
	 * @since 1.0.0
	 */
	protected function hasLinha(int $iLinha): bool {
		return $this->loLinhas->has($iLinha);
	}

	/**
	 * Adiciona uma nova celula na tabela
	 *
	 * @param int $iLinha
	 * @param string $sColuna
	 * @param string $sValor
	 * @return Tabela
	 *
	 * @author Anailson Mota anailsonmota@deso-se.com.br
	 * @since 1.0.0
	 */
	public function addCelula(int $iLinha, string $sColuna, string $sValor): Tabela {
		if ($this->hasColuna($sColuna)) {
			$oColuna = $this->loColunas->get($sColuna);
		} else {
			$oColuna = $this->addColuna($sColuna);
		}

		$sValor = $oColuna->formatar($sValor);
		if (!$this->hasLinha($iLinha)) {
			$oLinha = new Linha($iLinha, $this->oTemplate->getConfigCorpo());
			$oLinha->preencherColunas($this->loColunas);
			$this->loLinhas->add($oLinha);
		}

		$this->loLinhas->get($iLinha)->addCelula($sColuna, $sValor);
		return $this;
	}

	/**
	 * Retorna a configuração da tabela
	 *
	 * @return ConfiguracaoTabela
	 *
	 * @author Anailson Mota anailsonmota@deso-se.com.br
	 * @since 1.0.0
	 */
	public function getConfiguracao(bool $bReset = false): ConfiguracaoTabela {
		if (empty($this->oConfig) || $bReset) {
			$this->oConfig = new ConfiguracaoTabela($this->loColunas, $this->loLinhas);
			$this->oConfig->setConfiguracaoCabecalho($this->oTemplate->getConfigCabecalho());
			$this->oConfig->setQuebraLinhaAposImpressao($this->bQuebraLinha);
		}
		return $this->oConfig;
	}

	/**
	 * Retorna uma instância capaz de iterar a tabela
	 *
	 * @return TabelaIterator
	 *
	 * @author Anailson Mota anailsonmota@deso-se.com.br
	 * @since 1.0.0
	 */
	public function getIterator(): TabelaIterator {
		return new TabelaIterator($this->loColunas, $this->loLinhas);
	}

	/**
	 * Agrupa uma tabela pelos valores de uma determinada coluna informada no agrupamento
	 *
	 * @param string $sColunaAgrupamento
	 * @param bool $bRemoverColuna = false
	 * @return TabelaList
	 *
	 * @author Anailson Mota anailsonmota@deso-se.com.br
	 * @since 1.0.0
	 */
	public function agrupar(string $sColunaAgrupamento, bool $bRemoverColuna = false): TabelaList 
	{
		$loTabelasAgrupadas = new TabelaList;
		$aLinhas = $this->loLinhas->agruparPorValorColuna($sColunaAgrupamento);

		foreach ($aLinhas as $sValor => $loLinhas) {
			$oTabela = new Tabela($sValor, $this->bImprimirTitulo);
			$oTabela->setTemplate($this->oTemplate);
			$oTabela->loLinhas = clone $loLinhas;
			$oTabela->loColunas = clone $this->loColunas;

			if ($bRemoverColuna) {
				$oTabela->loColunas->remove($sColunaAgrupamento);
				$oTabela->loLinhas->removerColuna($sColunaAgrupamento);
			}
			$loTabelasAgrupadas->add($oTabela);
		}
		return $loTabelasAgrupadas;
	}

	/**
	 * Adiciona uma nova 
	 *
	 * @param string $sColuna
	 * @return Coluna
	 *
	 * @author Anailson Mota anailsonmota@deso-se.com.br
	 * @since 1.0.0
	 */
	private function addColuna(string $sColuna): Coluna 
	{
		$oColuna = new Coluna($sColuna);
		$this->loColunas->add($oColuna);
		return $oColuna;
	}

	/**
	 * Adiciona uma lista de colunas de acordo com o nome
	 *
	 * @param array $aColunas
	 * @return ColunaList
	 *
	 * @author Anailson Mota anailsonmota@deso-se.com.br
	 * @since 1.0.0
	 */
	private function addArrayColunas(array $aColunas, array $aAlias = []): ColunaList 
	{
		$bHasAlias = !empty($aAlias);
		foreach ($aColunas as $sColuna) {
			if ($bHasAlias && !isset($aAlias[$sColuna])) {
				continue;
			}

			$sTitulo = $aAlias[$sColuna] ?? $sColuna;
			if ($this->hasColuna($sTitulo)) {
				continue;
			}

			$this->addColuna($sTitulo);
		}

		return $this->loColunas->getOrdenadas();
	}

	/**
	 * Retorna o total de linhas da tabela
	 *
	 * @return int
	 *
	 * @author Anailson Mota anailsonmota@deso-se.com.br
	 * @since 1.0.0
	 */
	public function getTotalLinhas(): int 
	{
		return $this->loLinhas->count();
	}
}
