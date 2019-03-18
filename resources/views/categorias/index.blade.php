@extends('layouts.layout')

@section('title')
	Categorías
@endsection

@section('header')
<div class="page-header">
	<h4 class="page-title">Categorías</h4>
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
			<a><i class="fas fa-tags"></i> Categorías</a>
		</li>
	</ul>
</div>
@endsection
 
@section('content')
<div class="col-md-12">
	<div class="card">
		<div class="card-header">
			<div class="d-flex align-items-center">
				<h4 class="card-title">Categorías</h4>

				@if (Auth::user()->permiso(array('menu',2004)) === 2) 
				<a href="" data-target="#modalNuevo" data-toggle="modal" data-formulario="crear" data-identifier="0" class="btn btn-primary btn-round ml-auto" title="Agregar" style="color: white;">
				    <i class="fa fa-plus"></i>
				    Agregar
				</a>
			    @endif
			</div>
		</div>
		<div class="card-body">
			
		    <!-- Listado de categorias -->
		    <div class="table-responsive">
		    	<table id="dtcategorias" class="display table table-bordered table-striped table-hover small">  				                     
		    		<thead>
		    			<tr>		    				
		    				<th style="min-width:80px"></th>
		    				{{-- <th>C. Padre</th> --}}
		    				<th>Categoría</th>
		    			</tr>
		    		</thead>
		    		<tbody>
		    		</tbody>

		    	</table>
		    </div>
		  	<!-- /Listado de categorias -->

		</div>
	</div>
</div>

<!-- Modal -->
<div class="modal fade" id="modalNuevo" role="dialog" aria-labelledby="modalNuevo">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header" style="background-color: #f5f5f5">
				<h4 class="modal-title" id="myModalLabel">Agregar Usuario</h4>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
			</div>

			<span id="loadFormulario"></span>
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

		    $('#modalNuevo').on('shown.bs.modal', function(e){
		    	var id = $(e.relatedTarget).data('identifier');
		    	var formulario = $(e.relatedTarget).data('formulario');
		    	var url = "";

		    	switch (formulario) {
		    		case 'crear':
		    			url = "{{ url('categorias/crear') }}";
		    			break;

		    		case 'editar':
			    		url = "{{ url('categorias/editar/') }}/"+id;
			    		break;

		    		default:
		    			// statements_def
		    			break;
		    	}

		    	$('#loadFormulario').load(url);
		    });

		    $('#dtcategorias').DataTable({
	            processing: true,
	            serverSide: true,
	            ajax: "{!!URL::to('categorias/datatables')!!}",
	            columns: [
	                {data: 'id', name: 'id'},                
	                /*{data: 'categorias_id', name: 'categorias_id'},*/
	                {data: 'categoria', name: 'categoria'},
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