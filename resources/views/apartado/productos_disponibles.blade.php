@extends('layouts.layout')

@section('title')
  Productos
@endsection

@section('header')
<div class="page-header">
  <h4 class="page-title">Apartado</h4>
  <ul class="breadcrumbs">
    <li class="nav-home">
      <a href="{{ url('/') }}">
        <i class="flaticon-home"></i> Inicio
      </a>
    </li>
    <li class="separator">
      <i class="flaticon-right-arrow"></i>
    </li>
    <li class="nav-home">
      <a href="{{ url('sistema_apartado/cliente/'.Hashids::encode($cliente->id)) }}">
        {{ $cliente->nombre }}
      </a>
    </li>
    <li class="separator">
      <i class="flaticon-right-arrow"></i>
    </li>
    <li class="nav-item">
      <a>Apartado</a>
    </li>
  </ul>
</div>
@endsection
 
@section('content')
<div class="col-md-12">
  <div class="card">
    <div class="card-header">
      <div class="d-flex align-items-center">
        <h4 class="card-title">Productos disponibles</h4>
      </div>
    </div>
    <div class="card-body">
      
        <!-- Listado de productos -->
        <div class="table-responsive">
          <table id="dtProductos" class="display table table-condensed small">                               
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
                <th>Disponibles</th>

              </tr>
            </thead>
            <tbody>
            </tbody>

          </table>
        </div>
        <!-- /Listado de productos -->

    </div>
  </div>
</div>

<!-- Modal apartar -->
<div class="modal fade" id="modalApartado">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title" id="modalParametrosTitle"></h4>
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
      </div>            
      <span id="contenido_modal"><!-- Desde script --></span>
    </div>
  </div>
</div>
<!-- /Modal apartar -->
@endsection 

@section('script')
  @include('layouts.includes.bootstrap-file-upload')

  <script type="text/javascript">

    $(function(){

        $('.imagen').fileinput({
          language: 'es',
          showUpload: false,
          showCancel: false,
          allowedFileExtensions: ['jpg', 'png', 'gif']
        });

        $('#modalApartado').on('shown.bs.modal', function(evento){
          var id = $(evento.relatedTarget).data('identifier');
          var formulario = $(evento.relatedTarget).data('formulario');
          var url = "";
          var titulo = "";

          switch (formulario) {
            case 'editar':
              titulo = "Apartar producto";
              url = "{{ url('sistema_apartado/apartado_frm/'.Hashids::encode($cliente->id)) }}/"+id;
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
            ajax: "{!!URL::to('productos/dtdisponibles')!!}",
            columns: [
              {data: 'id', name: 'id'},                
              {data: 'imagen', name: 'imagen'},
              {data: 'nombre', name: 'nombre'},
              {data: 'talla', name: 'talla'},
              {data: 'color', name: 'color'},
              {data: 'genero', name: 'genero'},
              {data: 'costo', name: 'costo',render: $.fn.dataTable.render.number(',', '.', 2, '$')},
              {data: 'precio', name: 'precio',render: $.fn.dataTable.render.number(',', '.', 2, '$')},
              {data: 'precio_minimo', name: 'precio_minimo',render: $.fn.dataTable.render.number(',', '.', 2, '$')},
              {data: 'disponibles', name: 'disponibles'},
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
