
    <section>
        <?php
            $response = json_decode(file_get_contents('http://localhost/terminado/api/productos/api-productos.php?categoria=3'), true);
            if($response['statuscode'] == 200){
                foreach($response['items'] as $item){
                    include(". APP_URL . 'app/layout/items.php'");
                }
            }
        ?>
    </section>
