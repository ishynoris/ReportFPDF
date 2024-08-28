<?php 


namespace ReportFPDF;

use Countable;
use Iterator;

/**
 * @package ReportFPDF;
 *
 * Class ArrayIterator
 *
 * @author Anailson Mota anailsonmota@deso-se.com.br
 * @version 1.0.0
 */
class ArrayIterator implements Iterator, Countable
{
	/** @var int $iIndice */
	private $iIndice;

	/** @var array $aValores */
	private $aValores;

	/** @var array $aKeys */
	private $aKeys;

	/**
	 * Construtor
	 *
	 * @param array $aValores
	 *
	 * @author Anailson Mota anailsonmota@deso-se.com.br
	 * @since 1.0.0
	 */
	public function __construct(array $aValores) 
	{
		$this->aValores = $aValores;
		$this->aKeys = array_keys($aValores);
		$this->iIndice = 0;
	}

	public function rewind(): void
	{
		reset($this->aKeys);
		$this->iIndice = 0;
	}

	public function current()
	{
		$mKey = $this->key();
		return $this->aValores[$mKey];
	}

	public function next(): void
	{
		next($this->aKeys);
		$this->iIndice++;
	}

	public function key()
	{
		return current($this->aKeys);
	}

	public function valid(): bool
	{
		$mKey = $this->key();
		return isset($this->aValores[$mKey]);
	}

	public function getIndice(): int 
	{
		return $this->iIndice;
	}

	public function count(): int 
	{
		return count($this->aValores);
	}
}
