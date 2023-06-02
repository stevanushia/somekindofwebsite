<?php
    ini_set('display_errors', '1');
    ini_set('display_startup_errors','1');
    error_reporting(E_ALL);
  
    use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\Exception;
    use PHPMailer\PHPMailer\SMTP;
    use Hidehalo\Nanoid\Client;

    load_config();

    if(isset($_POST["to-login"]))
    {
        if (isset($_SESSION["logged"])) {
            unset($_SESSION["logged"]);
            header('Location: index.php');
        }
        else{
            header('Location: login.php');
        }
    }

    if(isset($_POST["profile-clicked"])){

        if (isset($_SESSION["logged"])) {
            header('Location: profile.php');
        }
        else{
            $_SESSION['profileMsg'] = "You need to login to access this feature!";
            header('Location: index.php');
        }
    }

    if(isset($_POST["to-register"]))
    {
        header('Location: register.php');
    }

    if(isset($_POST["logging-in"]))
    {
        $username = $_POST["login_user"];
        $password = $_POST["login_pass"];
        if ($username == "admin" && $password == "admin")
        {
            header('Location: ../admin/index.php');
        }
        else if ($username == "" || $password == "")
        {
            $_SESSION['errMsg'] = "Field cannot be empty";
            header('Location: login.php');
        }
        else {
            $user = Users::logging($username, $password);  

            if ($user) {
                $_SESSION['okMsg'] = "Welcome, " . $username . "!";
                $_SESSION["logged"] = Users::logging($username, $password);
                
                header('Location: index.php');
                die();
            }
            else{
                $_SESSION['errMsg'] = "Username / password tidak ada ";
                header('Location: login.php');
            }
        }
    }

    if(isset($_POST["registering"]))
    {
        $username = $_POST["regis_user"];
        $email = $_POST["regis_email"];
        $password = $_POST["regis_pass"];

        if ($username == "" || $email == "" || $password == "")
        {
            $_SESSION['errMsg'] = "Field cannot be empty";
            header('Location: login.php');
            die();
        }

        if ($password != $_POST["regis_confirm"])
        {
            $_SESSION['errMsg'] = "Confirmation Fail";
            header('Location: login.php');
            die();
        }

        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $_SESSION['errMsg'] = "Invalid email format";
            header('Location: login.php');
            die();
        }

        if (Users::checkTaken($username) || Confirmation::cekNamaAda($username)) {
            $_SESSION['errMsg'] = "Username sudah terdaftar";
            header('Location: login.php');
            die();
        }

        if(Users::cekEmailAda($email) || Confirmation::cekEmailAda($email))
        {
            $_SESSION['errMsg'] = "Email sudah terdaftar";
            header('Location: login.php');
            die();
        }
        
        $nanoid = new Client();
        $encryption = $nanoid->generateId();

        $mail = new PHPMailer();
        $confirmationLink = "Kelompok1-VideoOnDemand/view/confirm_email.php?code=".$encryption;

        $baseURL = 'http://localhost'; 
        $link = $baseURL . '/' . $confirmationLink;

        
        try {
            $mail->isSMTP();                         
            $mail->Host       = 'tls://smtp.gmail.com:587';   
            $mail->Username   = SMTP_EMAIL;   
            $mail->Password   = SMTP_PASS;  
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;      
            $mail->SMTPAuth = true;

            $mail->setFrom(SMTP_EMAIL);
            $mail->addAddress($email);        
            // $mail->SMTPDebug = 2;

            $mail->isHTML(true);                    
            $mail->Subject = 'VOD Streaming - Confirm your email address';
            $mail->Body    = "Hello, dear customer. <br><img src='https://i.imgur.com/JyamFdr.png'><br>Please click the following link to confirm your email address:<br><br><a href='$link'>$link</a><br><br>Thank you!";
            $mail->AltBody = 'Please confirm your email address by visiting this link: ' . $link;

            $mail->send();
            $_SESSION["okMsg"] = "Email sent!";
            $_SESSION["txtMsg"] = "Please confirm your email address.";
        
            Confirmation::insert($username, $email, $password, $encryption);

        } catch (Exception $e) {

            echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
        }

        // $_SESSION['msg'] = "Berhasil register " . $username . " Check your email for confirmation.";
        header('Location: login.php');
        die();
    }
