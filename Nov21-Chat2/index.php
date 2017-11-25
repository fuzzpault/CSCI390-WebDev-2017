<?php
	session_start();
?>
<!DOCTYPE HTML>
<html>
<head>
  <link rel="stylesheet" type="text/css" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
  <script type="text/javascript">
  var ajaxHandle;
  
  function likeIt(user){
    ajaxHandle = new XMLHttpRequest();
      ajaxHandle.onreadystatechange = updatePage;
      ajaxHandle.open('GET','action.php?like=' + user, true);
      ajaxHandle.send(null);
  }

  function getNewMessages(){
      ajaxHandle = new XMLHttpRequest();
      ajaxHandle.onreadystatechange = updatePage;
      ajaxHandle.open('GET','action.php', true);
      ajaxHandle.send(null);
  }
  // Call getNewMessages every 500 ms to get chat updates
  window.setInterval(getNewMessages, 500);

  function sendMessage(){
    var message = document.getElementById('message').value;
    document.getElementById('message').value = ''; // Reset the text box.
      ajaxHandle = new XMLHttpRequest();
      ajaxHandle.onreadystatechange = updatePage;
      // URI encode the message so any character can be sent
      ajaxHandle.open('GET','action.php?msg=' + encodeURIComponent(message), true);
      ajaxHandle.send(null);
  }

  function updatePage(){
    if(ajaxHandle.readyState == 4 && // done
      ajaxHandle.status == 200 && // Sucessfull response
      ajaxHandle.responseText){
        var response = JSON.parse(ajaxHandle.responseText);
        var toWrite = "";
        
        for(var i = 0; i < response.result.length; i++){
          toWrite += '<button onClick="likeIt(\'' + response.result[i].user +'\');">I Like!</button>';
          toWrite += response.result[i].user;
          toWrite += ' : ';
          toWrite += response.result[i].likes;
          toWrite += ' : ';
          toWrite += response.result[i].msg;
          toWrite += '<br>';
          
        }
        document.getElementById('history').innerHTML = toWrite;
    }
  }
  
  
  </script>
</head>
<body>
<h1>The new AOL Instant Messenger</h1>

<input type="text" id="message" onchange="sendMessage();"></input>
<br>

<div id="history" style="overflow:scroll;height:300px;width:500px;overflow:auto"></div>


</body>
</html>