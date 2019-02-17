{!! Form::open(array('action' => 'ApartadoController@apartar',"class" => "form")) !!}
<div class="modal-body">

	<div class="row">
		<div class="col-md-4">
			{{-- Caroucel --}}
			<div id="demo" class="carousel slide" data-ride="carousel">

				<!-- Indicators -->
				<ul class="carousel-indicators">
				  @foreach ($producto->imagenes()->get() as $index => $imagen)
				  <li data-target="#demo" data-slide-to="{{ $index }}" class="{{ ($index === 0)?'active':'' }}"></li>
				  @endforeach 
				</ul>

				<!-- The slideshow -->
				<div class="carousel-inner">
				  @foreach ($producto->imagenes()->get() as $index => $imagen)
				  <div class="carousel-item {{ ($index === 0)?'active':'' }}">
				    <img src="{{ url('imagen/'.$imagen->id) }}" style="width: 100%;" class="img-fluid" alt="Foto de producto">
				  </div>
				  @endforeach            
				</div>

				<!-- Left and right controls -->
				<a class="carousel-control-prev" href="#demo" data-slide="prev">
				  <span class="carousel-control-prev-icon"></span>
				</a>
				<a class="carousel-control-next" href="#demo" data-slide="next">
				  <span class="carousel-control-next-icon"></span>
				</a>

			</div>
			{{-- /Caroucel --}}
		</div>

		<div class="col-md-8">

			<h3 class="text-uppercase">{{ $producto->nombre }}</h3>

			<table class="table table-sm table-inverse table-hover">
				<tbody>
					<tr>
						<th>Genero</th>
						<td>{{ config('sistema.generos')[$producto->genero] }}</td>
					</tr>
					<tr>
						<th>Color</th>
						<td>{{ $producto->color }}</td>
					</tr>
					<tr>
						<th>Talla</th>
						<td>{{ $producto->talla }}</td>
					</tr>
				</tbody>
			</table>

			<div class="row">
			  <div class="form-group col-md-8" >
			    {!! Form::label('pago', 'Pago : ',['class'=>'control-label']) !!}

			    {!! Form::select('pago', $pagos, $producto->precio_minimo, ['class'=>'form-control','required']) !!}
			  </div>

			  <div class="form-group col-md-4" >
			    {!! Form::label('piezas', 'Piezas : ',['class'=>'control-label']) !!}

			    {!! Form::number('piezas', 1, array( 'class' => 'form-control', 'placeholder'=>'Piezas','min'=>1,'max'=>$producto->piezas,'required')) !!}
			  </div>
			</div>
			
		</div>
	</div>

	{!! Form::hidden('productos_id', $producto->id, ['style'=>'width: 0px;']) !!}
	{!! Form::hidden('clientes_id', $cliente->id, ['style'=>'width: 0px;']) !!}
</div>
<div class="modal-footer">
	<button type="button" class="btn btn-default" data-dismiss="modal"><i class="fas fa-times"></i>  Cerrar</button>
	<button type="submit" class="btn btn-primary" id="btnGuardar"><i class="fa fa-plus"></i> Agregar</button>
</div>
{!! Form::close() !!}

<script>
$(function(){
	$('#btnEditar').click(function(){
		$('.input-text').removeAttr('readonly');
		$('#btnGuardar').show();
	});
});
</script>