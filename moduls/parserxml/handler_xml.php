<?php

require_once 'parser_xml.php';

class Handler_Xml extends Parser_Xml 
{
	public function startElement($parser, $name, $attribs)
	{
		echo "&lt;<font color=\"#0000cc\">$name</font>";
	
		if (count($attribs))
		{
			foreach ($attribs as $k => $v)
			{
				echo " <font color=\"#009900\">$k</font>=\"<font
				color=\"#990000\">$v</font>\"";
			}
		}
	
		echo "&gt;";
	}
			
	public function endElement($parser, $name)
	{
		echo "&lt;/<font color=\"#0000cc\">$name</font>&gt;";
	}
				
	public function characterData($parser, $data)
	{
		echo "<b>$data</b>";
	}
	
	public function start($file)
	{
		if (!(list($xml_parser, $fp) = $this->new_xml_parser($file)))
		{
			die("Чтение XML-файла невозможно");
		}
			
		echo "<pre>";
			
		while ($data = fread($fp, 4096))
		{
			if (!xml_parse($xml_parser, $data, feof($fp)))
			{
				die(sprintf("Ошибка XML: %s в строке %d\n",
						xml_error_string(xml_get_error_code($xml_parser)),
						xml_get_current_line_number($xml_parser)));
			}
		}
		echo "</pre>";
		echo "разбор завершен\n";
		xml_parser_free($xml_parser);
	}
}