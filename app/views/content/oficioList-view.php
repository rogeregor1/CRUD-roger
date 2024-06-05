<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <link rel="stylesheet" href="css/main.css">
</head>
<body>
    <section>
    <?php
        include_once('layout/menu.php');
    ?>
    </section>
    <section>
        <?php
            $response = json_decode(file_get_contents('http://localhost/terminado/api/productos/api-productos.php?categoria=3'), true);
            if($response['statuscode'] == 200){
                foreach($response['items'] as $item){
                    include('layout/items.php');
                }
            }
        ?>
        
        </section>

    <script src="js/main.js"></script>
</body>
</html>