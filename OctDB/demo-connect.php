<?php

// Name: Paul Talaga
// An example of PHP connecting to a MYSQL database
// From http://php.net/manual/en/mysql.examples-basic.php


// Connecting, selecting database
$link = mysql_connect('localhost', 'root', 'student')
    or die('Could not connect: ' . mysql_error());
echo 'Connected successfully';
mysql_select_db('mysql') or die('Could not select database');  // Change your DB here

// Performing SQL query
$query = 'SELECT * FROM user';  // Change your table here
$result = mysql_query($query) or die('Query failed: ' . mysql_error());

// Printing results in HTML
echo "<table>\n";
while ($line = mysql_fetch_array($result, MYSQL_ASSOC)) {
    echo "\t<tr>\n";
    foreach ($line as $col_value) {
        echo "\t\t<td>$col_value</td>\n";
    }
    echo "\t</tr>\n";
}
echo "</table>\n";

// Free resultset
mysql_free_result($result);

// Closing connection
mysql_close($link);
?>