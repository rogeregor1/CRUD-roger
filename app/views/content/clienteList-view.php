<div class="container is-fluid mb-6">
	<h1 class="title">Cliente</h1>
	<h2 class="subtitle">Lista de clientes</h2>
</div>
<div class="container pb-6 pt-6">

	<div class="form-rest mb-6 mt-6"></div>

	<?php
		use app\controllers\clienteController;

		$insCliente = new clienteController();

		echo $insCliente->listarClienteControlador($url[1],15,$url[0],"");
	?>
</div>