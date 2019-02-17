@extends('layouts.layout')

@section('title')
  Productos
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
      <a>Productos</a>
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

        $('#dtProductos').DataTable({
            processing: true,
            serverSide: true,
            stateSave: true,
            order: [],
            ajax: "{!!URL::to('productos/datatables')!!}",
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
