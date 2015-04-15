<?PHP

require_once 'Color.class.php';

Class Vertex
{
	public static $verbose = false;

	private $_x = 0;
	private $_y = 0;
	private $_z = 0;
	private $_w = 1;
	private $_color = null;

	static function doc()
	{
		return(file_get_contents('Vertex.doc.txt'));
	}

	function __construct( array $kwargs )
	{
		if (array_key_exists('x', $kwargs) && array_key_exists('y', $kwargs) && array_key_exists('z', $kwargs))
		{
			$this->setX($kwargs['x']);
			$this->setY($kwargs['y']);
			$this->setZ($kwargs['z']);
		}
		else
		{
			print('Vextex Initialization Error.'.PHP_EOL);
		}
		if (array_key_exists('w', $kwargs))
			$this->setW($kwargs['w']);
		if (array_key_exists('color', $kwargs))
			$this->setColor($kwargs['color']);
		else
			$this->setColor(new Color(array('rgb' => 0xFFFFFF)));
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
		if (self::$verbose)
			return('Vertex( x: '.number_format($this->getX(), 2).', y: '.number_format($this->getY(), 2).', z:'.number_format($this->getZ(), 2).', w:'.number_format($this->getW(), 2).', '.$this->getColor().' )');
		else
			return('Vertex( x: '.number_format($this->getX(), 2).', y: '.number_format($this->getY(), 2).', z:'.number_format($this->getZ(), 2).', w:'.number_format($this->getW(), 2).' )');
	}

	function getX() { return $this->_x; }

	function getY() { return $this->_y; }

	function getZ() { return $this->_z; }

	function getW() { return $this->_w; }

	function getColor() { return $this->_color; }

	function setX($x) { $this->_x = $x; }

	function setY($y) { $this->_y = $y; }

	function setZ($z) { $this->_z = $z; }

	function setW($w) { $this->_w = $w; }

	function setColor(Color $color) { $this->_color = $color; }
}
?>
