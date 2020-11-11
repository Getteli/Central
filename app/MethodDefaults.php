<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MethodDefaults extends Model
{
	static function removeSpecialCharacter($var)
	{
		// Transforma em minusculo.
		$content = strtolower($var);
		// Remove todos os acentos pelas suas letras originais.
		// OBS: no final da expressão regular é passado "ui", onde o "u" significa unicode e o "i" case insensitive para evitar possíveis erros.
		$content = preg_replace('/[áàãâä]/ui', 'a', $content); 
		$content = preg_replace('/[éèêë]/ui', 'e', $content);
		$content = preg_replace('/[íìîï]/ui', 'i', $content);
		$content = preg_replace('/[óòõôö]/ui', 'o', $content);
		$content = preg_replace('/[úùûü]/ui', 'u', $content);
		$content = preg_replace('/[ç]/ui', 'c', $content);
		// aqui pega tudo o que não for letra ou número e troca por nada e junta, sem espaço.
		$content = preg_replace('/[^a-z0-9]/i', '', $content);
		return $content;
	}
}