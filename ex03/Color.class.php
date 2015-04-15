<?php
class Color
{
	public static $verbose = False;

	public $red = 0;
	public $green = 0;
	public $blue = 0;

	static function doc()
	{
		return(file_get_contents('Color.doc.txt'));
	}

	function __construct( array $kwargs )
	{
		if (array_key_exists('rgb', $kwargs))
		{
			$this->red = ($kwargs['rgb'] >> 16) & 0xFF;
			$this->green = ($kwargs['rgb'] >> 8) & 0xFF;
			$this->blue = ($kwargs['rgb'] >> 0) & 0xFF;
		}
		else
		{
			if (array_key_exists('red', $kwargs))
				$this->red = round($kwargs['red']);
			if (array_key_exists('green', $kwargs))
				$this->green = round($kwargs['green']);
			if (array_key_exists('blue', $kwargs))
				$this->blue = round($kwargs['blue']);
		}
		if (self::$verbose)
			print($this.' constructed.'.PHP_EOL);

	}

	function __destruct()
	{
		if (self::$verbose)
			print($this.' destructed.'.PHP_EOL);
	}

	function __toString()
	{
		return('Color( red: '.str_pad($this->red, 3, ' ', STR_PAD_LEFT).', green: '.str_pad($this->green, 3, ' ', STR_PAD_LEFT).', blue: '.str_pad($this->blue, 3, ' ', STR_PAD_LEFT).' )');
	}

	function add(Color $color)
	{
		return (new Color(array('red' => ($this->red + $color->red), 'green' => ($this->green + $color->green), 'blue' => ($this->blue + $color->blue))));
	}

	function sub(Color $color)
	{
		return (new Color(array('red' => ($this->red - $color->red), 'green' => ($this->green - $color->green), 'blue' => ($this->blue - $color->blue))));
	}

	function mult($nb)
	{
		return (new Color(array('red' => ($this->red * $nb), 'green' => ($this->green * $nb), 'blue' => ($this->blue * $nb))));
	}
}
?>
