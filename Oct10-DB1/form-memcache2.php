<!DOCTYPE HTML>
<html>
<head>
<style>
        .error {
            color: #FF0000;
        }
    </style>
</head>
<body>

<?php
//

// Use: ab -n 20000 -c 180 http://localhost/form-memcache.php
// To test the speed of this file.

// define variables and set to empty values
$nameErr = $emailErr = $genderErr = $websiteErr = "";
$name = $email = $gender = $comment = $website = "";

$servername = "localhost";
$username = "root";
$password = "student";
$dbname = "cats";

	// DB connection code is moved below so it only connects to the DB if needed.
	
	// Memcache connection
$m = new Memcached;
$m->addServer('localhost', 11211);
$memcache_key = 'Entries'; // This will be the key for entries in the table
					// We store it here so when a new entry is provided we can delete
					// the key to force a  new DB request.

if ($_SERVER["REQUEST_METHOD"] == "POST") {
	if (empty($_POST["name"])) {
		$nameErr = "Name is required";
	} else {
		$name = test_input($_POST["name"]);
		// check if name only contains letters and whitespace
		if (!preg_match("/^[a-zA-Z ]*$/",$name)) {
			$nameErr = "Only letters and white space allowed";
		}
	}
	if (empty($_POST["email"])) {
		$emailErr = "Email is required";
	} else {
		$email = test_input($_POST["email"]);
		// check if e-mail address is well-formed
		if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
			
		}
	}
	if (empty($_POST["website"])) {
		$website = "";
	} else {
		$website = test_input($_POST["website"]);
		// check if URL address syntax is valid
		if (!preg_match("/\b(?:(?:https?|ftp):\/\/|www\.)[-a-z0-9+&@#\/%?=~_|!:,.;]*[-a-z0-9+&@#\/%=~_|]/i",$website)) {
			$websiteErr = "Invalid URL";
		}
	}
	if (empty($_POST["comment"])) {
		$comment = "";
	} else {
		$comment = test_input($_POST["comment"]);
	}
	if (empty($_POST["gender"])) {
		$genderErr = "Gender is required";
	} else {
		$gender = test_input($_POST["gender"]);
	}

	if( $genderErr == '' && $websiteErr == '' && $emailErr == '' && $nameErr == ''){
		// Only make a DB connection if we have to
		$conn = new mysqli($servername, $username, $password,$dbname);
		// Check connection
		if ($conn->connect_error){
			die("Connection failed: " . $conn->connect_error);
		}
		$sql = "INSERT INTO MyGuests (name, message) VALUES ('$name', '$comment')";
		//echo $sql;
        if ($conn->query($sql) === TRUE) {

            echo "New record created successfully". "<br/>";
            // Delete the key to force a DB call later otherwise stale data will be displayed
            $m->delete($memcache_key);

        } else {

            echo "Error: " . $sql . "<br>" . $conn->error;

        }   
    }

}

function test_input($data) {
	$data = trim($data);
	$data = stripslashes($data);//get rid of the backslashes
	$data = htmlspecialchars($data);
	return $data;
}
    ?>

<h2>PHP Form Validation Example</h2>
<p>
	<span class="error">* required field.</span>
</p>
<form method="post" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']);?>">
Name:
<input type="text" name="name" />
<span class="error">
* <?php echo $nameErr;?>
</span>
<br />
<br />
E-mail:
<input type="text" name="email" />
<span class="error">
* <?php echo $emailErr;?>
</span>
<br />
<br />
Website:
<input type="text" name="website" />
<span class="error">
<?php echo $websiteErr;?>
</span>
<br />
<br />
Comment:
<textarea name="comment" rows="5" cols="40"></textarea>
<br />
<br />
Gender:
<input type="radio" name="gender" value="female" />Female
<input type="radio" name="gender" value="male" />Male
<span class="error">
* <?php echo $genderErr;?>
</span>
<br />
<br />
<input type="submit" name="submit" value="Submit" />
</form>

<?php
	echo "<h2>Your Input:</h2>";
	echo $name;
	echo "<br>";
	echo $email;
	echo "<br>";
	echo $website;
	echo "<br>";
	echo $comment;
	echo "<br>";
	echo $gender;

	
	// See if memcache has any data
	$result = $m->get($memcache_key);

	echo "<br/>";
	// If not in memcache, hit the DB for info and store it in memcache for later
	if(!$result){
		echo "Did a DB lookup  ";
		// Make a DB connection only if neccessary
		$conn = new mysqli($servername, $username, $password,$dbname);
		// Check connection
		if ($conn->connect_error){
			die("Connection failed: " . $conn->connect_error);
		}
		$sql = "SELECT id, name, message FROM MyGuests";
		$result = $conn->query($sql);
		$rows = array(); // Array to store rows for memcache
		for($i = 0; $i < $result->num_rows; $i++){
			$row = $result->fetch_assoc();
			$rows[] = $row; // Push the row onto the rows array (2d)
			echo "id: " . $row["id"]. " - Name: " . $row["name"]. " " . $row["message"]. "<br>";
        }
        // This config is preferible to storing every row as  a new key:value pair as it will do
        // one set/get for each request rather then being related to the number of entries.
        $m->set($memcache_key, $rows, 5); // Only store this for 5 seconds
	}else{
		$rows = $m->get($memcache_key);
		foreach($rows as $row){
			echo "id: " . $row["id"]. " - Name: " . $row["name"]. " " . $row["message"]. "<br>";
        }
	}
	
	
?>
</body>
</html>