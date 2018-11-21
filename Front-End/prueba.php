<?php
   if( $_GET["email"]) {
      echo "Your email is ". $_GET['email'];
      
      exit();
   }
   if( $_POST["user"] || $_POST["password"] ) {
      echo "Welcome ". $_POST['user']. "<br />";
      echo "Your password is ". $_POST['age'];
      
      exit();
   }
?>