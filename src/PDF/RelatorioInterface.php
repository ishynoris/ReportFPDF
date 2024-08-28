<?php 

namespace ReportFPDF\PDF;

use ReportFPDF\PDF\LayoutPDF;

/**
 * @package ReportFPDF;
 *
 * Class RelatorioInterface
 *
 * @author Anailson Mota anailsonmota@deso-se.com.br
 * @version 1.0.0
 */
interface RelatorioInterface
{
	/**
	 * Retorna o conteúdo do relatório
	 *
	 * @return LayoutPDF
	 *
	 * @author Anailson Mota anailsonmota@deso-se.com.br
	 * @since 1.0.0
	 */
	public function gerar(LayoutPDF $oLayout): LayoutPDF;
}
