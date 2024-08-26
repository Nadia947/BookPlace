<?php 
require_once("connection.php"); 
include('securitateu.php')
?>
<?php include('header.php')?>

<!--cod php de modificare-->
<?php
$result = mysqli_query($con,"SELECT * FROM carti, categorii, drepturi WHERE id_carte='" . $_GET['id'] . "' AND carti.drept=drepturi.id_drept AND carti.categorie=categorii.id_categorie");
$row= mysqli_fetch_array($result);

if(isset($_POST['creaza_btn'])) {

    if($_FILES['poza_coperta']['name'] == NULL){
        $poza_coperta = $row['poza_coperta'];
    } else {
        $poza_coperta = time(). '_' . $_FILES['poza_coperta']['name'];
        $target = 'img/' .$poza_coperta;
        move_uploaded_file($_FILES['poza_coperta']['tmp_name'], $target); 
    }

    mysqli_query($con,"UPDATE carti set poza_coperta='$poza_coperta', titlu='" . mysqli_real_escape_string($con, $_POST['titlu']) . "' , descriere='" . mysqli_real_escape_string($con, $_POST['descriere']) . "' , categorie='" . $_POST['categorie'] . "', public='" . $_POST['public'] . "', drept='" . $_POST['drepturi'] . "', status='" . $_POST['status'] . "' WHERE id_carte='" . $_GET['id'] . "'");
    ?>

    <script>window.history.back();</script>

    <?php
    }

    if(isset($_POST['schimba'])) {
        $poza_coperta = $_SESSION["poza_profil"];
        mysqli_query($con,"UPDATE carti set poza_coperta='$poza_coperta' WHERE id_carte='" . $_GET['id'] . "'");
        ?>

        <script>window.history.refresh()</script>

        <?php
    }


$categorii = mysqli_query($con,"SELECT * FROM categorii");

$drepturi = mysqli_query($con,"SELECT * FROM drepturi");
?>
<!--cod php de modificare-->

<!--bara de sus-->
<div data-sticky-container>
<div class="sticky sticky-topbar bordura-nav" data-sticky data-options="anchor: page; marginTop: 0; stickyOn: small;">

        <div class="title-bar" data-responsive-toggle="responsive-menu" data-hide-for="medium"> 
            <div class="title-bar-title" style="width: 100%;">
                <ul class="menu horizontal">
                    <li style="padding-right: 10px;"><a href="scrie.php"><i class="fa-solid fa-angle-left fa-2x"></i></a></li>
                    <li style="padding-top: 13px;"><b><h5 class="culoare-scris"><?php echo $row['titlu']; ?></h5></b></li>
                    <li style="display: none;"><img src="img/moon.png" id="icon" class="iconita" style="cursor: pointer; width: 25px;"></li>
                </ul>
            </div>
        </div> 

        <div class="top-bar" id="responsive-menu">
            <div class="top-bar-left">
                <ul class="menu">
                    <li style="padding-right: 10px;"><a href="scrie.php"><i class="fa-solid fa-angle-left fa-2x"></i></a></li>
                    <li style="padding-top: 13px;"><b><h5 class="culoare-scris"><?php echo $row['titlu']; ?></h5></b></li>
                    <li style="display: none;"><img src="img/moon.png" id="icon" class="iconita" style="cursor: pointer; width: 25px;"></li>
                </ul>  
            </div>
        </div>

    </div>
</div>
<!--bara de sus-->

<div style="background-image: url(img/fundal_modifica_carte.svg); background-repeat:no-repeat;">

<!--grid pentru formular de modificare carte-->
<div class="grid-container" style="padding-bottom: 75px; padding-top:25px;">
    <div class="grid-x grid-margin-x small-up-1 medium-up-2">
 
        <div class="cell" style="width: 400px; padding-top: 68px; padding-bottom: 100px;">
            <form action="" method="POST" enctype="multipart/form-data" name="modifica_carte" onsubmit="return verifica_modificari(this);">   
            <div style="padding-bottom: 50px;"> 
                <img title="Schimba poza" src="img/<?php echo $row['poza_coperta']?>" onclick="selectareImagine()" id="file_img" style="max-height: 300px; border-radius: 10px; cursor:pointer" class="float-center">
            </div>    
                <input onchange="arataImagine(this)" type="file" accept="image/jpeg" name="poza_coperta" id="file" style="display: none;">
                <button type="submit" name="schimba" class="button butong float-center"><b>Elimina poza</b></button>
            </div>
        
        <div class="cell">

            <button id="btn_detalii" onclick="ascundeCapitole();" type="button" class="butoncard button active">Detalii carte</button>
            <button id="btn_capitole" onclick="ascundeDetalii();" type="button" class="butoncard button float-right">Capitole</button>

            
            <div id="detalii" class="card culoare-card culoare-umbra-cell" style="height:auto; padding: 25px; border-color: grey;">

                    <button type="submit" name="creaza_btn" class="button butonok" style="width: 100px;">Salveaza</button>
                    
                <div>
                    <hr>
                    <label class="culoare-scris"><b>Titlu</b></label>
                    <div class="form-control">
                        <input type="text" name="titlu" value="<?php echo $row['titlu']; ?>" class="cauta" style="border-radius: 10px;" maxlength="50">
                        <small>Mesaj de eroare</small>
                    </div>

                    <label class="culoare-scris"><b>Descriere</b></label>
                    <div class="form-control">
                        <textarea name="descriere" rows="7" cols="40" class="cauta" style="border-radius: 10px; resize:none" maxlength="1000"><?php echo $row['descriere']; ?></textarea>
                        <small>Mesaj de eroare</small>
                    </div>
                    
                    <label class="culoare-scris"><b>Categorie</b></label>
                    <select name="categorie" class="cauta" style="color: lightgrey; border-radius: 10px;">
                        <option value="<?php echo $row['id_categorie']; ?>" disable selected hidden><?php echo $row['denumire_categorie']; ?></option>
                        
                        <?php
                        while ($cat=mysqli_fetch_array($categorii,MYSQLI_ASSOC)) 
                        {
                        ?>
                        
                        <option value="<?php echo $cat['id_categorie']; ?>"><?php echo $cat['denumire_categorie']; ?></option>

                        <?php
                        }
                        ?> 

                    </select>

                    <label class="culoare-scris"><b>Public</b></label>
                    <select name="public" class="cauta" style="color: lightgrey; border-radius: 10px;">
                        <option value="<?php echo $row['public']; ?>" disable selected hidden><?php echo $row['public']; ?></option>
                        <option value="Toate tipurile de varsta">Toate tipurile de varsta</option>
                        <option value="Sub 18 ani">Sub 18 ani</option>
                        <option value="Peste 18 ani">Peste 18 ani</option>
                    </select>

                    <label class="culoare-scris"><b>Drepturi de autor</b></label>
                    <select name="drepturi" class="cauta" style="color: lightgrey; border-radius: 10px;">
                        <option value="<?php echo $row['id_drept']; ?>" disable selected hidden><?php echo $row['denumire_drept']; ?></option>
                        
                        <?php
                        while ($dre=mysqli_fetch_array($drepturi,MYSQLI_ASSOC)) 
                        {
                        ?>
                    
                        <option value="<?php echo $dre['id_drept']; ?>"><?php echo $dre['denumire_drept']; ?></option>

                        <?php
                        }
                        ?>

                    </select>

                    <label class="culoare-scris"><b>Status poveste</b></label>
                    <select name="status" class="cauta" style="color: lightgrey; border-radius: 10px;">
                        <option value="<?php echo $row['status']; ?>" disable selected hidden><?php echo $row['status']; ?></option>
                        <option value="In curs de scriere" style="color: black;">In curs de scriere</option>
                        <option value="Finalizata" style="color: black;">Finalizata</option>
                    </select>   
                </div> 
                </form> 
            </div>

          
            <div id="capitole" class="card culoare-card culoare-umbra-cell ascuns" style="height:auto; padding: 25px; border-color: grey;">
                
            <?php
            $rezultat_capitole = mysqli_query($con,"SELECT * FROM carti, capitole WHERE id_carte=apartine_carte AND id_carte='" . $_GET['id'] . "'");

            if(mysqli_num_rows($rezultat_capitole) > 0){
            ?>
            
            <a href="adauga_capitol.php?id=<?php echo $_GET['id']?>"><button type="button" class="butonok button float-right">Capitol nou</button></a>
            
            <?php
            while ($myrow=mysqli_fetch_array($rezultat_capitole,MYSQLI_ASSOC)) 
            { 
            ?>
                
                <div>
                    <hr>
                    <h4 class="culoare-scris"><a href="modifica_capitol.php?id=<?php echo $myrow['id_capitol']?>"><?php echo $myrow["denumire"]?></a></h4>
                    <a onclick="javascript:return confirm('Sigur vrei sa stergi aceast capitol?');" href="sterge_capitol.php?id=<?php echo $myrow["id_capitol"];?>"><i class="fa-solid fa-trash-can float-right"></i></a>
                    <br>

                    <?php
                    $id_c=$myrow["id_capitol"];
                    $com=mysqli_query($con,"SELECT id_comentariu FROM comentarii WHERE apartine_capitol=$id_c");
                    $total_com=mysqli_num_rows($com);
                    ?>

                    <a href="vezi_comentarii.php?id_capitol=<?php echo $myrow["id_capitol"];?>&id_carte=<?php echo $myrow["id_carte"];?>" class="float-right"><?php echo $total_com?> comentarii</a>

                    <?php
                    if($myrow["publicat"]==1) {
                    $pub = "Publicat";
                    ?>

                    <p style="color: gray;"><?php echo $pub?></p>
                    <a href="publica_capitol.php?id=<?php echo $myrow["id_capitol"];?>" class="butong button float-right">Anuleaza publicarea</a>
                    
                    <?php
                    }
                    else {
                    $pub = "Ciorna";
                    ?>

                    <p style="color: gray;"><?php echo $pub?></p>
                    <a href="publica_capitol.php?id=<?php echo $myrow["id_capitol"];?>&id_carte=<?php echo $myrow["id_carte"];?>" class="butong button float-right">Publica</a>

                    <?php
                    }
                    ?>    
                    

                </div>   

            <?php
            }
            } else { 
            ?>

                <div>
                    <hr>
                    <h5 style="text-align: center; color:gray"><b>Nu sunt capitole</b></h5>
                    <br>
                    <a href="adauga_capitol.php?id=<?php echo $_GET['id']?>"><button type="button" class="butonok button float-center">Creaza capitol</button></a>
                    <hr>
                </div> 

            <?php
            }   
            ?>

            </div> 
     
        </div>
    </div>
</div>
<!--grid pentru formular de modificare carte-->

</div>

<!--cod pentru functionare butoane-->
<script>
   const div1 = document.querySelector('#detalii'); //luam div-ul cu id-ul detalii
   const div2 = document.querySelector('#capitole');
   const b1 = document.querySelector('#btn_detalii');
   const b2 = document.querySelector('#btn_capitole');

   if(localStorage.getItem("apasat") == null){ //daca inca nu s-a apasat butonul
   localStorage.setItem("apasat", "detalii"); //stocam datele pentru browser
   }

    let localDat = localStorage.getItem("apasat"); //va primi valoarea butonului

    if(localDat == "capitole"){  
        div1.style.display = 'none';
        div2.style.display = 'block';
        b1.classList.remove("active");
        b2.classList.add("active");
    }else if(localDat == "detalii"){
        div2.style.display = 'none';
        div1.style.display = 'block';
        b1.classList.add("active");
        b2.classList.remove("active");
    }

    let ascundeCapitole = function(){
        div2.style.display = 'none';
        div1.style.display = 'block';
        b1.classList.add("active");
        b2.classList.remove("active");
        localStorage.setItem("apasat", "detalii"); //stocam datele pentru browser
    }
    let ascundeDetalii = function(){
        div1.style.display = 'none';
        div2.style.display = 'block';
        b1.classList.remove("active");
        b2.classList.add("active");
        localStorage.setItem("apasat", "capitole"); //stocam datele pentru browser
    }
</script>

<!--cod pentru validarea formularului-->
<script>
    function verifica_modificari() {
        titlu = document.modifica_carte.titlu;
        descriere = document.modifica_carte.descriere;

        if (titlu.value === '') {
            Eroare(titlu, 'Titlul nu poate sa lipseasca');
            return false;
        } else if (titlu.value.length >= 50) {
            Eroare(titlu, 'Titlul nu poate depasi 50 de caractere');
            return false;
        } else {
            Succes(titlu);
        }

        if (descriere.value === '') {
            Eroare(descriere, 'Descriere nu poate sa lipseasca');
            return false;
        } else if (descriere.value.length >= 1000) {
            Eroare(descriere, 'Descrierea nu poate depasi 1000 de caractere');
            return false;
        } else {
            Succes(descriere);
        }
    }       
    
    function Eroare(input, mesaj){
        const formControl = input.parentElement;
        formControl.classList.add("eroare");
        const small = formControl.querySelector('small');
        small.innerText = mesaj;
    }

    function Succes(input){
        const formControl = input.parentElement;
        formControl.classList.remove("eroare");
    }
</script>

<?php include('footer.php') ?>