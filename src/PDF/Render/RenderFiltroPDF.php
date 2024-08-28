<?php 


namespace ReportFPDF\PDF\Render;

use ReportFPDF\Filtro;
use ReportFPDF\PDF\Borda;
use ReportFPDF\PDF\CoresHexadecimal;
use ReportFPDF\PDF\Fonte;
use ReportFPDF\PDF\LayoutPDF;

/**
 * @package ReportFPDF\PDF\Render;
 *
 * Class RenderFiltroPDF
 *
 * @author Anailson Mota anailsonmota@deso-se.com.br
 * @version 1.0.0
 */
class RenderFiltroPDF
{
	/** @var int $iTotalColunas */
	private $iTotalColunas;

	/** @var array $aPosicaoInicialColuna */
	private $aPosicaoInicialColuna;

	/** @var LayoutPDF $oLayout */
	private $oLayout;

	/** @var float $fAlturaLinha */
	private $fAlturaLinha;

	/**
	 * Construtor
	 *
	 * @param LayoutPDF $oLayout
	 *
	 * @author Anailson Mota anailsonmota@deso-se.com.br
	 * @since 1.0.0
	 */
	public function __construct(LayoutPDF $oLayout, int $iTotalColunas = 4, float $fAlturaLinha = 5) 
	{
		$this->oLayout = $oLayout;
		$this->iTotalColunas = $iTotalColunas;
		$this->fAlturaLinha = $fAlturaLinha;
		$this->aPosicaoInicialColuna = [];

		$fMargemEsquerda = $oLayout->getMargemEsquerda();
		$fLargura = $oLayout->getLarguraDisponivel() - $fMargemEsquerda;
		$fLarguraColuna = $fLargura / $this->iTotalColunas;

		for ($i = 0; $i < $this->iTotalColunas; $i++) {
			$this->aPosicaoInicialColuna[$i] = $fMargemEsquerda + ($i * $fLarguraColuna);
		}
	}

	/**
	 * Imprime os filtros do relatório
	 *
	 * @param Filtro $oFiltro
	 *
	 * @author Anailson Mota anailsonmota@deso-se.com.br
	 * @since 1.0.0
	 */
	public function imprimir(Filtro $oFiltro) 
	{
		$oIterator = $oFiltro->getIterator();
		$this->imprimirBorda($oIterator->count());

		$this->oLayout->configurarFonte(Fonte::SourceSans("", 9));

		$bPrimeiroFiltro = true;
		foreach ($oIterator as $sCampo => $sValor) {
			$iColuna = $oIterator->getIndice() % $this->iTotalColunas;
			$bQuebraLinha = $iColuna == 0;
			if ($bQuebraLinha && !$bPrimeiroFiltro) {
				$this->oLayout->Ln();
			}

			$sCampoFiltro = $sCampo . ": ";
			$fLarguraCampo = $this->oLayout->GetStringWidth($sCampoFiltro);

			$fPosicaoX = $this->aPosicaoInicialColuna[$iColuna];
			$this->oLayout->SetX($fPosicaoX);
			$this->oLayout->Bold();
			$this->oLayout->Cell($fLarguraCampo, $this->fAlturaLinha, $sCampoFiltro);

			$fPosicaoX = $this->oLayout->GetX() + 1;
			$this->oLayout->SetX($fPosicaoX);
			$this->oLayout->Bold(false);
			$this->oLayout->Cell(0, $this->fAlturaLinha, $sValor);

			$bPrimeiroFiltro = false;
		}

		$this->oLayout->Ln(2 * $this->fAlturaLinha);
	}

	/**
	 * Imprime a borda do filtro
	 *
	 * @param int $iTotalFiltros
	 *
	 * @author Anailson Mota anailsonmota@moobi.com.br
	 * @since 1.0.0
	 */
	private function imprimirBorda(int $iTotalFiltros)
	{
		$oFonte = Fonte::SourceSans("", 9)
			->setBorda(new Borda(CoresHexadecimal::CINZA_CLARO, "BT"));

		$fAltura = $this->fAlturaLinha * ceil($iTotalFiltros / $this->iTotalColunas);
		$oRenderBorda = new RenderBordaLinhaPDF($this->oLayout);
		$oRenderBorda->imprimir($oFonte, $fAltura);
	}
}
