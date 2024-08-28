<?php

namespace ReportFPDF\PDF\Render;;

use ReportFPDF\PDF\LayoutPDF;
use ReportFPDF\PDF\Render\RenderCelulaPDFInterface;
use ReportFPDF\Tabela\Celula;
use ReportFPDF\Tabela\ConfiguracaoTabela;

/**
 * @package namespace
 *
 * Class RenderCelulaPDF
 *
 * @author Anailson Mota anailsonmota@moobi.com.br
 * 
 * @version 1.0.0
 */ 
class RenderCelulaPDF implements RenderCelulaPDFInterface
{ 
	/**
	 * Renderiza a célula
	 *
	 * @param LayoutPDF $oLayout,
	 * @param Celula $oCelula
	 *
	 * @author Anailson Mota anailsonmota@moobi.com.br
	 * @since 1.0.0
	 */
	public function render(LayoutPDF $oLayout, Celula $oCelula, ConfiguracaoTabela $oConfig)
	{		
		$oCalculadora = $oLayout->getCalculadora();
		$oColuna = $oCelula->getColuna();
		$oLinha = $oCelula->getLinha();

		$sValor = $oColuna->isMock() ? "" : $oCelula->getValor();
		$sAlinhamento = $oColuna->getConfiguracao()->getAlinhamento();
		$fLargura = $oCalculadora->getLarguraEmMilimetros($oColuna);
		$fAltura = $oLinha->getConfiguracao()->getAltura();
		$oFonte = $oLinha->getConfiguracao()->getFonte();

		$oLayout->configurarFonte($oFonte);
		$oLayout->MultiCell($fLargura, $fAltura, $sValor, 0, $sAlinhamento);
	}
}