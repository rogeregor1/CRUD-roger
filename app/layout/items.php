<div class="articulo">
    <h1>Aqui estara la table de oficio y precios</h1>
    <input type="hidden" id="id" value="<?php echo $item['id']; ?>">
    <div class="imagen"><img src="img/producto/<?php echo $item['imagen']; ?>"></div>
    <div class="titulo"><?php echo $item['nombre']; ?></div>
    <div class="descripcion"><?php echo $item['descripcion']; ?></div>
    <div class="precio">$<?php echo $item['precio']; ?></div>
    <div class="stock">stock:<?php echo $item['stock']; ?>Unid.</div>
    <div class='botones'><button class='btn-add'>Agregar al carrito</button></div>
</div>