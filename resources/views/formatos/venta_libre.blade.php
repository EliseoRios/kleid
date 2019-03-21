<!DOCTYPE html>
<html lang="es">
	<head>
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<title>Venta libre</title>

		<!-- Bootstrap CSS -->
		<link rel="stylesheet" href="{{ asset('templates/atlantis/assets/css/bootstrap.min.css') }}">

		<!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
		<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
		<!--[if lt IE 9]>
			<script src="https://oss.maxcdn.com/libs/html5shiv/3.7.2/html5shiv.min.js"></script>
			<script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
		<![endif]-->
	</head>
	<body>

		<h3 class="page-header text-center">
			<img src="{{ asset('img/icono.png') }}" class="img-responsive pull-left" style="max-width: 70px;" alt="Image">
			<b class="text-center" style="margin-left: 180px; margin-right: 180px;">Formato de venta manual</b>
			<img src="{{ asset('img/icono.png') }}" class="img-responsive pull-right" style="max-width: 90px;" alt="Image">
		</h3>
		<br>

		<table class="table table-condensed table-bordered">
			<thead>
				<tr>
					<th style="width: 250px;">Cliente</th>
					<th>C.S.</th>
					<th>Pzas</th>
					<th>Efectivo</th>
					<th>Tipo</th>
					<th>Fecha</th>
					<th style="width: 5px;">L</th>
					<th style="width: 5px;">E</th>
					<th style="width: 5px;">C.R.</th>
					<th style="width: 5px;">D</th>
				</tr>
			</thead>
			<tbody>
				@for($i=0;$i<38;$i++)
				<tr>
					<td></td>
					<td></td>
					<td></td>
					<td></td>
					<td></td>
					<td></td>
					<td></td>
					<td></td>
					<td></td>
					<td></td>
				</tr>
				@endfor
			</tbody>
		</table>

		<br>

		<b>C.R:</b> Comisión recibida. &nbsp;&nbsp;&nbsp;&nbsp;
		<b>C.S:</b> Código del sistema. &nbsp;&nbsp;&nbsp;&nbsp;
		<b>Tipo:</b> Venta/Abono. <br>		 
		<b>E:</b> Entregado. &nbsp;&nbsp;&nbsp;&nbsp;
		<b>D:</b> Digitalizado. &nbsp;&nbsp;&nbsp;&nbsp;
		<b>L:</b> Liquidado. 

	</body>
</html>