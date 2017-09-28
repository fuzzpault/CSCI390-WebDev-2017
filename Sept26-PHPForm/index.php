<!DOCTYPE html>
<html>
<head>
  <title>Color Table</title>
</head>

<body>

<h1>Feed me numbers!</h1>
<form method="get" >
<?php
	$a = 0;
	$b = 0;
	if(isset($_GET["armadilo"])){
		$a = $_GET["armadilo"];
	}
	if(isset($_GET["bat"])){
		$b = $_GET["bat"];
	}
?>
a: <input type="text" name="armadilo" value="<?php echo $a; ?>"/><br />
b: <input type="text" name="bat" value="<?php echo $b; ?>"/> <br />
<input type="submit" value="Do math!" />
</form>


The sum is: <?php echo $a + $b ; ?>

<table>
  <tr>
   <td bgcolor="#ff8800">Something</td>
   <td>More</td>
  </tr>
</table>

</body>
</html>