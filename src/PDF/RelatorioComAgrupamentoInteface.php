<?php 

namespace ReportFPDF\PDF;

use ReportFPDF\PDF\LayoutPDF;

/**
 * @package ReportFPDF;
 *
 * Class RelatorioComAgrupamentoInteface
 *
 * @author Anailson Mota anailsonmota@deso-se.com.br
 * @version 1.0.0
 */
interface RelatorioComAgrupamentoInteface extends RelatorioInterface
{
	/**
	 * Retorna o conteúdo do relatório
	 *
	 * @param string $sAgrupamento
	 *
	 * @author Anailson Mota anailsonmota@deso-se.com.br
	 * @since 1.0.0
	 */
	public function setAgrupamento(string $sAgrupamento);
}
