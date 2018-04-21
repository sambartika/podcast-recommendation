<?php
  unset($_COOKIE['username']);
  unset($_COOKIE['userid']);
  unset($_COOKIE['loggedin']);
  unset($_COOKIE['userrole']); 
  
  setcookie('loggedin', '', time()-300); 
  setcookie('username', '', time()-300);
  setcookie('userid', '', time()-300);  
  setcookie('userrole', '', time()-300);  
  
  header("Location: index.php");
?>