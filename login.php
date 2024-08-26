<?php 
include('header.php');
include('navbar.php'); 
?>

<script>
    function check_email() {
        email=document.formular.email;
        parola=document.formular.parola;

        if (email.value === '') {
            Eroare(email, 'Trebuie sa introduci email-ul');
            return false;
        } else {
            Succes(email);
        }

        if (parola.value === '') {
            EroareParola(parola, 'Trebuie sa introduci parola');
            return false;
        } else {
            SuccesParola(parola);
        }
    }  
    
    function Eroare(input, mesaj){
        const formControl = input.parentElement;
        formControl.classList.add("eroare");
        const small = formControl.querySelector('small');
        small.innerText = mesaj;
    }

    function EroareParola(input, mesaj){
        const formControl = input.parentElement.parentElement;
        formControl.classList.add("eroare");
        const small = formControl.querySelector('small');
        small.innerText = mesaj;
    }

    function Succes(input){
        const formControl = input.parentElement;
        formControl.classList.remove("eroare");
    }

    function SuccesParola(input){
        const formControl = input.parentElement.parentElement;
        formControl.classList.remove("eroare");
    }
</script>

<div class="fundal-gradient">  <!--design-->



<!--login-->

        <?php if(isset($_SESSION['mesaj'])) { ?>
        <div class="callout" data-closable="slide-out-left" style="border-radius:10px; border-color: rgb(124, 61, 179); position:fixed; margin-top:5px; margin-left:5px;">
            <button class="close-button" aria-label="Dismiss alert" type="button" data-close>
                <span aria-hidden="true">&times;</span>
            </button> 
            
            <p style="padding-right: 30px; color:rgb(124, 61, 179)"><?= $_SESSION['mesaj'];?></p>
            
        </div> 
        <?php } unset($_SESSION['mesaj']); ?>
         
<br>
<br>
<br>
<br>
<br>
<div class="grid-container" style="padding-left: 40px; padding-right: 40px;">
<div class="grid-x">
    <div class="float-center" style="width: 500px; height: 650px">
        <form name="formular" action="useradd.php" method="POST" onsubmit="return check_email(this);">
            <h3 style="color: white;"><b>Autentificare</b></h3>  
                
                <br>
                <div class="form-control">
                    <input type="text" name="email" placeholder="Introdu emailul" class="cauta" maxlength="30">
                    <small>Mesaj de eroare</small>
                </div>

                <div class="form-control">
                    <div class="parola-container">
                        <input type="password" name="parola" placeholder="Introdu parola" class="password cauta" maxlength="20">
                        <i class="fa-solid fa-eye-slash vizibilitate" title="Arata parola"></i>
                    </div>
                    <small>Mesaj de eroare</small>
                </div>

                <button type="submit" name="login_btn" class="button expanded butong"><b>OK</b></button>
                <div style="color: white;">Nu ai cont?   <a href="register.php" class="link">Inregistrare</a></div>  
        <form> 
    </div>
</div> 
</div>

<!--sfrasit login-->

<?php include('footer.php'); ?>
</div>