<!DOCTYPE html>
<html lang="es">
	<head>
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<title>Estado de cuenta de {{ $cliente->nombre }}</title>

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

		<table class="table table-hover" style="margin-bottom: -25px;" bordercolor="#FFFFFF">
			<tbody>
				<tr>
					<td style="width: 90%;">
						<b style="font-size: 24px;">
							Estado de cuenta <br>

							<small>{{ $cliente->nombre }}</small>
						</b><br>
						{{ date('d/m/Y') }}
					</td>
					<td>
						<img src="{{ asset('img/icono.png') }}" class="img-responsive" style="max-width: 90px;" alt="Image">
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
					<th>Costo</th>
					<th>Vencimiento</th>
				</tr>
			</thead>
			<tbody>
				@foreach($ventas_sin_liquidar as $venta)
					@php
						$producto = $venta->producto;
					@endphp

					<tr>
						<td>{{ $producto->id }}</td>
						<td>{{ $producto->nombre }}</td>
						<td>{{ config('sistema.generos')[$venta->producto->genero] }}</td>
						<td class="text-right">${{ number_format($venta->pago,2,'.',',') }}</td>
						<td class="text-{{ ($venta->fecha_plazo < date('Y-m-d'))?'danger':'primary' }}" style="font-weight: bold;">{{ date('d/m/Y', strtotime($venta->fecha_plazo)) }}</td>
					</tr>
				@endforeach
			</tbody>
		</table>

		<table class="table table-sm table-hover">
		  <tbody>
		    <tr>
		      <th>Sin liquidar</th>
		      <td class="text-right">${{ number_format($cliente->suma_sin_liquidar,2,'.',',') }}</td>
		    </tr>
		    @if ($cliente->a_favor > 0)
		    <tr>
		      <th>Saldo a favor</th>
		      <td class="text-right">${{ number_format($cliente->a_favor,2,'.',',') }}</td>
		    </tr>
		    @endif
		    <tr>
		      <th>Total adeudo</th>
		      <td class="text-right">${{ number_format(($cliente->adeudo > 0)?$cliente->adeudo:0,2,'.',',') }}</td>
		    </tr>
		  </tbody>
		</table>

	</body>
</html>