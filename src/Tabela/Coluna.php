<?php 

namespace ReportFPDF\Tabela;

use ReportFPDF\PDF\Render\RenderCelulaPDF;
use ReportFPDF\PDF\Render\RenderCelulaPDFInterface;

/**
 * @package ReportFPDF\Tabela;
 *
 * Class Coluna
 *
 * @author Anailson Mota anailsonmota@deso-se.com.br
 * @version 1.0.0
 */
class Coluna
{
	/** @var string $sTitulo */
	private $sTitulo;

	/** @var string $sAlias */
	private $sAlias;

	/** @var ConfiguracaoColuna $oConfig */
	private $oConfig;

	/** @var callable $fnFormatacao */
	private $fnFormatacao = null;

	/** @var RenderCelulaPDFInterface $oRenderCelula */
	private $oRenderCelula;

	/** @var bool $bMock */
	private $bMock = false;

	/** @var int $iPosicao */
	private $iPosicao = null;

	/**
	 * Construtor
	 *
	 * @param string $sTitulo
	 *
	 * @author Anailson Mota anailsonmota@deso-se.com.br
	 * @since 1.0.0
	 */
	public function __construct(string $sTitulo, ConfiguracaoColuna $oConfig = null) {
		$this->sTitulo = $sTitulo;
		$this->sAlias = $sTitulo;
		$this->oConfig = $oConfig ?? new ConfiguracaoColuna;
		$this->oRenderCelula = new RenderCelulaPDF;
	}

	/**
	 * Cria uma coluna Mock para teste
	 *
	 * @param ConfiguracaoColuna $oConfig = null
	 * @return Coluna
	 *
	 * @author Anailson Mota anailsonmota@deso-se.com.br
	 * @since 1.0.0
	 */
	public static function mock(ConfiguracaoColuna $oConfig = null): Coluna 
	{
		$sTitulo = "Mock_" . uniqid();
		$oColuna = new Coluna($sTitulo, $oConfig);
		$oColuna->bMock = true;
		return $oColuna;
	}

	/**
	 * Retorna o título da coluna
	 *
	 * @return string
	 *
	 * @author Anailson Mota anailsonmota@deso-se.com.br
	 * @since 1.0.0
	 */
	public function getTitulo(): string {
		return $this->sTitulo;
	}

	/**
	 * Retorna a configuração de formatação da coluna
	 *
	 * @return ConfiguracaoColuna
	 *
	 * @author Anailson Mota anailsonmota@deso-se.com.br
	 * @since 1.0.0
	 */
	public function getConfiguracao(): ConfiguracaoColuna {
		return $this->oConfig;
	}

	/**
	 * Altera função de formatação para uma determinada coluna
	 *
	 * @return Coluna
	 *
	 * @author Anailson Mota anailsonmota@deso-se.com.br
	 * @since 1.0.0
	 */
	public function setFuncaoFormatacao(callable $fnFormatacao): Coluna
	{
		$this->fnFormatacao = $fnFormatacao;
		return $this;
	}

	/**
	 * Aplica formatação nas céluas da coluna
	 *
	 * @param string $mValor = null
	 * @return string
	 *
	 * @author Anailson Mota anailsonmota@deso-se.com.br
	 * @since 1.0.0
	 */
	public function formatar(string $mValor = null): string
	{
		if (empty($this->fnFormatacao)) {
			return $mValor ?? "";
		}

		$fnCallable = $this->fnFormatacao;
		return $fnCallable($mValor);
	}

	/**
	 * Retorna largura da coluna
	 *
	 * @param float $fPercentual
	 * @return Coluna
	 *
	 * @author Anailson Mota anailsonmota@deso-se.com.br
	 * @since 1.0.0
	 */
	public function setLargura(float $fPercentual): Coluna 
	{
		$this->oConfig = $this->getConfiguracao();
		$this->oConfig->setLargura($fPercentual);
		return $this;
	}

	/**
	 * Altera função responsável por renderizar a célula
	 *
	 * @param RenderCelulaPDFInterface $oRender
	 * @return Coluna
	 *
	 * @author Anailson Mota anailsonmota@deso-se.com.br
	 * @since 1.0.0
	 */
	public function setRenderCelula(RenderCelulaPDFInterface $oRender): Coluna 
	{
		$this->oRenderCelula = $oRender;
		return $this;
	}

	/**
	 * Retorna classe responsável por renderizar uma célula
	 *
	 * @return RenderCelulaPDFInterface
	 *
	 * @author Anailson Mota anailsonmota@deso-se.com.br
	 * @since 1.0.0
	 */
	public function getRenderCelula(): RenderCelulaPDFInterface
	{
		return $this->oRenderCelula;
	}

	/**
	 * Verifica se a coluna é um Mock
	 *
	 * @return bool
	 *
	 * @author Anailson Mota anailsonmota@deso-se.com.br
	 * @since 1.0.0
	 */
	public function isMock(): bool 
	{
		return $this->bMock;
	}

	/**
	 * Retorna o alias da coluna. Por padrão é o título informado
	 *
	 * @return string
	 *
	 * @author Anailson Mota anailsonmota@deso-se.com.br
	 * @since 1.0.0
	 */
	public function getAlias(): string 
	{
		return $this->sAlias;
	}

	/**
	 * Altera o alias da coluna
	 *
	 * @param string $sAlias
	 * @return Coluna
	 *
	 * @author Anailson Mota anailsonmota@deso-se.com.br
	 * @since 1.0.0
	 */
	public function setAlias(string $sAlias): Coluna 
	{
		$this->sAlias = $sAlias;
		return $this;
	}

	/**
	 * Retorna a posição da coluna
	 *
	 * @return null|int
	 *
	 * @author Anailson Mota anailsonmota@deso-se.com.br
	 * @since 1.0.0
	 */
	public function getPosicao(): ?int {
		return $this->iPosicao;
	}

	/**
	 * Altera a posição da coluna
	 *
	 * @param int $iPosicao
	 * @return Coluna
	 *
	 * @author Anailson Mota anailsonmota@deso-se.com.br
	 * @since 1.0.0
	 */
	public function setPosicao(int $iPosicao): Coluna {
		$this->iPosicao = $iPosicao;
		return $this;
	}
}
