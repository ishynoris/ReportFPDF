<?php

namespace ReportFPDF\PDF;

/**
 * @package ReportFPDF\PDF;
 *
 * Class RelatorioPDF
 *
 * @author Anailson Mota anailsonmota@deso-se.com.br
 * @version 1.0.0
 */
class RelatorioPDF
{
	/** @var RelatorioInterface $oRelatorio */
	private $oRelatorio;

	/** @var LayoutPDF $oLayout */
	private $oLayout;

	/**
	 * Construtor
	 *
	 * @param LayoutPDF $oTabela
	 *
	 * @author Anailson Mota anailsonmota@deso-se.com.br
	 * @since 1.0.0
	 */
	public function __construct(RelatorioInterface $oRelatorio, LayoutPDF $oLayout = null)
	{
		$this->oRelatorio = $oRelatorio;
		$this->oLayout = $oLayout ?? new LayoutPDF;
	}

	/**
	 * Renderiza o PDF na tela
	 *
	 * @author Anailson Mota anailsonmota@deso-se.com.br
	 * @since 1.0.0
	 */
	public function render() {
		$oLayout = $this->gerar();
 		$oLayout->Output();
		die;
	}

	/**
	 * Retorna o conteúdo do relatório
	 *
	 * @return string
	 *
	 * @author Anailson Mota anailsonmota@deso-se.com.br
	 * @since 1.0.0
	 */
	public function getConteudo(): string 
	{
		$oLayout = $this->gerar();
		return $oLayout->Output("S");
	}

	/**
	 * Realiza o download do relatório
	 *
	 * @param string $sNomeArquivo
	 *
	 * @author Anailson Mota anailsonmota@deso-se.com.br
	 * @since 1.0.0
	 */
	public function download(string $sNomeArquivo = "") 
	{
		$oLayout = $this->gerar();
		$oLayout->Output("I", $sNomeArquivo);
		die;
	}

	/**
	 * Gera o PDF do relatório
	 *
	 * @return LayoutPDF
	 *
	 * @author Anailson Mota anailsonmota@moobi.com.br
	 * @since 1.0.0
	 */
	private function gerar(): LayoutPDF 
	{
		return $this->oRelatorio->gerar($this->oLayout);
	}
}
