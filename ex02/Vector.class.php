<?PHP
Class Vector
{
	public static $verbose = false;

	private Vertex $_dest;
	private Vertex $_orig;

	static function doc()
	{
		return(file_get_contents('Vector.doc.txt'));
	}

	function __construct( array $kwargs )
	{
		if (array_key_exists('dest', $kwargs))
			$_dest = clone $kwargs['dest'];
		else
			print('Vector Initialization Error.'.PHP_EOL);
		if (array_key_exists('orig', $kwargs))
			$_orig = clone $kwargs['orig'];
		else
			$_orig = new Vertex( 'x' => 0, 'y' => 0, 'z' => 0, 'w' => 1 );
		if (self::$verbose)
			print($this.' constructed'.PHP_EOL);

	}

	function __destruct()
	{
		if (self::$verbose)
			print($this.' destructed'.PHP_EOL);
	}

	function __toString()
	{
		//return('Vertex( x: '.number_format($this->getX(), 2).', y: '.number_format($this->getY(), 2).', z:'.number_format($this->getZ(), 2).', w:'.number_format($this->getW(), 2).' )');
	}

	function getX() { return $this->_dest->getX(); }

	function getY() { return $this->_dest->getY(); }

	function getZ() { return $this->_dest->getZ(); }

	function getW() { return $this->_dest->getW(); }
}
?>
