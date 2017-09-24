<?php

// Name: Paul Talaga
// An example of PHP connecting to a MYSQL database
// From http://php.net/manual/en/mysql.examples-basic.php


// Connecting, selecting database
$link = new mysqli('localhost','root','student','mysql')
    or die('Could not connect: ' . $link->connect_error);

echo 'Connected successfully';


// Performing SQL query
$query = 'SELECT * FROM user';  // Change your table here
$result = $link->query($query) or die('Query failed: ' . mysql_error());

// Printing results in HTML

echo "<table>\n";
while ($line = $result->fetch_array()) {
    echo "\t<tr>\n";
    foreach ($line as $col_value) {
        echo "\t\t<td>$col_value</td>\n";
    }
    echo "\t</tr>\n";
}
echo "</table>\n";


// Closing connection
mysql_close($link);
$link->close();

?>