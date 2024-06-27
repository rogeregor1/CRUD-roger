<div class="articulo">
   
    <input type="hidden" id="id" value="<?php echo $item['id']; ?>">
    <div class="foto"><img src="img/producto/<?php echo $item['imagen']; ?>"></div>
    <div class="user"><?php echo $item['user_nom']; ?> <?php echo $item['user_apel']; ?></div>
    <div class="serv"><?php echo $item['service']; ?></div>
    <div class="cate"><?php echo $item['category']; ?></div>
    <div class="stat"><?php echo $item['estado']; ?></div>
    <div class='botones'><button class='btn-add'>Agregar al carrito</button></div>
   
</div>