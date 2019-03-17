@extends('layouts.layout')

@section('title')
  Sistema de apartado
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
    <li class="nav-item">
      <a href="{{ url('sistema_apartado') }}"><i class="fas fa-chalkboard-teacher"></i> Sistema de apartado</a>
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
    <li class="nav-home">
      <a>
        Abonos
      </a>
    </li>
  </ul>
</div>
@endsection
 
@section('content')
{{-- Ventas sin liquidar --}}
<div class="col-md-12">
  <div class="card">
    <div class="card-header">
      <div class="d-flex align-items-center">
        <h4 class="card-title" title="Pendientes de pagar">Abonos</h4>
      </div>
    </div>
    <div class="card-body">

      <div class="ml-auto">
        <div class="btn-group">
          
        </div>
      </div>

      <div class="row">
        <div class="col-md-4">

          <table class="table table-sm table-hover">
            <thead>
              <tr>
                <th colspan="2">RESUMEN</th>
              </tr>
            </thead>
            <tbody>
              <tr>
                <th>Sin liquidar</th>
                <td class="text-right">${{ number_format($cliente->suma_sin_liquidar,2,'.',',') }}</td>
              </tr>
              <tr>
                <th>Saldo a favor</th>
                <td class="text-right">${{ number_format($cliente->a_favor,2,'.',',') }}</td>
              </tr>   
              <tr>
                <th>Total adeudo</th>
                <td class="text-right">${{ number_format(($cliente->adeudo > 0)?$cliente->adeudo:0,2,'.',',') }}</td>
              </tr>
            </tbody>
          </table>
          
        </div>
        
        <!-- Listado de abonos -->
        {{-- Totales --}}
        <div class="col-md-8 pre-scrollable">

          <div class="card full-height">
            <div class="card-header">
              <div class="card-title">Historial</div>
            </div>
            <div class="card-body">
              <ol class="activity-feed">
                @foreach ($abonos as $abono)
                <li class="feed-item feed-item-success">
                  <time class="date" datetime="9-25">{{ $abono->created_at }}</time>
                  <span class="text">${{ number_format($abono->abono,2,'.',',') }}</span>
                </li>
                @endforeach
              </ol>
            </div>
          </div>

        </div>
        <!-- /Listado de abonos -->

      </div>

    </div>
  </div>
</div>
{{-- /Ventas sin liquidar --}}
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