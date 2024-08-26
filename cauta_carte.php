<?php 
require_once("connection.php"); 
if(!isset($_SESSION['auth'])){
    header('Location: login.php');
}
?>
<?php include('header.php');?>

<!--bara de sus-->
<div data-sticky-container>
    <div class="sticky sticky-topbar bordura-nav" data-sticky data-options="anchor: page; marginTop: 0; stickyOn: small;">

        <div class="title-bar" data-responsive-toggle="responsive-menu" data-hide-for="medium"> 
            <div class="title-bar-title" style="width: 100%;">
                <ul class="menu horizontal">
                    <li style="padding-right: 10px;"><a onclick="window.history.back()"><i class="fa-solid fa-angle-left fa-2x"></i></a></li>
                    <li style="display: none;"><img src="img/moon.png" id="icon" class="iconita" style="cursor: pointer; width: 25px;"></li>
                </ul>
            </div>
        </div> 

        <div class="top-bar" id="responsive-menu">
            <div class="top-bar-left">
                <ul class="menu">
                    <li style="padding-right: 10px;"><a onclick="window.history.back()"><i class="fa-solid fa-angle-left fa-2x"></i></a></li>
                    <li style="display: none;"><img src="img/moon.png" id="icon" class="iconita" style="cursor: pointer; width: 25px;"></li>
                </ul>  
            </div>
        </div>

    </div>
</div>
<!--bara de sus-->

<?php
$titlu = htmlspecialchars($_GET['titlu']);
$cauta=mysqli_query($con,"SELECT * FROM carti, utilizatori 
                          WHERE carti.apartine_utilizator = utilizatori.id 
                          AND carti.publicata=1
                          AND carti.titlu LIKE '%". $titlu ."%';");
?>

<?php
  if(mysqli_num_rows($cauta) > 0 and $titlu != NULL)
  {
?>

<div style="max-width: 1100px; margin:auto">
  <div class="grid-container" style="padding-top: 50px; padding-bottom: 500px;">
    <h3 class="culoare-scris">Rezultatele cautarii "<b><?php echo $titlu?></b>"</h3>
    <hr>
    <br>
    <div class="grid-x grid-margin-x">

      <?php
      while ($myrow=mysqli_fetch_array($cauta,MYSQLI_ASSOC)) 
      {
        $carte=$myrow["id_carte"];
        $rev=mysqli_query($con,"SELECT * FROM pareri, utilizatori WHERE de_la_carte=$carte AND pareri.de_la_utilizator=utilizatori.id AND pareri.stele=1");
        $total_stele=mysqli_num_rows($rev);
       ?>

        <div class="cell small-12 medium-6">
          <div class="callout culoare-card culoare-umbra-cell" style="border-radius:10px;">

            <?php
            if($_SESSION['role_as'] == 0){
            ?>

            <div class="grid-x">
                <div class="cell medium-4 small-6 animatie">
                  <img src="img/<?php echo $myrow["poza_coperta"]?>" style="max-height: 200px; border-radius: 10px">
                </div>
                <div class="cell medium-8 small-6">
                  <h5 class="culoare-scris"><?php echo $myrow["titlu"]?></h5>
                  <br>
                  <pre class="culoare-scris" style="padding-bottom:10px"><a href="pagina_utilizator.php?id=<?php echo $myrow["id"]?>"><img src="img/<?php echo $myrow["poza_profil"]?>" style="width:30px;" class="rotund">  <?php echo $myrow["nume"]?></a></pre>
                  
                  <p class="culoare-scris"><?php echo $total_stele?> <i class="fa-solid fa-star"></i></p>
                  <a href="pagina_carte.php?id=<?php echo $myrow["id_carte"]?>" class="button butong">Detalii</a>
                </div>
            </div>

            <?php
            } else {
            ?>

            <div class="grid-x">
                <div class="cell medium-4 small-6 animatie">
                  <a href="pagina_lucrare.php?id=<?php echo $myrow["id_carte"]?>"><img src="img/<?php echo $myrow["poza_coperta"]?>" style="max-height: 200px; border-radius: 10px"></a>
                </div>
                <div class="cell medium-8 small-6">
                  <h5 class="culoare-scris"><?php echo $myrow["titlu"]?></h5>
                  <br>
                  <pre class="culoare-scris" style="padding-bottom:10px"><a href="pagina_client.php"><img src="img/<?php echo $myrow["poza_profil"]?>" style="width:30px;" class="rotund">  <?php echo $myrow["nume"]?></a></pre>
                  <p class="culoare-scris"><?php echo $total_stele?> <i class="fa-solid fa-star"></i></p>
                  <p class="culoare-scris" style="font-size: small;"><?php echo $myrow["status"]?></p>
                  
                  <?php
                  $raportat = mysqli_query($con,"SELECT DISTINCT id_notificare FROM notificari WHERE actiune=6 AND pentru_carte='$carte'");

                  if(mysqli_num_rows($raportat) > 0)
                  {
                  ?>

                  <p style="background-color:tomato; padding:5px; color:white; border-radius:5px; width:90px">Raportata</p>
              
                  <?php
                  } else {
                  ?>

                  <?php
                  }
                  ?>

                </div>
            </div>

            <?php
            }
            ?>

          </div>
        </div>
       
      <?php
        
      }
      ?>

    </div>
  </div>
</div>

<?php
  } else {
?>

<div class="grid-container" style="padding-top: 200px; padding-left: 40px; padding-right: 40px;">
  <div class="grid-x">
      <div class="float-center" style="width: 500px; height: 650px">
        <h3 class="text-center culoare-scris-nimic">Nu s-au gasit carti cu acest titlu!</h3>
        <br>
        <br>
      </div>
  </div> 
</div>

<?php
  }
?>



<?php include('footer.php') ?>