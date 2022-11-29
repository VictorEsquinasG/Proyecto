<?php   
    use PHPMailer\PHPMailer\PHPMailer;
    require "../vendor/autoload.php";
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
    $mail->Subject   = "El correo ha sido enviado";
    // cuerpo
    $mail->MsgHTML(file_get_contents('verificamail.html'),"C:/xampp/htdocs/Proyecto"); 
    // adjuntos
    // $mail->addAttachment("adjunto.txt");
    // destinatario
    $address = "viktoresquinas@gmail.com";
    $address1 = "dbarote0812@g.educaand.es";
    $mail->AddAddress($address, "YO");
    $mail->AddAddress($address1, "Daniel");
    // enviar
    $resul = $mail->Send();
    if(!$resul) {
      echo "Error" . $mail->ErrorInfo;
    } else {
      echo "Enviado";
    }
