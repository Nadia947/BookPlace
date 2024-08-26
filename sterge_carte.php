<?php 
require_once("connection.php"); 

if(!isset($_SESSION['auth'])){
  header('Location: login.php');
}
?>
<?php

if(isset($_GET['id']))
{
    $sterge = "DELETE FROM carti WHERE id_carte='" . $_GET['id'] . "'"; 
    $rezutat=mysqli_query($con, $sterge);
    if($rezutat){
      if($_SESSION['role_as'] == 0){
      ?>

      <script>window.history.back();</script>    

    <?php 
    } else {
      header('Location: carti.php');
    }
  }   
}

?>