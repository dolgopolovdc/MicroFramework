<?php

abstract class Parser_Xml
{
	abstract public function startElement($parser, $name, $attribs);
		
	abstract public function endElement($parser, $name);
		
	abstract public function characterData($parser, $data);
	
	protected function trustedFile($file)
	{
		// доверять только нашим собственным локальным файлам
		if (!preg_match("@^([a-z]+)\:\/\/@i", $file)
			&& fileowner($file) == getmyuid())
		{
			return true;
		}
		
		return false;
	}
				
	public function PIHandler($parser, $target, $data)
	{
		
		switch (strtolower($target)) {
			case "php":
				global $parser_file;
				// Если обработанный документ является "доверенным", то можно сказать,
				// что запуск расположенного в нем кода является безопасным. Если нет,
				// то вместо запуска отобразить сам код.
				if ($this->trustedFile($parser_file[$parser])) {
					eval($data);
				} else {
					printf("Небезопасный код PHP: <i>%s</i>",
					htmlspecialchars($data));
				}
			break;
		}
	}
				
	public function defaultHandler($parser, $data)
	{
		if (substr($data, 0, 1) == "&" && substr($data, -1, 1) == ";") {
			printf('<font color="#aa00aa">%s</font>',
			htmlspecialchars($data));
		} else {
			printf('<font size="-1">%s</font>',
			htmlspecialchars($data));
		}
	}
		
	public function externalEntityRefHandler($parser, $openEntityNames, $base, $systemId, $publicId)
	{
		if ($systemId)
		{
			if (!list($parser, $fp) = $this->new_xml_parser($systemId))
			{
				printf("Невозможно открыть сущность %s в %s\n", $openEntityNames, $systemId);
			    return false;
			}
		
			while ($data = fread($fp, 4096))
			{
				if (!xml_parse($parser, $data, feof($fp)))
				{
					printf("Ошибка XML: %s в строке %d в процессе разбора сущности %s\n",
					xml_error_string(xml_get_error_code($parser)),
					xml_get_current_line_number($parser), $openEntityNames);
					xml_parser_free($parser);
					return false;
				}
			}
			xml_parser_free($parser);
			return true;
		}
		return false;
	}
							
	protected function new_xml_parser($file)
	{
		global $parser_file;
						
		$xml_parser = xml_parser_create();
		xml_parser_set_option($xml_parser, XML_OPTION_CASE_FOLDING, 1);
		xml_set_element_handler($xml_parser, "self::startElement", "self::endElement");
		xml_set_character_data_handler($xml_parser, "self::characterData");
		xml_set_processing_instruction_handler($xml_parser, "self::PIHandler");
		xml_set_default_handler($xml_parser, "self::defaultHandler");
		xml_set_external_entity_ref_handler($xml_parser, "self::externalEntityRefHandler");
		
		if (!($fp = @fopen($file, "r")))
		{
			return false;
		}
			
		if (!is_array($parser_file))
		{
			settype($parser_file, "array");
		}
			
		$parser_file[$xml_parser] = $file;
		return array($xml_parser, $fp);
	}
			
	public function start($file)
	{				
		if (!(list($xml_parser, $fp) = $this->new_xml_parser($file)))
		{
			die("Чтение XML-файла невозможно");
		}
			
		while ($data = fread($fp, 4096))
		{
			if (!xml_parse($xml_parser, $data, feof($fp)))
			{
				die(sprintf("Ошибка XML: %s в строке %d\n",
					xml_error_string(xml_get_error_code($xml_parser)),
					xml_get_current_line_number($xml_parser)));
			}
		}
		xml_parser_free($xml_parser);
	}
		
}