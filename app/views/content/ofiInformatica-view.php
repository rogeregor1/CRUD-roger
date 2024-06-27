<!-- ALERTAS(todas las alertas) -->
<?php if ($mensaje != "") { ?>
  <div class="alert alert-success">
    <?php echo $mensaje; ?>
    <a href="mostrarCarrito.php" class="badge badge-success">Ver Carrito</a>
  </div>
<?php } ?>

<div class="contenido">

  <!-- CONTENEDOR DETALLES ITEM SELECCIONADO -->
  <div class="seleccion" id="seleccion">
    <div class="cerrar" onclick="cerrar()">&#x2715</div>
      <div class="info">
      <div class="img">
        <img id="img" alt="" src="<?php echo $item['img'] ?>">
      </div>
      <div class="card-body">
        <input type="hidden" id="id" value="<?php echo $item['id']; ?>">
        <h2 class="user" id="user"><?php echo $item['user']; ?></h2>
        <p class="category" id="cate"><?php echo $item['category']; ?></p>
        <span class="service" id="serv"><?php echo $item['service']; ?></span>
        <h4 class="estado" id="stat"><?php echo $item['estado']; ?></h4>
      </div>
    </div>
  </div>

  <!-- CONTENEDOR TODOS LOS ITEMS GET_API X CATEGORIA -->
  <div class="mostrador" id="mostrador">

    <div class="categoria">
      <?php
      $response = json_decode(file_get_contents('http://localhost/sat/api/asistencia/api-asistencia.php?category=5'), true);
      if ($response['statuscode'] == 200) {
        foreach ($response['items'] as $item) { ?>

          
            <div class="cards">
              <div class="item" onclick="cargar(this)">
                <img class="imagen" id="img" src="<?php echo APP_URL; ?>assets/img/<?php echo $item['foto']; ?>">

                <input type="hidden" id="id" value="<?php echo $item['id']; ?>">
                <div class="user" id="user"><?php echo $item['user_nom']; ?>     <?php echo $item['user_apel']; ?></div>
                <div class="category" id="cate"><?php echo $item['category']; ?></div>
                <div class="service" id="serv"><?php echo $item['service']; ?></div>
                <div class="estado" id="stat"><?php echo $item['estado']; ?></div>
              </div>

              <form class="FormularioAjax" action="<?php echo APP_URL; ?>app/ajax/carritoAjax.php" method="POST"
                autocomplete="off" enctype="multipart/form-data">
                <input type="hidden" name="modulo_carrito" value="carrito">

                <input type="hidden" name="id" id="id" value="<?php echo openssl_encrypt($item['id'], COD, KEY); ?>">
                <input type="hidden" name="user" id="user" value="<?php echo openssl_encrypt($item['user'], COD, KEY); ?>">
                <input type="hidden" name="category" id="category"
                  value="<?php echo openssl_encrypt($item['category'], COD, KEY); ?>">
                <input type="hidden" name="service" id="service"
                  value="<?php echo openssl_encrypt($item['service'], COD, KEY); ?>">
                <input type="hidden" name="precio" id="precio" value="<?php echo openssl_encrypt(100, COD, KEY); ?>">
                <input type="hidden" name="cantidad" id="cantidad" value="<?php echo openssl_encrypt(1, COD, KEY); ?>">
                <input type="hidden" name="estado" id="estado"
                  value="<?php echo openssl_encrypt($item['estado'], COD, KEY); ?>"><br><br>
                <button class="btn btn-primary" name="btnAccion" value="Agregar" type="submit">Agregar</button>
              </form>
            </div>
      

        <?php }
      }
      ?>
    </div>
  </div>
</div>