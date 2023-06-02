<?php
if (isset($_SESSION['msg'])) {
        $msg = $_SESSION['msg'];
?>
    <script>
        Swal.fire({
            icon: 'error',
            title: 'Oops...',
            text: '<?= $msg ?>',
        })
    </script>
<?php
    unset($_SESSION['msg']); 

    }

if(isset($_SESSION['success'])){
    ?>
    <script>
        Swal.fire({
            title: 'Update Success',
            icon: 'success',
            confirmButtonText: 'OK',
            reverseButtons: true
        }).then((result) => {
            console.log(result);
            if (result.isConfirmed) {
                console.log(document.getElementById('update1-form'));
                document.getElementById('update1-form').submit(); // Submit the form
            }
        });
    </script>
    <?php
    unset($_SESSION["success"]);
}
?>