@extends('layouts.layout')

@section('title')
	Surtidos
@endsection

@section('header')
<div class="page-header">
	<h4 class="page-title">Surtidos</h4>
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
			<a><i class="fas fa-dolly"></i> Surtidos</a>
		</li>
	</ul>
</div>
@endsection
 
@section('content')
<div class="col-md-12">
	<div class="card">
		<div class="card-header">
			<div class="d-flex align-items-center">
				<h4 class="card-title"></h4>

				@if (Auth::user()->permiso(array('menu',2003)) == 2) 
				<a href="" data-target="#modalNuevo" data-toggle="modal" class="btn btn-primary btn-round ml-auto" title="Agregar" style="color: white;">
				    <i class="fa fa-plus"></i>
				    Agregar
				</a>
			    @endif
			</div>
		</div>
		<div class="card-body">
			
		    <!-- Listado de surtidos -->
		    <div class="table-responsive">
		    	<table id="datatable" class="display table table-bordered table-striped table-hover small">  				                     
		    		<thead>
		    			<tr>		    				
		    				<th style="min-width:80px"></th>
		    				<th>Fecha</th>
		    				<th>Venta</th>
		    				<th>Costo</th>
		    				<th>Comisión</th>
		    				<th>Ganancia</th>
		    			</tr>
		    		</thead>
		    		<tbody>
		    		</tbody>

		    	</table>
		    </div>
		  	<!-- /Listado de surtidos -->

		</div>
	</div>
</div>


<!-- Modal nuevo -->
<div class="modal fade" id="modalNuevo" role="dialog" aria-labelledby="modalNuevo">
  <div class="modal-dialog ">
    <div class="modal-content">
      <div class="modal-header" style="background-color: #f5f5f5">
        <h4 class="modal-title" id="myModalLabel">Surtir producto</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
      </div>

      {!! Form::open(array('action' => 'ProductosController@add_detalle','class'=>'form','role'=>'form','files'=>'true')) !!}      

      <div class="modal-body">

        {!! Form::hidden('_token', csrf_token(),array('id'=>'token')) !!}

        <div class="form-group">
          {!! Form::label('productos_id', 'Nombre :',['class'=>'control-label']) !!}

          {!! Form::select('productos_id', $productos, null, ['class'=>'form-control select2','style'=>'width: 100%;height: 24px;','placeholder'=>'-- Seleccionar producto --','required']) !!}
        </div>

        <div class="form-group" >
          {!! Form::label('piezas', 'Piezas : ',['class'=>'control-label']) !!}

          {!! Form::number('piezas',1,array( 'class' => 'form-control', 'min'=>1,'required')) !!}
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
<!-- /Modal nuevo -->

@endsection 

@section('script')
    @include('layouts.includes.select2')

	<script type="text/javascript">

		$(function(){ 

		    @if ($errors->any())
	            $('#modalNuevo').modal('show');
		    @endif

		    $('.select2').select2();

		    $('#datatable').DataTable({
	            processing: true,
	            serverSide: true,
	            ajax: "{!!URL::to('surtidos/datatables')!!}",
	            columns: [
	                {data: 'id', name: 'id'},
	                {data: 'fecha', name: 'fecha'},
	                {data: 'venta', name: 'gasto',render: $.fn.dataTable.render.number(',', '.', 2, '$')},
	                {data: 'costo', name: 'gasto',render: $.fn.dataTable.render.number(',', '.', 2, '$')},
	                {data: 'comision', name: 'gasto',render: $.fn.dataTable.render.number(',', '.', 2, '$')},
	                {data: 'ganancia', name: 'gasto',render: $.fn.dataTable.render.number(',', '.', 2, '$')},
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
