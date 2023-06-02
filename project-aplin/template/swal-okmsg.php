<?php
    if (isset($_SESSION['okMsg'])) {
        $msg = $_SESSION['okMsg'];
?>
    <script>
        Swal.fire({
            title: "<?= $msg ?>",
            text: "Enjoy your Video Demands!",
            icon: "success",
            button: "Continue"
        });
    </script>
<?php
    unset($_SESSION['okMsg']); 
}

    if (isset($_SESSION['profileMsg'])) {
        var_dump($_SESSION['profileMsg']);
        $msg = $_SESSION['profileMsg'];
?>
    <script>
        Swal.fire({
            icon: 'error',
            title: 'Oops...',
            text: '<?= $msg ?>',
            footer: '<a href="login.php">Log In?</a>'
        })
    </script>
<?php
    unset($_SESSION['profileMsg']); 

    }

    if(isset($datediff)) {
        if($datediff < 8){
            ?>
            <script>
                Swal.fire({
                    title: 'Subscription is Ending',
                    text: 'You have <?= $datediff?> days left until your subscription ends. Would you like to renew your subscription?',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'Renew now',
                    cancelButtonText: 'Maybe Next Time',
                    reverseButtons: true
                }).then((result) => {
                    if (result.isConfirmed) {
                        window.location.href = "payment.php"; // Submit the form
                    }
                });
            </script>
            <?php
        }
    }
?>