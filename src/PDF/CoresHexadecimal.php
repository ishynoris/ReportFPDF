<?php

namespace ReportFPDF\PDF;

/**
 * Class CoresHexadecimal
 * @package Framework\Constantes
 */
class CoresHexadecimal 
{	
	/**
	 * As cores devem ser definidas sem o #
	 */
	const VERMELHO = "ff0000";
	const VERDE = "008000";
	const BRANCO = "f0f0ff";
	const PRETO = "000000";
	const AZUL = "3245cc";
	const LARANJA = "FFA500";
	const AMARELO = "FFFF00";
	const ROSA = "FC0FC0";
	const MARRON = "964b00";
	const CINZA = "333333";
	const CINZA_CLARO = "d2d6de";
	const VIOLETA = "9400D3";
	const CIANO = "00FFFF";
	const MAGENTA = "FF00FF";
	const AZUL_NAVAL = "000080";
	const VERDE_CLARO = "90EE90";
	const SALMAO = "FA7F72";
	const MIDNIGHT_BLUE = "191970";
	const CIANO_ESCURO = "008B8B";
	const VERDE_ESCURO = "006400";
	const VERDE_LIMAO = "00FF00";
	const INDIGO = "4B0082";
	const ROXO = "A020F0";
	const CRIMSON = "DC143C";
	const VERMELHO_ESCURO = "8B0000";
	const BRANCO_FANTASMA = "D3D3F4";
	const AZUL_CLARO = "D7EBFF";
	const VERDE_ACINZENTADO = "Dff0D8";

	/**
	 * Retorna as constantes definidas na classe como uma array que pode ser usado para montar um combo
	 *
	 * @author Anailson Mota anailsonmota@deso-se.com.br
	 *
	 * @return array
	 */
	public static function getArrayCombo(): array {
		$aCombo = [];

		$aCombo['VERDE'] = ['id' => self::VERDE, 'value' => "Verde"];
		$aCombo['VERMELHO'] = ['id' => self::VERMELHO, 'value' => "Vermelho"];
		$aCombo['BRANCO'] = ['id' => self::BRANCO, 'value' => "Branco"];
		$aCombo['PRETO'] = ['id' => self::PRETO, 'value' => "Preto"];
		$aCombo['AZUL'] = ['id' => self::AZUL, 'value' => "Azul"];
		$aCombo['LARANJA'] = ['id' => self::LARANJA, 'value' => "Laranja"];
		$aCombo['AMARELO'] = ['id' => self::AMARELO, 'value' => "Amarelo"];
		$aCombo['ROSA'] = ['id' => self::ROSA, 'value' => "Rosa"];
		$aCombo['MARRON'] = ['id' => self::MARRON, 'value' => "Marron"];
		$aCombo['CINZA'] = ['id' => self::CINZA, 'value' => "Cinza"];
		$aCombo['CINZA_CLARO'] = ['id' => self::CINZA_CLARO, 'value' => "Cinza claro"];
		$aCombo['VIOLETA'] = ['id' => self::VIOLETA, 'value' => "Violeta"];
		$aCombo['CIANO'] = ['id' => self::CIANO, 'value' => "Ciano"];
		$aCombo['MAGENTA'] = ['id' => self::MAGENTA, 'value' => "Magenta"];
		$aCombo['AZUL_NAVAL'] = ['id' => self::AZUL_NAVAL, 'value' => "Azul naval"];
		$aCombo['VERDE_CLARO'] = ['id' => self::VERDE_CLARO, 'value' => "Verde claro"];
		$aCombo['SALMAO'] = ['id' => self::SALMAO, 'value' => "Salmão"];
		$aCombo['MIDNIGHT_BLUE'] = ['id' => self::MIDNIGHT_BLUE, 'value' => "Midnight Blue"];
		$aCombo['CIANO_ESCURO'] = ['id' => self::CIANO_ESCURO, 'value' => "Ciano Escuro"];
		$aCombo['VERDE_ESCURO'] = ['id' => self::VERDE_ESCURO, 'value' => "Verde Escuro"];
		$aCombo['VERDE_LIMAO'] = ['id' => self::VERDE_LIMAO, 'value' => "Verde Limão"];
		$aCombo['INDIGO'] = ['id' => self::INDIGO, 'value' => "Indigo"];
		$aCombo['ROXO'] = ['id' => self::ROXO, 'value' => "Roxo"];
		$aCombo['CRIMSON'] = ['id' => self::CRIMSON, 'value' => "Crimson"];
		$aCombo['VERMELHO_ESCURO'] = ['id' => self::VERMELHO_ESCURO, 'value' => "Vermelho Escuro"];
		$aCombo['BRANCO_FANTASMA'] = ['id' => self::BRANCO_FANTASMA, 'value' => "Branco Fantasma"];
		$aCombo['AZUL_CLARO'] = ['id' => self::AZUL_CLARO, 'value' => "Azul Claro"];

		return $aCombo;
	}

	/**
	 * Converte uma cor hexadecimal no padrão RGB.
	 *
	 * @param string $sCorHexadecimal
	 * @return array 
	 *
	 * @author Anailson Mota anailsonmota@deso-se.com.br
	 */
	public static function converteHexadecimalParaRGB(string $sCorHexadecimal = null): array {
		if (empty($sCorHexadecimal)) {
			return [];
		}

		$sCorHexadecimal = str_replace("#", "", $sCorHexadecimal);
		$sRed = substr($sCorHexadecimal, 0, 2);
		$sGreen = substr($sCorHexadecimal, 2, 2);
		$sBlue = substr($sCorHexadecimal, 4, 2);

		return [
			'R' => empty($sRed) ? null : hexdec($sRed),
			'G' => empty($sGreen) ? null : hexdec($sGreen),
			'B' => empty($sBlue) ? null : hexdec($sBlue),
		];
	}
}
