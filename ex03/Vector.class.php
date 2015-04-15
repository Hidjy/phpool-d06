<?PHP

require_once 'Vertex.class.php';

Class Vector
{
	public static $verbose = false;

	private $_dest;
	private $_orig;

	static function doc()
	{
		return(file_get_contents('Vector.doc.txt'));
	}

	function __construct( array $kwargs )
	{
		if (array_key_exists('dest', $kwargs))
		{
			$this->_dest = clone $kwargs['dest'];
		}
		else
		{
			$this->_dest = new Vertex( array('x' => 0, 'y' => 0, 'z' => 0, 'w' => 0) );
			print('Vector Initialization Error.'.PHP_EOL);
		}
		if (array_key_exists('orig', $kwargs))
			$this->_orig = clone $kwargs['orig'];
		else
			$this->_orig = new Vertex( array('x' => 0, 'y' => 0, 'z' => 0, 'w' => 1) );
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
		return('Vector( x:'.number_format($this->getX(), 2, '.', '').', y:'.number_format($this->getY(), 2, '.', '').', z:'.number_format($this->getZ(), 2, '.', '').', w:'.number_format($this->getW(), 2, '.', '').' )');
	}

	function getX() { return $this->_dest->getX() - $this->_orig->getX(); }

	function getY() { return $this->_dest->getY() - $this->_orig->getY(); }

	function getZ() { return $this->_dest->getZ() - $this->_orig->getZ(); }

	function getW() { return $this->_dest->getW(); }

	function magnitude()
	{
		return sqrt(pow($this->getX(), 2) + pow($this->getY(), 2) + pow($this->getZ(), 2));
	}

	function normalize()
	{
		$len = $this->magnitude();
		$new = new Vector( array(
		'dest' => new Vertex ( array ( 'x' => ( $this->getX() / $len ) + $this->_orig->getX(),
										'y' => ( $this->getY() / $len ) + $this->_orig->getY(),
										'z' => ( $this->getZ() / $len ) + $this->_orig->getZ() )),
		'orig' => $this->_orig ));
		return $new;
	}

	function add(Vector $rhs)
	{
		$new = new Vector( array(
		'dest' => new Vertex ( array ( 'x' => $this->getX() + $rhs->getX(),
										'y' => $this->getY() + $rhs->getY(),
										'z' => $this->getZ() + $rhs->getZ() ))));
		return $new;
	}

	function sub(Vector $rhs)
	{
		$new = new Vector( array(
		'dest' => new Vertex ( array ( 'x' => $this->getX() - $rhs->getX(),
										'y' => $this->getY() - $rhs->getY(),
										'z' => $this->getZ() - $rhs->getZ() ))));
		return $new;
	}

	function opposite()
	{
		$new = new Vector( array(
		'dest' => new Vertex ( array ( 'x' => -$this->getX(),
										'y' => -$this->getY(),
										'z' => -$this->getZ() ))));
		return $new;
	}

	function scalarProduct($k)
	{
		$new = new Vector( array(
		'dest' => new Vertex ( array ( 'x' => $this->getX() * $k,
										'y' => $this->getY() * $k,
										'z' => $this->getZ() * $k ))));
		return $new;
	}

	function dotProduct(Vector $rhs)
	{
		return ($this->getX() * $rhs->getX() + $this->getY() * $rhs->getY() + $this->getZ() * $rhs->getZ());
	}

	function cos(Vector $rhs)
	{
		return ($this->dotProduct($rhs) / ( $this->magnitude() * $rhs->magnitude() ));
	}

	public function crossProduct($rhs)
	{
		$ret = new Vector (array (
		'dest' => new Vertex( array('x' => $this->getY() * $rhs->getZ() - $this->getZ() * $rhs->getY(),
									'y' => $this->getZ() * $rhs->getX() - $this->getX() * $rhs->getZ(),
									'z' => $this->getX() * $rhs->getY() - $this->getY() * $rhs->getX() ))));
		return ($ret);
	}
}
?>
