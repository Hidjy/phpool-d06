<?PHP

require_once 'Vertex.class.php';
require_once 'Vector.class.php';

Class Matrix
{
	const CUSTOM		= 0;
	const IDENTITY		= 1;
	const SCALE			= 2;
	const RX			= 3;
	const RY			= 4;
	const RZ			= 5;
	const TRANSLATION	= 6;
	const PROJECTION	= 7;

	public static $verbose = False;

	private $_vtcX;
	private $_vtcY;
	private $_vtcZ;
	private $_vtxO;

	static function doc()
	{
		return(file_get_contents('Matrix.doc.txt'));
	}

	function __construct( array $kwargs )
	{
		if (!array_key_exists('preset', $kwargs))
		{
			print('Matrix Initialization Error.'.PHP_EOL);
		}
		else
		{
			switch ($kwargs['preset'])
			{
				case self::CUSTOM:
					$this->_vtcX = clone $kwargs['vtcX'];
					$this->_vtcY = clone $kwargs['vtcY'];
					$this->_vtcZ = clone $kwargs['vtcZ'];
					$this->_vtxO = clone $kwargs['vtxO'];
					break;

				case self::IDENTITY:
					$preset = 'IDENTITY';
					$this->_vtcX = new Vector( array(
						'dest' => new Vertex( array(
							'x' => 1,
							'y' => 0,
							'z' => 0,
							'w' => 0
						))));
					$this->_vtcY = new Vector( array(
						'dest' => new Vertex( array(
							'x' => 0,
							'y' => 1,
							'z' => 0,
							'w' => 0
						))));
					$this->_vtcZ = new Vector( array(
						'dest' => new Vertex( array(
							'x' => 0,
							'y' => 0,
							'z' => 1,
							'w' => 0
						))));
					$this->_vtxO = new Vertex( array(
							'x' => 0,
							'y' => 0,
							'z' => 0,
							'w' => 1
						));
					break;

				case self::SCALE:
					$preset = 'SCALE';
					$this->_vtcX = new Vector( array(
						'dest' => new Vertex( array(
							'x' => $kwargs['scale'],
							'y' => 0,
							'z' => 0,
							'w' => 0
						))));
					$this->_vtcY = new Vector( array(
						'dest' => new Vertex( array(
							'x' => 0,
							'y' => $kwargs['scale'],
							'z' => 0,
							'w' => 0
						))));
					$this->_vtcZ = new Vector( array(
						'dest' => new Vertex( array(
							'x' => 0,
							'y' => 0,
							'z' => $kwargs['scale'],
							'w' => 0
						))));
					$this->_vtxO = new Vertex( array(
							'x' => 0,
							'y' => 0,
							'z' => 0,
							'w' => 1
						));
					break;

				case self::RX:
					$preset = 'Ox ROTATION';
					$this->_vtcX = new Vector( array(
						'dest' => new Vertex( array(
							'x' => 1,
							'y' => 0,
							'z' => 0,
							'w' => 0
						))));
					$this->_vtcY = new Vector( array(
						'dest' => new Vertex( array(
							'x' => 0,
							'y' => cos( $kwargs['angle'] ),
							'z' => sin( $kwargs['angle'] ),
							'w' => 0
						))));
					$this->_vtcZ = new Vector( array(
						'dest' => new Vertex( array(
							'x' => 0,
							'y' => -sin( $kwargs['angle'] ),
							'z' => cos( $kwargs['angle'] ),
							'w' => 0
						))));
					$this->_vtxO = new Vertex( array(
							'x' => 0,
							'y' => 0,
							'z' => 0,
							'w' => 1
						));
					break;

				case self::RY:
					$preset = 'Oy ROTATION';
					$this->_vtcX = new Vector( array(
						'dest' => new Vertex( array(
							'x' => cos( $kwargs['angle'] ),
							'y' => 0,
							'z' => -sin( $kwargs['angle'] ),
							'w' => 0
						))));
					$this->_vtcY = new Vector( array(
						'dest' => new Vertex( array(
							'x' => 0,
							'y' => 1,
							'z' => 0,
							'w' => 0
						))));
					$this->_vtcZ = new Vector( array(
						'dest' => new Vertex( array(
							'x' => sin( $kwargs['angle'] ),
							'y' => 0,
							'z' => cos( $kwargs['angle'] ),
							'w' => 0
						))));
					$this->_vtxO = new Vertex( array(
							'x' => 0,
							'y' => 0,
							'z' => 0,
							'w' => 1
						));
					break;

				case self::RZ:
					$preset = 'Oz ROTATION';
					$this->_vtcX = new Vector( array(
						'dest' => new Vertex( array(
							'x' => cos( $kwargs['angle'] ),
							'y' => sin( $kwargs['angle'] ),
							'z' => 0,
							'w' => 0
						))));
					$this->_vtcY = new Vector( array(
						'dest' => new Vertex( array(
							'x' => -sin( $kwargs['angle'] ),
							'y' => cos( $kwargs['angle'] ),
							'z' => 0,
							'w' => 0
						))));
					$this->_vtcZ = new Vector( array(
						'dest' => new Vertex( array(
							'x' => 0,
							'y' => 0,
							'z' => 1,
							'w' => 0
						))));
					$this->_vtxO = new Vertex( array(
							'x' => 0,
							'y' => 0,
							'z' => 0,
							'w' => 1
						));
					break;

				case self::TRANSLATION:
					$preset = 'TRANSLATION';
					$this->_vtcX = new Vector( array(
						'dest' => new Vertex( array(
							'x' => 1,
							'y' => 0,
							'z' => 0,
							'w' => 0
						))));
					$this->_vtcY = new Vector( array(
						'dest' => new Vertex( array(
							'x' => 0,
							'y' => 1,
							'z' => 0,
							'w' => 0
						))));
					$this->_vtcZ = new Vector( array(
						'dest' => new Vertex( array(
							'x' => 0,
							'y' => 0,
							'z' => 1,
							'w' => 0
						))));
					$this->_vtxO = new Vertex( array(
							'x' => $kwargs['vtc']->getX(),
							'y' => $kwargs['vtc']->getY(),
							'z' => $kwargs['vtc']->getZ(),
							'w' => 1
						));
					break;

				case self::PROJECTION:
					$preset = 'PROJECTION';
					$fov = deg2rad($kwargs['fov']);
					$top = tan($fov / 2) * $kwargs['near'];
					$bottom = -$top;
					$right = $kwargs['ratio'] * $top;
					$left = -$right;
					$this->_vtcX = new Vector( array(
						'dest' => new Vertex( array(
							'x' => 2 * $kwargs['near'] / ($right - $left),
							'y' => 0,
							'z' => 0,
							'w' => 0
						))));
					$this->_vtcY = new Vector( array(
						'dest' => new Vertex( array(
							'x' => 0,
							'y' => 2 * $kwargs['near'] / ($top - $bottom),
							'z' => 0,
							'w' => 0
						))));
					$this->_vtcZ = new Vector( array(
						'dest' => new Vertex( array(
							'x' => ($right + $left) / ($right - $left),
							'y' => ($top + $bottom) / ($top - $bottom),
							'z' => -($kwargs['far'] + $kwargs['near']) / ($kwargs['far'] - $kwargs['near']),
							'w' => -1
						))));
					$this->_vtxO = new Vertex( array(
							'x' => 0,
							'y' => 0,
							'z' => -2 * $kwargs['far'] * $kwargs['near'] / ($kwargs['far'] - $kwargs['near']),
							'w' => 0
						));
					break;

				default:
					print('Matrix Initialization Error.'.PHP_EOL);
					break;
			}
		}
		if (self::$verbose)
			if ($kwargs['preset'] === self::IDENTITY)
				print('Matrix '.$preset.' instance constructed'.PHP_EOL);
			else if ($kwargs['preset'] !== self::CUSTOM)
				print('Matrix '.$preset.' preset instance constructed'.PHP_EOL);

	}

	function __destruct()
	{
		if (self::$verbose)
			print('Matrix instance destructed'.PHP_EOL);
	}

	function __toString()
	{
		$str  = 'M | vtcX | vtcY | vtcZ | vtxO' . PHP_EOL;
		$str .= '-----------------------------' . PHP_EOL;
		$str .= 'x | '.number_format($this->_vtcX->getX(), 2).' | '.number_format($this->_vtcY->getX(), 2).' | '.number_format($this->_vtcZ->getX(), 2).' | ' .number_format($this->_vtxO->getX(), 2). PHP_EOL;
		$str .= 'y | '.number_format($this->_vtcX->getY(), 2).' | '.number_format($this->_vtcY->getY(), 2).' | '.number_format($this->_vtcZ->getY(), 2).' | ' .number_format($this->_vtxO->getY(), 2). PHP_EOL;
		$str .= 'z | '.number_format($this->_vtcX->getZ(), 2).' | '.number_format($this->_vtcY->getZ(), 2).' | '.number_format($this->_vtcZ->getZ(), 2).' | ' .number_format($this->_vtxO->getZ(), 2). PHP_EOL;
		$str .= 'w | '.number_format($this->_vtcX->getW(), 2).' | '.number_format($this->_vtcY->getW(), 2).' | '.number_format($this->_vtcZ->getW(), 2).' | ' .number_format($this->_vtxO->getW(), 2);
		return $str;
	}

	function getVtcX() { return $this->_vtcX; }

	function getVtcY() { return $this->_vtcY; }

	function getVtcZ() { return $this->_vtcZ; }

	function getVtxO() { return $this->_vtxO; }

	function mult(Matrix $rhs)
	{
		$vtcX = new Vector( array(
			'dest' => new Vertex( array(
				'x' => $this->_vtcX->getX() * $rhs->getVtcX()->getX() + $this->_vtcY->getX() * $rhs->getVtcX()->getY() + $this->_vtcZ->getX() * $rhs->getVtcX()->getZ() + $this->_vtxO->getX() * $rhs->getVtcX()->getW(),
				'y' => $this->_vtcX->getY() * $rhs->getVtcX()->getX() + $this->_vtcY->getY() * $rhs->getVtcX()->getY() + $this->_vtcZ->getY() * $rhs->getVtcX()->getZ() + $this->_vtxO->getY() * $rhs->getVtcX()->getW(),
				'z' => $this->_vtcX->getZ() * $rhs->getVtcX()->getX() + $this->_vtcY->getZ() * $rhs->getVtcX()->getY() + $this->_vtcZ->getZ() * $rhs->getVtcX()->getZ() + $this->_vtxO->getZ() * $rhs->getVtcX()->getW(),
				'w' => $this->_vtcX->getW() * $rhs->getVtcX()->getX() + $this->_vtcY->getW() * $rhs->getVtcX()->getY() + $this->_vtcZ->getW() * $rhs->getVtcX()->getZ() + $this->_vtxO->getW() * $rhs->getVtcX()->getW()) ) ) );
		$vtcY = new Vector( array(
			'dest' => new Vertex( array(
				'x' => $this->_vtcX->getX() * $rhs->getVtcY()->getX() + $this->_vtcY->getX() * $rhs->getVtcY()->getY() + $this->_vtcZ->getX() * $rhs->getVtcY()->getZ() + $this->_vtxO->getX() * $rhs->getVtcY()->getW(),
				'y' => $this->_vtcX->getY() * $rhs->getVtcY()->getX() + $this->_vtcY->getY() * $rhs->getVtcY()->getY() + $this->_vtcZ->getY() * $rhs->getVtcY()->getZ() + $this->_vtxO->getY() * $rhs->getVtcY()->getW(),
				'z' => $this->_vtcX->getZ() * $rhs->getVtcY()->getX() + $this->_vtcY->getZ() * $rhs->getVtcY()->getY() + $this->_vtcZ->getZ() * $rhs->getVtcY()->getZ() + $this->_vtxO->getZ() * $rhs->getVtcY()->getW(),
				'w' => $this->_vtcX->getW() * $rhs->getVtcY()->getX() + $this->_vtcY->getW() * $rhs->getVtcY()->getY() + $this->_vtcZ->getW() * $rhs->getVtcY()->getZ() + $this->_vtxO->getW() * $rhs->getVtcY()->getW()) ) ) );
		$vtcZ = new Vector( array(
			'dest' => new Vertex( array(
				'x' => $this->_vtcX->getX() * $rhs->getVtcZ()->getX() + $this->_vtcY->getX() * $rhs->getVtcZ()->getY() + $this->_vtcZ->getX() * $rhs->getVtcZ()->getZ() + $this->_vtxO->getX() * $rhs->getVtcZ()->getW(),
				'y' => $this->_vtcX->getY() * $rhs->getVtcZ()->getX() + $this->_vtcY->getY() * $rhs->getVtcZ()->getY() + $this->_vtcZ->getY() * $rhs->getVtcZ()->getZ() + $this->_vtxO->getY() * $rhs->getVtcZ()->getW(),
				'z' => $this->_vtcX->getZ() * $rhs->getVtcZ()->getX() + $this->_vtcY->getZ() * $rhs->getVtcZ()->getY() + $this->_vtcZ->getZ() * $rhs->getVtcZ()->getZ() + $this->_vtxO->getZ() * $rhs->getVtcZ()->getW(),
				'w' => $this->_vtcX->getW() * $rhs->getVtcZ()->getX() + $this->_vtcY->getW() * $rhs->getVtcZ()->getY() + $this->_vtcZ->getW() * $rhs->getVtcZ()->getZ() + $this->_vtxO->getW() * $rhs->getVtcZ()->getW()) ) ) );
		$vtxO = new  Vertex( array(
				'x' => $this->_vtcX->getX() * $rhs->getVtxO()->getX() + $this->_vtcY->getX() * $rhs->getVtxO()->getY() + $this->_vtcZ->getX() * $rhs->getVtxO()->getZ() + $this->_vtxO->getX() * $rhs->getVtxO()->getW(),
				'y' => $this->_vtcX->getY() * $rhs->getVtxO()->getX() + $this->_vtcY->getY() * $rhs->getVtxO()->getY() + $this->_vtcZ->getY() * $rhs->getVtxO()->getZ() + $this->_vtxO->getY() * $rhs->getVtxO()->getW(),
				'z' => $this->_vtcX->getZ() * $rhs->getVtxO()->getX() + $this->_vtcY->getZ() * $rhs->getVtxO()->getY() + $this->_vtcZ->getZ() * $rhs->getVtxO()->getZ() + $this->_vtxO->getZ() * $rhs->getVtxO()->getW(),
				'w' => $this->_vtcX->getW() * $rhs->getVtxO()->getX() + $this->_vtcY->getW() * $rhs->getVtxO()->getY() + $this->_vtcZ->getW() * $rhs->getVtxO()->getZ() + $this->_vtxO->getW() * $rhs->getVtxO()->getW()) );
		$new = new Matrix( array( 'preset' => self::CUSTOM, 'vtcX' => $vtcX, 'vtcY' => $vtcY, 'vtcZ' => $vtcZ, 'vtxO' => $vtxO ) );
		return $new;
	}

	function transformVertex(Vertex $vtx)
	{
		$new = new Vertex( array(
			'x' => $this->_vtcX->getX() * $vtx->getX() + $this->_vtcY->getX() * $vtx->getY() + $this->_vtcZ->getX() * $vtx->getZ() + $this->_vtxO->getX() * $vtx->getW() ,
			'y' => $this->_vtcX->getY() * $vtx->getX() + $this->_vtcY->getY() * $vtx->getY() + $this->_vtcZ->getY() * $vtx->getZ() + $this->_vtxO->getY() * $vtx->getW() ,
			'z' => $this->_vtcX->getZ() * $vtx->getX() + $this->_vtcY->getZ() * $vtx->getY() + $this->_vtcZ->getZ() * $vtx->getZ() + $this->_vtxO->getZ() * $vtx->getW() ,
			'w' => $this->_vtcX->getW() * $vtx->getX() + $this->_vtcY->getW() * $vtx->getY() + $this->_vtcZ->getW() * $vtx->getZ() + $this->_vtxO->getW() * $vtx->getW()  ) );
		return $new;
	}
}
?>
