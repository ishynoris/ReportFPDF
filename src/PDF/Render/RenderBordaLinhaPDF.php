<?php


namespace ReportFPDF\PDF\Render;

use ReportFPDF\PDF\Fonte;
use ReportFPDF\PDF\LayoutPDF;

/**
 * @package ReportFPDF\PDF\Render;
 *
 * Class RenderBordaLinhaPDF
 *
 * @author Anailson Mota anailsonmota@deso-se.com.br
 * @version 1.0.0
 */
class RenderBordaLinhaPDF
{
	/** @var LayoutPDF $oLayout */
	private $oLayout;

	/**
	 * Construtor
	 *
	 * @param LayoutPDF $oLayout
	 *
	 * @author Anailson Mota anailsonmota@deso-se.com.br
	 * @since 1.0.0
	 */
	public function __construct(LayoutPDF $oLayout) 
	{
		$this->oLayout = $oLayout;
	}

	/**
	 * Imprime as bordas de uma determinada linha
	 *
	 * @param Fonte $oFonte
	 * @param float $fX
	 * @param float $fY
	 * @param float $fAltura
	 *
	 * @author Anailson Mota anailsonmota@deso-se.com.br
	 * @since 1.0.0
	 */
	public function imprimir(Fonte $oFonte, float $fAltura, float $fX = null, float $fY = null)
	{
		$fX = $fX ?? $this->oLayout->GetX();
		$fY = $fY ?? $this->oLayout->GetY();

		$this->imprimirBackground($oFonte, $fX, $fY, $fAltura);
		$this->imprimirBorda($oFonte, $fX, $fY, $fAltura);
	}

	/**
	 * Imprime a borda de uma linha
	 *
	 * @param Linha $oLinha
	 * @param float $fX
	 * @param float $fY
	 * @param float $fAltura
	 *
	 * @author Anailson Mota anailsonmota@moobi.com.br
	 * @since 1.0.0
	 */
	private function imprimirBorda(Fonte $oFonte, float $fX, float $fY, float $fAltura) 
	{
		$oBorda = $oFonte->getBorda();
		if (empty($oBorda)) {
			return;
		}

		$fLargura = $this->oLayout->getLarguraDisponivel();
		$fXFinal = $fX + $fLargura;

		$aCor = $oBorda->getCorRGB();
		$this->oLayout->SetDrawColor($aCor['R'], $aCor['G'], $aCor['B']);

		if ($oBorda->hasBordaSuperior()) {
			$this->oLayout->SetLineWidth(0.5);
			$this->oLayout->Line($fX, $fY, $fXFinal, $fY);
		}

		if ($oBorda->hasBordaInferior()) {
			$fYFinal = $fY + $fAltura;
			$this->oLayout->SetLineWidth(0.1);
			$this->oLayout->Line($fX, $fYFinal, $fXFinal, $fYFinal);
		}
	}

	/**
	 * Imprime o background de uma linha
	 *
	 * @param Linha $oLinha
	 * @param float $fX
	 * @param float $fY
	 * @param float $fAltura
	 *
	 * @author Anailson Mota anailsonmota@deso-se.com.br
	 * @since 1.0.0
	 */
	private function imprimirBackground(Fonte $oFonte, float $fX, float $fY, float $fAltura) 
	{
		$aCor = $oFonte->getCorFundoRGB();
		if (empty($aCor)) {
			return;
		}

		$fLargura = $this->oLayout->getLarguraDisponivel();
		$this->oLayout->SetFillColor($aCor['R'], $aCor['G'], $aCor['B']);
		$this->oLayout->Rect($fX, $fY, $fLargura, $fAltura, "F");
	}
}
