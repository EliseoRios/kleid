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
    <li class="nav-home">
      <a href="{{ url('surtidos') }}">
        <i class="fas fa-dolly"></i> Surtidos
      </a>
    </li>
    <li class="separator">
      <i class="flaticon-right-arrow"></i>
    </li>
    <li class="nav-item">
      <a>Editar</a>
    </li>
  </ul>
</div>
@endsection
 
@section('content')
<div class="col-md-12">
  <div class="card">
    <div class="card-header">
      <div class="d-flex align-items-center">
        <h4 class="card-title">Productos comprados <small>> {{ date('d/m/Y', strtotime($fecha)) }}</small></h4>
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
                <th title="Código del sistema" style="max-width: 25px;">C.S</th>
                {{-- <th>Código</th> --}}
                <th>Nombre</th>
                <th>Género</th>
                <th>Costo</th>
                <th>Pzas.</th>

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
  @include('layouts.includes.select2')

  <script type="text/javascript">

    $(function(){

      $('.select2').select2();

      $('#dtProductos').DataTable({
          processing: true,
          serverSide: true,
          stateSave: true,
          order: [],
          ajax: "{!!URL::to('surtidos/dtproductos/'.$fecha)!!}",
          columns: [
            {data: 'id', name: 'id'},                
            {data: 'imagen', name: 'imagen'},
            {data: 'productos_id', name: 'productos_id'},
            /*{data: 'producto.codigo', name: 'producto.codigo'},*/
            {data: 'producto.nombre', name: 'producto.nombre'},
            {data: 'genero', name: 'genero'},
            {data: 'costo_total', name: 'costo_total',render: $.fn.dataTable.render.number(',', '.', 2, '$')},
            {data: 'piezas', name: 'piezas'},
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
