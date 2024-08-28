<?php 

namespace ReportFPDF;

use Cake\Http\ServerRequest;
use Iterator;

/**
 * @package ReportFPDF;
 *
 * Class Filtro
 *
 * @author Anailson Mota anailsonmota@deso-se.com.br
 * @version 1.0.0
 */
class Filtro
{
	/** @var array $aFiltro */
	private $aFiltro = [];

	/**
	 * Cria um filtro a partir de um array associativo
	 *
	 * @param array $aFiltro
	 * @param array $aAlias = []
	 * @return Filtro 
	 *
	 * @author Anailson Mota anailsonmota@deso-se.com.br
	 * @since 1.0.0
	 */
	public static function create(array $aFiltro, array $aAlias = []): Filtro 
	{
		$oFiltro = new Filtro;
		foreach ($aFiltro as $sCampo => $sValor) {
			$sCampo = $aAlias[$sCampo] ?? $sCampo;
			$oFiltro->add($sCampo, $sValor);
		}
		return $oFiltro;
	}

	/**
	 * Constrói um filtro a partir dos parâmetros da requisição
	 *
	 * @param ServerRequest $oRequest
	 * @param array $aAlias = []
	 * @return Filtro
	 *
	 * @author Anailson Mota anailsonmota@deso-se.com.br
	 * @since 1.0.0
	 */
	public static function createFromParam(ServerRequest $oRequest, array $aAlias = []): Filtro 
	{
		$aParams = $oRequest->getQueryParams();
		return self::create($aParams, $aAlias);
	}

	/**
	 * Adiciona um novo cmapo ao filtro
	 *
	 * @return Filtro
	 *
	 * @author Anailson Mota anailsonmota@deso-se.com.br
	 * @since 1.0.0
	 */
	public function add(string $sCampo, string $sValor): Filtro {
		$this->aFiltro[$sCampo] = $sValor;
		return $this;
	}

	/**
	 * Retorna um iterador do filtro
	 *
	 * @return ArrayIterator
	 *
	 * @author Anailson Mota anailsonmota@deso-se.com.br
	 * @since 1.0.0
	 */
	public function getIterator(): ArrayIterator 
	{
		return new ArrayIterator($this->aFiltro);
	}
}
