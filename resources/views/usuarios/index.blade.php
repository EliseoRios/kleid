@extends('layouts.layout')

@section('title')
	Usuarios
@endsection

@section('breadcrumb')
     <li><a href=""><i class="material-icons">home</i> Inicio</a></li>
     <li class="active"><i class="material-icons">people</i> Usuarios</li>
@endsection
 
@section('content')

<div class="card">
    <div class="header bg-cyan">
        <h2>
            Usuarios <small>Personal con acceso al sistema</small>
        </h2>
        <ul class="header-dropdown m-r--5">
            <li>
        		@if (Auth::user()->permiso(array('menu',9001)) == 2 ) 
        		<a href="" data-target="#modalNuevo" data-toggle="modal" class="btn bg-blue waves-effect" title="Agregar">
        		    <i class="material-icons">add_circle</i>
        		    <span>AGREGAR</span>
        		</a>
        	    @endif                
            </li>
        </ul>
    </div>
    <div class="body">

        <!-- Listado de usuarios -->
    	<div class="table-responsive">
          <table id="dtusuarios" class="table table-bordered table-striped table-hover dataTable js-exportable">  				                     
          <thead>
                  <tr>
                      
                      <th style="min-width:80px"></th>
                      <th>Nombre</th>
                      <th>Correo</th>
                      <th>Estatus</th>
                                             
                  </tr>
           </thead>
          <tbody>
          </tbody>
          </table>
      	</div>
      	<!-- /Listado de usuarios -->

    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="modalNuevo" role="dialog" aria-labelledby="modalNuevo">
	<div class="modal-dialog ">
		<div class="modal-content">
			<div class="modal-header" style="background-color: #f5f5f5">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<h4 class="modal-title" id="myModalLabel">Agregar Usuario</h4>
			</div>

			{!! Form::open(array('action' => 'UsuariosController@guardar','class'=>'','role'=>'form')) !!}			

			<div class="modal-body">

				{!! Form::hidden('_token', csrf_token(),array('id'=>'token')) !!}

				{!! Form::label('Nombre : ', null ,[]) !!}
				<div class="form-group" >
					<div class="form-line">
						{!! Form::text('nombre','',array( 'class' => 'form-control', 'placeholder' => 'Nombre completo del usuario')) !!} 
						<p class="text-danger">	{!! $errors->first('nombre')!!} </p>
					</div>
				</div>	

				{!! Form::label('Correo :',null, []) !!}
				<div class="form-group">
					<div class="form-line">
						{!! Form::email('email','',array( 'class' => 'form-control','placeholder' => 'Correo electrónico')) !!}
						<p class="text-danger">	{!! $errors->first('email')!!} </p>
					</div>
				</div>

				{!! Form::label('Contraseña :', null, []) !!}
				<div class="form-group">
					<div class="form-line">
						{!! Form::text('password','',array( 'class' => 'form-control','placeholder' => '*******')) !!}
						<p class="text-danger">	{!! $errors->first('password')!!} </p>
					</div>
				</div>
			</div>

			<div class="modal-footer">
				<button type="button" class="btn bg-grey waves-effect" data-dismiss="modal"> 
					<i class="material-icons" aria-hidden="true">cancel</i>
					<span>Cancelar</span>
				</button>

				<button type="submit" class="btn bg-blue waves-effect" id="grabar", secure = null>
					<i class="material-icons" aria-hidden="true" >save</i> 
					<span>Guardar</span>
				</button>

			</div>
			{!! Form::close()!!}
		</div>
	</div>
</div>

@endsection 

@section('script')

	@include('layouts.includes.datatables')

	<script type="text/javascript">

		$(function(){ 

		    @if ($errors->any())
	            $('#modalNuevo').modal('show');
		    @endif

		    $('#dtusuarios').DataTable({
	            processing: true,
	            serverSide: true,
	            ajax: "{!!URL::to('usuarios/datatables')!!}",
	            columns: [
	                {data: 'id', name: 'id'},                
	                {data: 'nombre', name: 'nombre'},
	                {data: 'email', name: 'email'},
	                {data: 'estatus', name: 'estatus'}
                ],
                order: [],
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
