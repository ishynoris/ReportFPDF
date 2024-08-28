<?php 

namespace ReportFPDF\PDF;

use ReportFPDF\CellFit;
use ReportFPDF\Filtro;
use ReportFPDF\RowTrait;
use ReportFPDF\PDF\Render\RenderFiltroPDF;
use ReportFPDF\PDF\Render\RenderLinhaPDF;
use ReportFPDF\Tabela\Coluna;
use ReportFPDF\Tabela\ColunaList;
use ReportFPDF\Tabela\ConfiguracaoTabela;
use ReportFPDF\Tabela\Linha;
use ReportFPDF\Tabela\LinhaList;
use setasign\Fpdi\Fpdi;

/**
 * @package ReportFPDF\PDF
 *
 * Class LayoutPDF
 *
 * @author Anailson Mota anailsonmota@moobi.com.br
 * 
 * @version 1.0.0
 */ 
final class LayoutPDF extends Fpdi
{
	use CellFit;
	use RowTrait;


	/** @var string $sMarcaDaguaRetrato */
	private $sMarcaDaguaRetrato;

	/** @var string $sTitulo */
	private $sTitulo;

	/** @var bool $bImprimirTotalPaginas */
	private $bImprimirTotalPaginas = true;

	/** @var string $sNomeSistema */
	private $sNomeSistema;

	private $CacheConfig = [];

	/** @var CalculadoraLayout $oCalculadora */
	private $oCalculadora;

	/**
	 * Preenche nome do sistema no rodapé da página
	 *
	 * @param string $sNome
	 * @param string $sSigla = null
	 * @param string $sCodigo = null
	 *
	 * @author Anailson Mota anailsonmota@deso-se.com.br
	 * @since 1.0.0
	 */
	public function setNomeSistema(string $sNome, string $sSigla = null, string $sCodigo = null): LayoutPDF 
	{
		$this->sNomeSistema = empty($sCodigo) ? "" : "$sCodigo/";
		$this->sNomeSistema .= empty($sSigla) ? "" : "$sSigla - ";
		$this->sNomeSistema .= $sNome;
		return $this;
	}

	/**
	 * Construtor
	 *
	 * @param $orientation='P'
	 * @param $unit='mm'
	 * @param $size='A4'
	 *
	 * @author Anailson Mota anailsonmota@deso-se.com.br
	 * @since 1.0.0
	 */
	public function __construct($orientation='P', $unit='mm', $size='A4')
	{
		parent::__construct($orientation, $unit, $size);
		$this->AddFont("sourcesans", "B", "sourcesans_b.php");
		$this->AddFont("sourcesans", "", "sourcesans.php");
	}

	/**
	 * Altera opção de imprimir o total de páginas no rodapé
	 *
	 * @param bool $bImprimir
	 * @return LayoutPDF 
	 *
	 * @author Anailson Mota anailsonmota@deso-se.com.br
	 * @since 1.0.0
	 */
	public function setImprimirTotalPaginas(bool $bImprimir): LayoutPDF 
	{
		$this->bImprimirTotalPaginas = $bImprimir;
		return $this;
	}

	/**
	 * Altera o título do layout
	 *
	 * @param string $sTitulo
	 * @return LayoutPDF
	 *
	 * @author Anailson Mota anailsonmota@deso-se.com.br
	 * @since 1.0.0
	 */
	public function setTitulo(string $sTitulo) {
		parent::SetTitle($sTitulo);
		$this->sTitulo = $sTitulo;
		return $this;
	}

	/**
	 * Altera a imagem de marca dágua do layout
	 *
	 * @param string $sMarcaDaguaRetrato
	 * @return LayoutPDF
	 *
	 * @author Anailson Mota anailsonmota@deso-se.com.br
	 * @since 1.0.0
	 */
	public function setImagemMarcaDaguaRetrato(string $sMarcaDaguaRetrato) {
		$this->sMarcaDaguaRetrato = $sMarcaDaguaRetrato;
		return $this;
	}

	/**
	 * Renderiza o cabecalho
	 *
	 * @author Anailson Mota anailsonmota@deso-se.com.br
	 * @since 1.0.0
	 */
	public function Header()
	{
		if (!empty($this->sMarcaDaguaRetrato) && file_exists($this->sMarcaDaguaRetrato)) {
			$this->Image($this->sMarcaDaguaRetrato, 0, 0, $this->w, $this->h);
		}

		if (!empty($this->sTitulo)) {
			$fY = $this->isPaisagem() ? 20 : 15;

			$this->SetY($fY);
			$this->SetFont("sourcesans", "B", 14);
			$this->SetTextColor(66, 92, 179);
			$this->Cell(0, 0, $this->sTitulo);

			$fLargura = $this->GetStringWidth($this->sTitulo) + 2;
			$this->SetFillColor(241, 204, 4);
			$this->Rect($this->lMargin, $fY + 3, $fLargura, 0.6, "F");

			$this->SetY($fY + 15);
			$this->SetTextColor(0, 0, 0);
			$this->SetFont("Arial", "", 10);
		}
	}

	/**
	 * Imprime o rodapé do relatório
	 *
	 * @author Anailson Mota anailsonmota@deso-se.com.br
	 * @since 1.0.0
	 */
	public function Footer()
	{
		$this->SetY($this->h - $this->bMargin, true);

		$this->cache(function(LayoutPDF $oLayout) {
			if ($oLayout->bImprimirTotalPaginas) {
				$sPagina = sprintf("Página: %d de ###", $oLayout->PageNo(), count($oLayout->pages));
				$oLayout->AliasNbPages("###");
				$oLayout->Bold(false);
				$oLayout->Cell(0, 7, $sPagina, 0, 0, "R");
				$oLayout->Ln(7);
			}
	
			if (!empty($oLayout->sNomeSistema)) {
				$oLayout->Bold();
				$oLayout->Cell(0, 4, "Companhia de Saneamento de Sergipe - DESO", 0, 0, "R");
				$oLayout->Ln(3);
	
				$oLayout->Bold(false);
				$oLayout->Cell(0, 4, $oLayout->sNomeSistema, 0, 0, "R");
			}
		});
	}

	/**
	 * Verifica se o layout está na orientação de paisagem
	 *
	 * @return bool
	 *
	 * @author Anailson Mota anailsonmota@deso-se.com.br
	 * @since 1.0.0
	 */
	public function isPaisagem(): bool {
		return $this->CurOrientation == "L";
	}

	/**
	 * Imprime uma linha no relatório
	 *
	 * @param Linha $oLinha
	 * @param null|ConfiguracaoTabela $oConfigTabela
	 *
	 * @author Anailson Mota anailsonmota@deso-se.com.br
	 * @since 1.0.0
	 */
	public function gerarLinha(Linha $oLinha, ConfiguracaoTabela $oConfigTabela) 
	{
		$this->cache(function(LayoutPDF $oLayout) use ($oLinha, $oConfigTabela) {
			$oRender = new RenderLinhaPDF($oLayout, $oConfigTabela);
			$oRender->imprimir($oLinha);
		});
	}

	/**
	 * Imprime os filtros do relatório
	 *
	 * @param Filtro $oFiltro
	 *
	 * @author Anailson Mota anailsonmota@deso-se.com.br
	 * @since 1.0.0
	 */
	public function gerarFiltro(Filtro $oFiltro) 
	{
		$this->cache(function(LayoutPDF $oLayout) use ($oFiltro) {
			$oRender = new RenderFiltroPDF($oLayout);
			$oRender->imprimir($oFiltro);
		});
	}

	/**
	 * Configura a fonte do layout
	 *
	 * @param Fonte $oFonte
	 *
	 * @author Anailson Mota anailsonmota@moobi.com.br
	 * @since 1.0.0
	 */
	public function configurarFonte(Fonte $oFonte) 
	{
		$this->SetFont($oFonte->getNome(), $oFonte->getEstilo(), $oFonte->getTamanho());
		
		$aCor = $oFonte->getCorRGB();
		if (!empty($aCor)) {
			$this->SetTextColor($aCor['R'], $aCor['G'], $aCor['B']);
		}
	}

	public function configurarCorBackground(string $sCorHexadecimal) 
	{
		$aCor = CoresHexadecimal::converteHexadecimalParaRGB($sCorHexadecimal);
		$this->SetFillColor($aCor['R'], $aCor['G'], $aCor['B']);
	}

	/**
	 * Retorna a largura disponível na folha de impressão
	 *
	 * @return float
	 *
	 * @author Anailson Mota anailsonmota@moobi.com.br
	 * @since 1.0.0
	 */
	public function getLarguraDisponivel(): float 
	{
		return $this->w - $this->lMargin - $this->rMargin;
	}

	/**
	 * Retorna a calculadora do layout
	 *
	 * @return CalculadoraLayout
	 *
	 * @author Anailson Mota anailsonmota@deso-se.com.br
	 * @since 1.0.0
	 */
	public function getCalculadora(): CalculadoraLayout 
	{
		$this->oCalculadora = $this->oCalculadora ?? new CalculadoraLayout($this);
		return $this->oCalculadora;
	}

	/**
	 * Retorna a margem esquerda da folha
	 *
	 * @return float
	 *
	 * @author Anailson Mota anailsonmota@deso-se.com.br
	 * @since 1.0.0
	 */
	public function getMargemEsquerda(): float 
	{
		return $this->lMargin;
	}

	public function Cell($w, $h = 0, $txt = '', $border = 0, $ln = 0, $align = '', $fill = false, $link = '')
	{
		$txt = $this->encode($txt);
		parent::Cell($w, $h, $txt, $border, $ln, $align, $fill, $link);
	}

	/**
	 * Enconda o texto para ser renderizável no PDF
	 *
	 * @param string $sTexto
	 * @return string
	 *
	 * @author Anailson Mota anailsonmota@moobi.com.br
	 * @since 1.0.0
	 */
	private function encode(string $sTexto): string
	{
		return iconv('UTF-8', 'CP1252', $sTexto);
	}

	/**
	 * Salva as configurações do relatório para evitar efeito colateral
	 *
	 * @param callable $fnCallback
	 *
	 * @author Anailson Mota anailsonmota@moobi.com.br
	 * @since 1.0.0
	 */
	private function cache(callable $fnCallback) 
	{
		$this->CacheConfig['DrawColor'][] = $this->DrawColor;
		$this->CacheConfig['FillColor'][] = $this->FillColor;
		$this->CacheConfig['FontFamily'][] = $this->FontFamily;
		$this->CacheConfig['FontStyle'][] = $this->FontStyle;
		$this->CacheConfig['FontSizePt'][] = $this->FontSizePt;
		$this->CacheConfig['FontSize'][] = $this->FontSize;
		$this->CacheConfig['CurrentFont'][] = $this->CurrentFont;
		$this->CacheConfig['TextColor'][] = $this->TextColor;
		$this->CacheConfig['ColorFlag'][] = $this->ColorFlag;
		$this->CacheConfig['k'][] = $this->k;

		$fnCallback($this);

		$this->DrawColor = array_pop($this->CacheConfig['DrawColor']);
		$this->FillColor = array_pop($this->CacheConfig['FillColor']);
		$this->FontFamily = array_pop($this->CacheConfig['FontFamily']);
		$this->FontStyle = array_pop($this->CacheConfig['FontStyle']);
		$this->FontSizePt = array_pop($this->CacheConfig['FontSizePt']);
		$this->FontSize = array_pop($this->CacheConfig['FontSize']);
		$this->CurrentFont = array_pop($this->CacheConfig['CurrentFont']);
		$this->TextColor = array_pop($this->CacheConfig['TextColor']);
		$this->ColorFlag = array_pop($this->CacheConfig['ColorFlag']);
		$this->k = array_pop($this->CacheConfig['k']);
	}
}

class CalculadoraLayout {

	/** @var LayoutPDF $oLayout */
	private $oLayout;

	public function __construct(LayoutPDF $oLayout)
	{
		$this->oLayout = $oLayout;
	}
	
	public function getLarguraEmMilimetros(Coluna $oColuna): float
	{
		$fPercentual = $oColuna->getConfiguracao()->getLargura();
		return $this->calcLarguraEmMilimetros($fPercentual);
	}

	public function calcularAlturaLinha(Linha $oLinha, ConfiguracaoTabela $oConfig): float 
	{
		$iTotalLinhas = 0;
		$aLarguras = $oConfig->getLargurasEmMilimetros($this);

		foreach ($aLarguras as $sColuna => $fLargura) {
			$sValor = $oLinha->getValor($sColuna);
			$iTotalLinhas = max($iTotalLinhas, $this->oLayout->NbLines($fLargura, $sValor));
		}

		$fAltura = $oLinha->getConfiguracao()->getAltura();
		return $iTotalLinhas * $fAltura;
	}

	private function calcLarguraEmMilimetros(float $fPercentual): float
	{
		$fLarguraDisponivel = $this->oLayout->getLarguraDisponivel();
		return $fLarguraDisponivel / 100 * $fPercentual;
	}
}
