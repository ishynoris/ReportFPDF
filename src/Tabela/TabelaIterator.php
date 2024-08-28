<?php 


namespace ReportFPDF\Tabela;

use Iterator;

/**
 * @package ReportFPDF\Tabela;
 *
 * Class TabelaIterator
 *
 * @author Anailson Mota anailsonmota@deso-se.com.br
 * @version 1.0.0
 */
class TabelaIterator implements Iterator
{
	/** @var bool $bQuebraLinha */
	private $bQuebraLinha;

	/** @var string $sColunaAtual */
	private $sColunaAtual;

	/** @var int $iLinhaAtual */
	private $iLinhaAtual;

	/** @var ColunaList $loColunas */
	private $loColunas;

	/** @var LinhaList $loLinhas */
	private $loLinhas;

	/**
	 * Construtor
	 *
	 * @param ColunaList $loColuna, LinhaList $loLinhas
	 *
	 * @author Anailson Mota anailsonmota@deso-se.com.br
	 * @since 1.0.0
	 */
	public function __construct(ColunaList $loColuna, LinhaList $loLinhas)
	{
		$this->bQuebraLinha = false;
		$this->loColunas = $loColuna;
		$this->loLinhas = $loLinhas;
	}

	/**
	 * Retorna a celala da iteração da tabela
	 *
	 * @return Celula
	 *
	 * @author Anailson Mota anailsonmota@deso-se.com.br
	 * @since 1.0.0
	 */
	public function current()
	{
		$oColuna = $this->loColunas->current();
		$oLinha = $this->loLinhas->current();
		return $oLinha->getCelula($oColuna);
	}

	/**
	 * Aponta para a próxima célula da tabela. 
	 * Será iterado a célula de cada coluna, uma linha por vez.
	 *
	 * @author Anailson Mota anailsonmota@deso-se.com.br
	 * @since 1.0.0
	 */
	public function next(): void
	{
		$this->loColunas->next();
		$this->sColunaAtual = $this->loColunas->key();
		$this->bQuebraLinha = is_null($this->sColunaAtual);

		if ($this->bQuebraLinha) {
			$this->nextLine();
		}
	}

	/**
	 * Avança a iteração para a proxima linha da tabela
	 *
	 * @author Anailson Mota anailsonmota@deso-se.com.br
	 * @since 1.0.0
	 */
	protected function nextLine(): void {
		$this->loColunas->rewind();
		$this->sColunaAtual = $this->loColunas->key();

		$this->loLinhas->next();
		$this->iLinhaAtual = $this->loLinhas->key();
	}

	/**
	 * Aponta o iterador para a última coluna da tabela
	 *
	 * @author Anailson Mota anailsonmota@deso-se.com.br
	 * @since 1.0.0
	 */
	public function lastColumn(): void 
	{
		$this->loColunas->end();
		$this->sColunaAtual = $this->loColunas->key();
	}

	/**
	 * Retorna a chave da célula, representado pela concatenação linha e coluna
	 *
	 * @return mixed
	 *
	 * @author Anailson Mota anailsonmota@deso-se.com.br
	 * @since 1.0.0
	 */
	public function key()
	{
		return "{$this->iLinhaAtual}_{$this->sColunaAtual}";
	}

	/**
	 * Verifica se a célula é valida
	 *
	 * @return bool
	 *
	 * @author Anailson Mota anailsonmota@deso-se.com.br
	 * @since 1.0.0
	 */
	public function valid(): bool
	{
		return !is_null($this->sColunaAtual) && !is_null($this->iLinhaAtual);
	}

	/**
	 * Marca o ínicio da tabela
	 *
	 * @author Anailson Mota anailsonmota@deso-se.com.br
	 * @since 1.0.0
	 */
	public function rewind(): void
	{
		$this->loColunas->rewind();
		$this->sColunaAtual = $this->loColunas->key();

		$this->loLinhas->rewind();
		$this->iLinhaAtual = $this->loLinhas->key();
	}

	/**
	 * Verifica se há uma quebra de linha na iteração k 
	 *
	 * @return bool
	 *
	 * @author Anailson Mota anailsonmota@moobi.com.br
	 * @since 1.0.0
	 */
	public function isQuebraLinha(): bool 
	{
		return $this->bQuebraLinha;
	}
}
