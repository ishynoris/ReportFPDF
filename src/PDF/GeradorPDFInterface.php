<?php


namespace ReportFPDF\PDF;

use ReportFPDF\Filtro;

/**
 * @package ReportFPDF\PDF;
 *
 * Class GeradorPDFInterface
 *
 * @author Anailson Mota anailsonmota@deso-se.com.br
 * @version 1.0.0
 */
interface GeradorPDFInterface
{
	/**
	 * Preenche o filtro do relatório
	 *
	 * @param Filtro $oFiltro
	 *
	 * @author Anailson Mota anailsonmota@deso-se.com.br
	 * @since 1.0.0
	 */
	public function setFiltro(Filtro $oFiltro);

	/**
	 * Gera o PDF com o layout informado
	 *
	 * @param LayoutPDF $oLayout
	 *
	 * @author Anailson Mota anailsonmota@deso-se.com.br
	 * @since 1.0.0
	 */
	public function gerar(LayoutPDF $oLayout);
}
