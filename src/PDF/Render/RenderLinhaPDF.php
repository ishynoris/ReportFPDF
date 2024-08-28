<?php 

namespace ReportFPDF\PDF\Render;

use ReportFPDF\PDF\LayoutPDF;
use ReportFPDF\Tabela\Celula;
use ReportFPDF\Tabela\Coluna;
use ReportFPDF\Tabela\ConfiguracaoTabela;
use ReportFPDF\Tabela\Linha;

/**
 * @package ReportFPDF\PDF\Render;
 *
 * Class RenderLinhaPDF
 *
 * @author Anailson Mota anailsonmota@deso-se.com.br
 * @version 1.0.0
 */
class RenderLinhaPDF
{
	/** @var LayoutPDF $oLayout */
	private $oLayout;

	/** @var ConfiguracaoTabela $oConfigTabela */
	private $oConfig;

	/**
	 * Construtor
	 *
	 * @param LayoutPDF $oLayout
	 *
	 * @author Anailson Mota anailsonmota@deso-se.com.br
	 * @since 1.0.0
	 */
	public function __construct(LayoutPDF $oLayout, ConfiguracaoTabela $oConfigTabela) 
	{
		$this->oLayout = $oLayout;
		$this->oConfig = $oConfigTabela;
	}

	/**
	 * Imprime as informações de uma linha no layout
	 *
	 * @param Linha $oLinha
	 *
	 * @author Anailson Mota anailsonmota@deso-se.com.br
	 * @since 1.0.0
	 */
	public function imprimir(Linha $oLinha)
	{
		$oLinha = $oLinha->getLinhaCompleta($this->oConfig->getColunas());

		$oConfigLinha = $oLinha->getConfiguracao();
		$oFonte = $oConfigLinha->getFonte();

		$oCalculadora = $this->oLayout->getCalculadora();
		$fAlturaLinha = $oCalculadora->calcularAlturaLinha($oLinha, $this->oConfig);
		$this->oLayout->CheckPageBreak($fAlturaLinha);

		$oRenderBorda = new RenderBordaLinhaPDF($this->oLayout);
		$oRenderBorda->imprimir($oFonte, $fAlturaLinha);

		$oLinhaIterator = $oLinha->getIterator();
		foreach ($oLinhaIterator as $sColuna => $sValor) {
			$oColuna = $this->oConfig->getColuna($sColuna);

			$fPosiX = $this->oLayout->GetX();
			$fPosiY = $this->oLayout->GetY();
			$fLargura = $oCalculadora->getLarguraEmMilimetros($oColuna);

			$oCelula = new Celula($oColuna, $oLinha);
			$oRender = $oColuna->getRenderCelula();
			$oRender->render($this->oLayout, $oCelula, $this->oConfig);

			$this->oLayout->SetXY($fPosiX + $fLargura, $fPosiY);
		}
		$this->oLayout->Ln($fAlturaLinha);
	}
}
