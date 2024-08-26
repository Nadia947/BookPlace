<?php 
require_once("connection.php"); 
include('securitateu.php');
?>
<?php include('header.php')?>

<!--cod php de adaugare-->
<?php

if (isset($_POST['creaza_btn'])) { 
 
    
    if($_FILES['poza_coperta']['name'] == NULL){
        $poza_coperta = $_SESSION["poza_profil"];
    } else {
        $poza_coperta = time(). '_' . $_FILES['poza_coperta']['name'];
        $target = 'img/' .$poza_coperta;
        move_uploaded_file($_FILES['poza_coperta']['tmp_name'], $target);  
    }

    $titlu = $_POST["titlu"];
    $descriere =$_POST["descriere"];
    $categorie = $_POST["categorie"];
    $public = $_POST["public"];
    $drept = $_POST["drept"];
    $lecturi = '0';
    $publicata = '0';
    $status = "In curs de scriere";
    $apartine_utilizator = $_SESSION["id"];


    $sql="INSERT INTO carti(apartine_utilizator, poza_coperta, titlu, descriere, lecturi, categorie, public, drept, publicata, status) VALUES ('$apartine_utilizator','$poza_coperta','$titlu','$descriere','$lecturi','$categorie','$public','$drept','$publicata','$status')";
    $results= mysqli_query($con,$sql);

    if ($results) {
        
        header('Location: scrie.php');
    } else {
        
        header('Location: adauga_carte.php');
    }
}

$utilizator = $_SESSION["id"];

$categorii = mysqli_query($con,"SELECT * FROM categorii");

$drepturi = mysqli_query($con,"SELECT * FROM drepturi");
?>
<!--cod php de adaugare-->

<!--bara de sus-->
<div data-sticky-container>
<div class="sticky sticky-topbar bordura-nav" data-sticky data-options="anchor: page; marginTop: 0; stickyOn: small;">

    <form name="adauga_carte" action="" method="POST" enctype="multipart/form-data"  onsubmit="return verifica(this);">
        <div class="title-bar" data-responsive-toggle="responsive-menu" data-hide-for="medium"> 
            <div class="title-bar-title" style="width: 100%;">
                <ul class="menu horizontal">
                    <li style="padding-right: 10px;"><a onclick="window.history.back()" class="butong button">Renunta</a></li>
                    <li style="padding-right: 10px;"><button type="submit" name="creaza_btn" class="button medium butonok float-right">Creaza</button></li>
                    <li style="display: none;"><img src="img/moon.png" id="icon" class="iconita" style="cursor: pointer; width: 25px;"></li>
                </ul>
            </div>
        </div> 

        <div class="top-bar" id="responsive-menu">
            <div class="top-bar-left">
                <ul class="menu">
                    <li style="padding-right: 10px;"><a onclick="window.history.back()" class="butong button">Renunta</a></li>
                    <li style="padding-right: 10px;"><button type="submit" name="creaza_btn" class="button medium butonok float-right">Creaza</button></li>
                    <li style="display: none;"><img src="img/moon.png" id="icon" class="iconita" style="cursor: pointer; width: 25px;"></li>
                </ul>   
            </div>
        </div>

    </div>
</div>
<!--bara de sus-->

<div style="background-image: url(img/fundal_modifica_carte.svg); background-repeat:no-repeat;">

<!--grid pentru formular de adaugare carte-->
<div class="grid-container" style="padding-bottom: 75px; padding-top:25px">
    <div class="grid-x grid-margin-x grid-padding-x small-up-1 medium-up-2">
        
        <div class="cell">    
            <div class="card culoare-card culoare-umbra-cell" style="height:auto; padding: 25px; border-color: grey;"> 
                    
                    <h3 class="culoare-scris float-center">Imagine de coperta</h3><br>
                    <img onclick="selectareImagine()" id="file_img" src="img/<?php echo $_SESSION["poza_profil"]?>" style="height:300px; width: 200px; border-radius:10px; cursor:pointer" class="float-center">
                
                <input onchange="arataImagine(this)" type="file" accept=".jpg, .jpeg, .png" name="poza_coperta" id="file" style="display: none;">
                
            </div>
        </div>
        
        <div class="cell">
        <div class="card culoare-card culoare-umbra-cell" style="height:auto; padding: 25px; border-color: grey;">

            <div class="form-control">
                <input type="text" name="titlu" placeholder="Introdu titlul povestii" class="cauta" maxlength="50">
                <small>Mesaj de eroare</small>
            </div>   
               
            <div class="form-control">
                <textarea name="descriere" rows="7" cols="40" placeholder="Introdu o descriere" class="cauta" style="border-radius: 10px; resize:none" maxlength="1000"></textarea>
                <small>Mesaj de eroare</small>
            </div>

                <select name="categorie" class="cauta" style="color: lightgrey">
                    <option value="0" disable selected hidden>Alege o categorie</option>

                    <?php
                    while ($cat=mysqli_fetch_array($categorii,MYSQLI_ASSOC)) 
                    {
                    ?>
                        
                        <option value="<?php echo $cat['id_categorie']; ?>"><?php echo $cat['denumire_categorie']; ?></option>

                    <?php
                    }
                    ?> 

                </select>

                <select name="public" class="cauta" style="color: lightgrey">
                    <option value="Toate tipurile de varsta" disable selected hidden>Cine va citi cartea</option>
                    <option value="Toate tipurile de varsta">Toate tipurile de varsta</option>
                    <option value="Sub 18 ani">Sub 18 ani</option>
                    <option value="Peste 18 ani">Peste 18 ani</option>
                </select>

                <select name="drept" class="cauta" style="color: lightgrey">

                    <option value="0" disable selected hidden>Drepturi de autor</option>

                    <?php
                    while ($dre=mysqli_fetch_array($drepturi,MYSQLI_ASSOC)) 
                    {
                    ?>
                        
                        <option value="<?php echo $dre['id_drept']; ?>"><?php echo $dre['denumire_drept']; ?></option>

                    <?php
                    }
                    ?> 

                </select>
                
        </form> 
        </div>         
        </div>
    </div>
</div>

</div>

<script>
    function verifica() {
        titlu = document.adauga_carte.titlu;
        descriere = document.adauga_carte.descriere;

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