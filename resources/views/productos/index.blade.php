@extends('layouts.layout')

@section('title')
	Productos
@endsection

@section('breadcrumb')
     <li><a href=""><i class="material-icons">home</i> Inicio</a></li>
     <li class="active"><i class="material-icons">card_giftcard</i> Productos</li>
@endsection
 
@section('content')

<div class="card">
    <div class="header bg-cyan">
        <h2>
            Productos <small>Listado de productos</small>
        </h2>
        <ul class="header-dropdown m-r--5">
            <li>
        		@if (Auth::user()->permiso(array('menu',2002)) == 2 ) 
        		<a href="" data-target="#modalNuevo" data-toggle="modal" class="btn bg-blue waves-effect" title="Agregar">
        		    <i class="material-icons">add_circle</i>
        		    <span>AGREGAR</span>
        		</a>
        	    @endif                
            </li>
        </ul>
    </div>
    <div class="body">

        <!-- Listado de productos -->
    	<div class="table-responsive">
          <table id="dtproductos" class="table table-bordered table-striped table-hover dataTable js-exportable">  				                     
          <thead>
              <tr>
                  
                  <th style="max-width:45px"></th>
                  <th style="max-width: 70px;">Imagen</th>
                  <th>Código</th>
                  <th>Nombre</th>
                  <th>Material</th>
                  <th>Genero</th>
                  <th>Costo</th>
                  <th>Precio</th>
                                         
              </tr>
           </thead>
          <tbody>
          </tbody>
          </table>
      	</div>
      	<!-- /Listado de productos -->

    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="modalNuevo" role="dialog" aria-labelledby="modalNuevo">
	<div class="modal-dialog ">
		<div class="modal-content">
			<div class="modal-header" style="background-color: #f5f5f5">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<h4 class="modal-title" id="myModalLabel">Agregar Producto</h4>
			</div>

			{!! Form::open(array('action' => 'ProductosController@guardar','class'=>'','role'=>'form')) !!}			

			<div class="modal-body">

				{!! Form::hidden('_token', csrf_token(),array('id'=>'token')) !!}

				<div class="col-md-6">
					<div class="form-group" >
						{!! Form::label('codigo', 'Código :' ,array('class'=>'control-label')) !!}

						<div class="form-line">
							{!! Form::text('codigo','',array( 'class' => 'form-control', 'placeholder' => 'Código', 'required')) !!}
						</div>					
					</div>

					<div class="form-group" >
						{!! Form::label('materiales_id', 'Material :' ,array('class'=>'control-label')) !!}

						<div class="form-line">
							{!! Form::select('materiales_id',[],null,array( 'class' => 'form-control select2-tags', 'data-placeholder' => 'Material', 'style'=>'width: 100%;', 'required')) !!}
						</div>					
					</div>

					<div class="form-group" >
						{!! Form::label('costo', 'Costo :' ,array('class'=>'control-label')) !!}

						<div class="form-line">
							{!! Form::number('costo',null,array( 'class' => 'form-control', 'step'=>'any','placeholder' => 'Costo', 'required')) !!}
						</div>					
					</div>
				</div>

				<div class="col-md-6">
					<div class="form-group" >
						{!! Form::label('nombre', 'Nombre :' ,array('class'=>'control-label')) !!}

						<div class="form-line">
							{!! Form::text('nombre','',array( 'class' => 'form-control', 'placeholder' => 'Nombre', 'required')) !!}
						</div>					
					</div>					

					<div class="form-group" >
						{!! Form::label('genero', 'Genero :' ,array('class'=>'control-label')) !!}

						<div class="form-line">
							{!! Form::select('genero',[0=>'Unisex', 1=>'Masculino', 2=>'Femenino'],0,array( 'class' => 'form-control', 'required')) !!}
						</div>					
					</div>					

					<div class="form-group" >
						{!! Form::label('precio', 'Precio :' ,array('class'=>'control-label')) !!}

						<div class="form-line">
							{!! Form::number('precio',null,array( 'class' => 'form-control', 'step'=>'any','placeholder' => 'Precio', 'required')) !!}
						</div>					
					</div>

					{!! Form::hidden('formulario', 'producto', []) !!}
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

@section('css')
	<style type="text/css">
		table.dataTable tbody td {
		  vertical-align: middle;
		}
	</style>
@endsection


@section('script')

	@include('layouts.includes.datatables')
	@include('layouts.includes.select2')

	<script type="text/javascript">

		$(function(){ 

		    @if ($errors->any())
	            $('#modalNuevo').modal('show');
		    @endif

		    $('.select2-tags').select2({
		    	tags: true
		    });

		    $('#dtproductos').DataTable({
	            processing: true,
	            serverSide: true,
	            ajax: "{!!URL::to('productos/datatables')!!}",
	            columns: [
	                {data: 'id', name: 'id'},                
	                {data: 'imagen', name: 'imagen'},                
	                {data: 'codigo', name: 'codigo'},               
	                {data: 'nombre', name: 'nombre'},
	                {data: 'materiales_id', name: 'materiales_id'},
	                {data: 'genero', name: 'genero'},
	                {data: 'costo', name: 'costo'},
	                {data: 'precio', name: 'precio'}
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