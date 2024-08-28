<?php 

namespace ReportFPDF\PDF\Render;

use ReportFPDF\PDF\LayoutPDF;
use ReportFPDF\Tabela\Celula;
use ReportFPDF\Tabela\ConfiguracaoTabela;

/**
 * @package ReportFPDF\PDF\Render
 *
 * interface RenderCelulaPDFInterface
 *
 * @author Anailson Mota anailsonmota@moobi.com.br
 * 
 * @version 1.0.0
 */ 
interface RenderCelulaPDFInterface 
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
	public function render(LayoutPDF $oLayout, Celula $oCelula, ConfiguracaoTabela $oConfig);
}
