<!DOCTYPE html>
<HTML>


<head>
    
    <title>Color  Table</title>
</head>
<BODY>
 
    <?php

          echo "Hello World!";
              $servername = "localhost";
            $username = "root";
            $password = "student";

        $dbname = "test";

         // Create connection
        $conn = new mysqli($servername, $username, $password,$dbname);
        // Check connection
        if ($conn->connect_error){
           die("Connection failed: " . $conn->connect_error);
        }
        echo "Connected successfully". "<br/>";

         
        /*// sql to create table
        $sql = "CREATE TABLE MyGuests (
        id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
        firstname VARCHAR(30) NOT NULL,
        lastname VARCHAR(30) NOT NULL,
        email VARCHAR(50),
        reg_date TIMESTAMP
        )";

        if ($conn -> query($sql) === TRUE) {
            echo "Table MyGuests created successfully" . "<br/>";
        } else {
            echo "Error creating table: " . $link->error;
        }*/
 
         

        /*   //inserting ito table

        $sql = "INSERT INTO MyGuests (firstname, lastname, email)

        VALUES ('John', 'Doe', 'john@example.com')";

        if ($conn->query($sql) === TRUE) {

            echo "New record created successfully". "<br/>";

        } else {

            echo "Error: " . $sql . "<br>" . $conn->error;

        }   */

        

//updating


 
            $sql = "UPDATE MyGuests SET lastname='Doe111' WHERE id=1";
            if ($conn->query($sql) === TRUE) {

                echo "Record updated successfully";

            } else {

                echo "Error updating record: " . $conn->error;

            }

          //select record

        $sql = "SELECT id, firstname, lastname FROM MyGuests";

        $result = $conn->query($sql);

        if ($result->num_rows > 0) {

            echo "<br/>";


            while($row = $result->fetch_assoc()) {


                echo "id: " . $row["id"]. " - Name: " . $row["firstname"]. " " . $row["lastname"]. "<br>";
            }


        } else {

            echo "0 results";  
        }
 


$conn.close();
 
  ?>


</BODY>

</HTML>

 