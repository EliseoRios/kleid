@extends('layouts.layout')

@section('title')
	Parametros
@endsection

@section('header')
<div class="page-header">
  <h4 class="page-title">Parametros</h4>
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
      <a href="">Productos</a>
    </li>
  </ul>
</div>
@endsection
 
@section('content')

<div class="col-md-12">

	<div class="card">
		<div class="card-header">
			Featured
		</div>
		<div class="card-body">
			
			<!-- Listado de Productos -->
			<div class="table-responsive">
				<table id="dtProductos" class="table table-condensed small table-striped table-bordered table-hover dataTable js-exportable">  				                     
					<thead>
						<tr>
							
							<th style="max-width:40px"></th>
							<th>Foto</th>
							<th>Nombre</th>
							<th>Talla</th>
							<th>Color</th>
							<th>Género</th>

							<th>Costo</th>
							<th>Precio</th>
							<th>Mínimo</th>
							<th>Comisión</th>

						</tr>
					</thead>
					<tbody>
					</tbody>
				</table>
			</div>
			<!-- /Listado de Productos -->

		</div>
	</div>
	
</div>

<!-- Modal Parametros -->
<div class="modal fade" id="modalParametros">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<h4 class="modal-title" id="modalParametrosTitle"></h4>
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
			</div>						
			<span id="contenido_modal"><!-- Desde script --></span>
		</div>
	</div>
</div>
<!-- /Modal Parametros -->
@endsection 


@section('script')

	<script type="text/javascript">

		$(function(){ 

			$('#modalParametros').on('shown.bs.modal', function(evento){
				var id = $(evento.relatedTarget).data('identifier');
				var formulario = $(evento.relatedTarget).data('formulario');
				var url = "";
				var titulo = "";

				switch (formulario) {
					case 'crear':
						titulo = "Crear parametro";
						url = "{{ url('parametros/crear') }}";
						break;
					case 'editar':
						titulo = "Editar parametro";
						url = "{{ url('parametros/editar') }}/"+id;
						break;
					default:
						// statements_def
						break;
				}

				$('#modalParametrosTitle').text(titulo);
				$('#contenido_modal').load(url);
			});

			$('#dtProductos').DataTable({
			    processing: true,
			    serverSide: true,
			    stateSave: true,
			    order: [],
			    ajax: "{!!URL::to('parametros/datatables')!!}",
			    columns: [
			        {data: 'id', name: 'id'},                
			        {data: 'identificador', name: 'identificador'},
			        {data: 'nombre', name: 'nombre'},
			        {data: 'valor', name: 'valor'}
			   ],

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