<?php   
    use PHPMailer\PHPMailer\PHPMailer;
    require "./vendor/autoload.php";
    $mail = new PHPMailer();
    $mail->IsSMTP();
    // cambiar a 0 para no ver mensajes de error
    // cambiar a 2 para ver la traza
    $mail->SMTPDebug  = 0;                          
    $mail->SMTPAuth   = true;
    $mail->SMTPSecure = "tls";                 
    $mail->Host       = "smtp.gmail.com";    
    $mail->Port       = 587;                 
    // introducir usuario de google
    $mail->Username   = "elpatronsupp@gmail.com"; 
    // introducir clave
    $mail->Password   = "qbzyypfssokhgwyo";       
    $mail->SetFrom('elpatronsupp@gmail.com', 'Soporte-no-Contestar');
    // asunto
    $mail->Subject   = "Verifique su dirección de correo electrónico";
    // cuerpo
    $mail->MsgHTML(file_get_contents('./mail/verificamail.html')); 
    // adjuntos
    // $mail->addAttachment("adjunto.txt");
    // destinatario
    $address = $_GET['adrr'];
    $mail->AddAddress($address, "Estimado cliente");
    // enviar
    $resul = $mail->Send();
    if(!$resul) {
      echo "Error" . $mail->ErrorInfo;
    } else {
      echo "Enviado";
      # Lo redireccionamos a la página principal
      header("Location:?menu=inicio");
    }
