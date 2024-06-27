<br><br>
<h1>Bienvenido a mi lista de oficios</h1>
    <section>
        <?php
            $response = json_decode(file_get_contents('http://localhost/terminado/api/productos/api-productos.php?categoria=3'), true);
            if($response['statuscode'] == 200){
                foreach($response['items'] as $item){
                    ?>
                    <div class="articulo">
                    <input type="hidden" id="id" value="<?php echo $item['id']; ?>">
                    <div class="imagen"><img src="img/producto/<?php echo $item['imagen']; ?>"></div>
                    <div class="titulo"><?php echo $item['nombre']; ?></div>
                    <div class="descripcion"><?php echo $item['descripcion']; ?></div>
                    <div class="precio">$<?php echo $item['precio']; ?></div>
                    <div class="stock">stock:<?php echo $item['stock']; ?>Unid.</div>
                    <div class='botones'><button class='btn-add'>Agregar Oficio</button></div>
                </div>
                <?php
                }
            }
        ?>
        
        </section>
