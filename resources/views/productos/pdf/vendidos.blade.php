<!DOCTYPE html>
<html lang="es">
	<head>
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<title>Productos vendidos</title>

		<!-- Bootstrap CSS -->
		<link rel="stylesheet" href="{{ asset('templates/atlantis/assets/css/bootstrap.min.css') }}">

		<!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
		<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
		<!--[if lt IE 9]>
			<script src="https://oss.maxcdn.com/libs/html5shiv/3.7.2/html5shiv.min.js"></script>
			<script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
		<![endif]-->

		<style type="text/css">
			thead { display: table-header-group; }
			tfoot { display: table-row-group; }
			tr { page-break-inside: avoid; }
		</style>
	</head>
	<body>

		@php
			$sum_importe = 0;
			$sum_vendidos = 0;
			$sum_comision = 0;
		@endphp

		<table class="table table-hover" style="margin-bottom: -25px;" bordercolor="#FFFFFF">
			<tbody>
				<tr>
					<td style="width: 90%;">
						<b style="font-size: 24px;">
							Productos vendidos
						</b><br>
						{{ date('d/m/Y') }}
					</td>
					<td>
						<img src="{{ asset('img/icono.png') }}" class="img-responsive" style="max-width: 90px;" alt="Kleid">
					</td>
				</tr>
			</tbody>
		</table>

		<br>

		<table class="table table-condensed table-bordered">
			<thead>
				<tr>
					<th title="Código del sistema">C.S</th>
					<th>Nombre</th>
					<th>Género</th>
					<th>Importe</th>
					<th>Comisión</th>
					<th>Vendidos</th>
				</tr>
			</thead>
			<tbody>
				@foreach($productos as $producto)
					@php
						$total_pago = $producto->ventas()->sum('total_pago');
						$total_comision = $producto->ventas()->sum('total_comision');

						$sum_importe += $total_pago;
						$sum_comision += $total_comision;
						$sum_vendidos += $producto->ventas()->count();
					@endphp
					<tr>
						<td>{{ $producto->id }}</td>
						<td>{{ $producto->nombre }}</td>
						<td>{{ config('sistema.generos')[$producto->genero] }}</td>
						<td class="text-right">${{ number_format($total_pago,2,'.',',') }}</td>
						<td class="text-right">${{ number_format($total_comision,2,'.',',') }}</td>
						<td>{{ $producto->ventas()->count() }}</td>
					</tr>
				@endforeach

				<tr>
					<td colspan="3" class="text-center"><b>{{ $productos->count() }} productos diferentes</b></td>
					<td class="text-right"><b>${{ number_format($sum_importe,2) }}</b></td>
					<td class="text-right"><b>${{ number_format($sum_comision,2) }}</b></td>
					<td><b>{{ $sum_vendidos }}</b></td>
				</tr>
			</tbody>
		</table>

	</body>
</html>