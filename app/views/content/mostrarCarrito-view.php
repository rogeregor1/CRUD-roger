<?php
include_once "app/controllers/carrito.php";
?>
<br><br>
<h3>Lista del Carrito</h3>
<?php if(!empty($_SESSION['CARRITO'])) { ?>

    <table class="table table-light-bordered">
        <thead>
            <tr>
                <th with="%20" class="text-center">#</th>
                <th with="%20" class="text-center">Tecnico</th>
                <th with="%15" class="text-center">Servicio</th>
                <th with="%10" class="text-center">precio/€</th>
                <th with="%10" class="text-center">Cantidad</th>
                <th with="%20" class="text-center">subTotal/€</th>
                <th with="%5" class="text-center">Accion</th>
            </tr>
        </thead>
        <tbody>    
            <?php $total = 0; ?>
            <?php foreach($_SESSION['CARRITO'] as $indice => $producto) { ?>
                <tr>
                    <td with="%20" class="text-center"><?php echo $producto['ID'] ?></td>
                    <td with="%20" class="text-center"><?php echo $producto['USER'] ?></td>
                    <td with="%15" class="text-center"><?php echo $producto['SERVICE']; ?></td>
                    <td with="%10" class="text-center">€<?php echo $producto['PRECIO'] ?></td>
                    <td with="%10" class="text-center"><?php echo $producto['CANTIDAD'] ?></td>
                    <td with="%20" class="text-center">€<?php echo number_format($producto['PRECIO']*$producto['CANTIDAD'], 2); ?></td>
                    <td with="%5" align="right">
                        <form action="" method="post">

                            <input type="hidden" name="id" value="<?php echo openssl_encrypt($producto['ID'], COD, KEY); ?>" />
                            <input type="hidden" name="cantidad" value="<?php echo openssl_encrypt($producto['CANTIDAD'], COD, KEY); ?>" />
                            <button class="btn btn-danger" type="submit" name="btnAccion" value="Eliminar">Eliminar</button>
                        </form>
                    </td>
                </tr>
                <?php $total = $total + ($producto['PRECIO']*$producto['CANTIDAD']); ?>
            <?php } ?>
            <tr>
                <td colspan="3" align="right"><h3>Total</h3></td>
                <td align="right"><h3>€<?php echo number_format($total, 2); ?></h3></td>
                <td></td>
            </tr>
            <tr>
                <td colspan="5">
                    <form action="pagar.php" method="post">
                        <div class="alert alert-success">

                            <div class="form-group">
                                <label for="my-input" class="form-label">Correo de Contacto</label>
                                <input id="my-input" name="email" type="email" class="form-control" placeholder="Escribe tu correo..." required>
                            </div>
                            <small id="emailHelp" class="form-text text-muted">
                                Los productos se enviaran a este correo</small>
                        </div>
                        <button class="btn btn-primary btn-lg btn-block" name="btnAccion" type="submit" value="Proceder">Proceder a Pagar >></button>
                    </form>
                </td>
            </tr>
        </tbody>
    </table>
<?php } else { ?>
    <div class="alert alert-success">
        No hay Productos en el carrito...
    </div>
<?php } ?>
<?php include 'templates/pie.php'; ?>