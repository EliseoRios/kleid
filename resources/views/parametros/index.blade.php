@extends('layouts.layout')

@section('title')
	Parametros
@endsection

@section('breadcrumb')
     <li><a href=""><i class="material-icons">home</i> Inicio</a></li>
     <li class="active"><i class="material-icons">low_priority</i> Parametros</li>
@endsection
 
@section('content')

<div class="card">
    <div class="header bg-cyan">
        <h2>
            Parametros <small>Valores automátios del sistema</small>
        </h2>
    </div>
    <div class="body">

        <!-- Listado de Parametros -->
		<div class="table-responsive">
          <table id="dtParametros" class="table table-condensed small table-striped table-bordered table-hover dataTable js-exportable">  				                     
          <thead>
                  <tr>
                      
                      <th style="max-width:40px"></th>
                      <th>Identificador</th>
                      <th>Nombre</th>
                      <th>Valor</th>
                                             
                  </tr>
           </thead>
          <tbody>
          </tbody>
          </table>
      	</div>
      	<!-- /Listado de Parametros -->

    </div>
</div>

<!-- Modal Parametros -->
<div class="modal fade" id="modalParametros">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
				<h4 class="modal-title" id="modalParametrosTitle"></h4>
			</div>						
			<span id="contenido_modal"><!-- Desde script --></span>
		</div>
	</div>
</div>
<!-- /Modal Parametros -->

{{-- {!! Form::label('Nombre : ', null ,[]) !!}
<div class="form-group" >
	<div class="form-line">
		{!! Form::text('nombre','',array( 'class' => 'form-control', 'placeholder' => 'Nombre completo del usuario')) !!} 
		<p class="text-danger">	{!! $errors->first('nombre')!!} </p>
	</div>
</div>	 --}}
@endsection 


@section('script')

	@include('layouts.includes.datatables')

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

			$('#dtParametros').DataTable({
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