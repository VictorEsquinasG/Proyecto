<!DOCTYPE html>
<html lang="es-ES">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>El Patrón · Asociación de Radioafición · España</title>
    <script src="./js/nav.js"></script>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="./css/estilos.css">
</head>

<body>
    <?php
    require_once './Views/Principal/header.php';
    ?>
    <main>
        <section id="cuerpo">
            <?php
            require_once './Views/Principal/enruta.php';
            ?>
        </section>
    </main>

    <?php
    require_once './Views/Principal/footer.php';
    ?>
</body>
</html>