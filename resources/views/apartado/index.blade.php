@extends('layouts.layout')

@section('title')
	Sistema de apartado
@endsection

@section('header')
<div class="page-header">
	<h4 class="page-title">Apartados</h4>
	<ul class="breadcrumbs">
		<li class="nav-home">
			<a href="{{ url('/') }}">
				<i class="flaticon-home"></i> Inicio
			</a>
		</li>
		<li class="separator">
			<i class="flaticon-right-arrow"></i>
		</li>
		<li class="nav-item">
			<a><i class="fas fa-chalkboard-teacher"></i> Sistema de apartado</a>
		</li>
	</ul>
</div>
@endsection
 
@section('content')
<div class="col-md-12">
	<div class="card">
		<div class="card-header">
			<div class="d-flex align-items-center">
				<h4 class="card-title">Clientes</h4>

				@if (Auth::user()->permiso(array('menu',4002)) == 2) 
				<a href="" data-target="#modalNuevo" data-toggle="modal" class="btn btn-primary btn-round ml-auto" title="Agregar" style="color: white;">
				    <i class="fas fa-user-plus"></i>
				    Agregar cliente
				</a>
			    @endif
			</div>
		</div>
		<div class="card-body">
			
		    <!-- Listado de usuarios -->
		    <div class="table-responsive">
		    	<table id="dtusuarios" class="display table table-bordered table-striped table-hover small">  				                     
		    		<thead>
		    			<tr>		    				
		    				<th style="min-width:80px"></th>
		    				<th>Nombre</th>
		    				<th>Correo</th>
		    				<th>Adeudo</th>
		    			</tr>
		    		</thead>
		    		<tbody>
		    		</tbody>

		    	</table>
		    </div>
		  	<!-- /Listado de usuarios -->

		</div>
	</div>
</div>

<!-- Modal -->
<div class="modal fade" id="modalNuevo" role="dialog" aria-labelledby="modalNuevo">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header" style="background-color: #f5f5f5">
				<h4 class="modal-title" id="myModalLabel">Agregar cliente</h4>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
			</div>

			{!! Form::open(array('action' => 'ClientesController@guardar','class'=>'','role'=>'form')) !!}			

			<div class="modal-body">

				{!! Form::hidden('_token', csrf_token(),array('id'=>'token')) !!}

				<div class="form-group" >
					{!! Form::label('Nombre : ', null ,['class'=>'control-label']) !!}

					{!! Form::text('nombre','',array( 'class' => 'form-control', 'placeholder' => 'Nombre completo del usuario','autocomplete'=>'off','required')) !!} 
					<p class="text-danger">	{!! $errors->first('nombre')!!} </p>
				</div>	

				<div class="form-group">
					{!! Form::label('Correo :',null, ['class'=>'control-label']) !!}

					{!! Form::email('email','',array( 'class' => 'form-control','placeholder' => 'Correo electrónico','autocomplete'=>'off','required')) !!}
					<p class="text-danger">	{!! $errors->first('email')!!} </p>
				</div>

				<div class="form-group">
					{!! Form::label('Contraseña :', null, ['class'=>'control-label']) !!}

					{!! Form::text('password','',array( 'class' => 'form-control','placeholder' => '*******','autocomplete'=>'off','required')) !!}
					<p class="text-danger">	{!! $errors->first('password')!!} </p>
				</div>
			</div>

			<div class="modal-footer">
				<button type="button" class="btn bg-grey waves-effect" data-dismiss="modal"> 
					<i class="fa fa-times"></i>
					<span>Cancelar</span>
				</button>

				<button type="submit" class="btn btn-primary" id="grabar", secure = null>
					<i class="fa fa-save"></i>
					<span>Guardar</span>
				</button>
			</div>
			{!! Form::close()!!}
		</div>
	</div>
</div>

@endsection 

@section('script')

	<script type="text/javascript">

		$(function(){ 

		    @if ($errors->any())
	            $('#modalNuevo').modal('show');
		    @endif

		    $('#dtusuarios').DataTable({
	            processing: true,
	            serverSide: true,
	            ajax: "{!!URL::to('sistema_apartado/datatables')!!}",
	            columns: [
	                {data: 'id', name: 'id'},                
	                {data: 'nombre', name: 'nombre'},
	                {data: 'email', name: 'email'},
	                {data: 'adeudo', name: 'adeudo',render: $.fn.dataTable.render.number(',', '.', 2, '$')}
                ],
                order: [3,'DESC'],
	            language: {
	                "sProcessing":     "Procesando...",
					"sLengthMenu":     "Mostrar _MENU_ registros",
					"sZeroRecords":    "No se encontraron resultados",
					"sEmptyTable":     "Ningún dato disponible en esta tabla",
					"sInfo":           "Mostrando registros del _START_ al _END_ de un total de _TOTAL_ registros",
					"sInfoEmpty":      "Mostrando registros del 0 al 0 de un total de 0 registros",
					"sInfoFiltered":   "(filtrado de un total de _MAX_ registros)",
					"sInfoPostFix":    "",
					"sSearch":         "Buscar:",
					"sUrl":            "",
					"sInfoThousands":  ",",
					"sLoadingRecords": "Cargando...",
					"oPaginate": {
						"sFirst":    "Primero",
						"sLast":     "Ultimo",
						"sNext":     "Siguiente",
						"sPrevious": "Anterior"
					},
					"oAria": {
						"sSortAscending":  ": Activar para ordenar la columna de manera ascendente",
						"sSortDescending": ": Activar para ordenar la columna de manera descendente"
					} 
				}   
	            
	        });
		
		});

	</script>

@endsection