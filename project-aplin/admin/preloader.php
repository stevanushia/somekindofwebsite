<?php
    if (!isset($_SESSION["admin"]))
    {    
?>
    <div class="preloader flex-column justify-content-center align-items-center">
        <img class="animation__wobble" src="../assets/logo.png" alt="AdminLTELogo" height="60" width="60">
    </div>
<?php
        $_SESSION["admin"] = "ada";
    };
?>

