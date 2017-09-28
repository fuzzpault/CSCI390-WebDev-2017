<!DOCTYPE html>
<html>
<head>
  <title>Color Table</title>
</head>

<body>

<h3>Enter two colors in hex (# w/6 hex digits)</h3>
<form method="get" >
<?php
	

	function getColor($x, $y, &$c1, &$c2){
		// Given fractions [0,1], return a new color between c1 and c2, in 
		// RGB hex format.
		$r1 = hexdec(substr($c1, 1, 2));
		$r2 = hexdec(substr($c2, 1, 2));
		$g1 = hexdec(substr($c1, 3, 2));
		$g2 = hexdec(substr($c2, 3, 2));
		$b1 = hexdec(substr($c1, 5, 2));
		$b2 = hexdec(substr($c2, 5, 2));

		$amt = ($x + $y) / 2;

		$ret = "#".sprintf("%'.02x",($r2 - $r1) * $amt + $r1);
		$ret = $ret . sprintf("%'.02x",($g2 - $g1) * $x + $g1);
		$ret = $ret . sprintf("%'.02x",($b2 - $b1) * $y + $b1);
		return $ret;
	}

	$c1 = '#000000';
	$c2 = '#ffffff';
	if(isset($_GET["c1"])){
		$c1 = $_GET["c1"];
	}
	if(isset($_GET["c2"])){
		$c2 = $_GET["c2"];
	}
?>
color1: <input type="text" name="c1" value="<?php echo $c1; ?>"/><br />
color2: <input type="text" name="c2" value="<?php echo $c2; ?>"/> <br />
<input type="submit" value="Plot!" />
</form>


<table border="0" cellspacing="0">
  <?php
  	$width = 20;
  	$height = 20;
  	for($y = 0; $y < $height; $y++){
  		echo "   <tr>\n";
  		for($x = 0; $x < $width; $x++){
  			$color = getColor($x/($width-1), $y / ($height-1), $c1, $c2);
  			echo "     <td bgcolor=\"$color\" title=\"$color\">&nbsp;&nbsp;&nbsp;</td>\n";
  		}
  		echo "   </tr>\n";
  	}
  ?>
</table>

</body>
</html>