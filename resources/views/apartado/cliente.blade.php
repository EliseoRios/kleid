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
  </ul>
</div>
@endsection
 
@section('content')
{{-- Ventas sin liquidar --}}
<div class="col-md-12">
  <div class="card">
    <div class="card-header">
      <div class="d-flex align-items-center">
        <h4 class="card-title" title="Pendientes de pagar">Productos apartados</h4>

        @if (Auth::user()->permiso(array('menu',2002)) == 2 || in_array(Auth::user()->perfiles_id, [1,2])) 
        <a href="{{ url('sistema_apartado/productos/'.Hashids::encode($cliente->id)) }}" class="btn btn-primary btn-round ml-auto" title="Agregar" style="color: white;">
            <i class="fa fa-shopping-cart"></i>
            &nbsp;Apartar productos
        </a>
        @endif
      </div>
    </div>
    <div class="card-body">

      <div class="ml-auto">
        <div class="btn-group">
          
        </div>
      </div>
      
        <!-- Listado de productos -->
        <div class="table-responsive">
          <table id="" class="display table table-condensed small">                               
            <thead>
              <tr>

                <th style="max-width:40px"></th>
                <th>Foto</th>
                <th>Nombre</th>
                <th>Talla</th>
                <th>Color</th>
                <th>Género</th>
                <th>Costo</th>

              </tr>
            </thead>
            <tbody>
              {!! Form::open(['action'=>'ApartadoController@agregar_abono', 'role'=>'form', 'class'=>'form']) !!}
              @foreach ($ventas_sin_liquidar as $venta)

                @php
                  $producto = $venta->producto;

                  $primer_imagen= $producto->imagenes()->first();
                  $imagen_id = (isset($primer_imagen))?$primer_imagen->id:0;

                  $imagen = '<img src="'.url('imagen/'.$imagen_id).'" class="img-thumbnail" alt="Foto" style="width: 80px;" title="#'.str_pad($producto->id, 5,'0',STR_PAD_LEFT).'">';
                @endphp
                
                <td></td>
                <td><?php echo $imagen; ?></td>
                <td>{{ $producto->nombre }}</td>
                <td>{{ $producto->talla }}</td>
                <td>{{ $producto->color }}</td>
                <td>{{ config('sistema.generos')[$venta->producto->genero] }}</td>
                <td>{{ $venta->pago }}</td>

              @endforeach
              {!! Form::close() !!}
            </tbody>

          </table>
        </div>
        <!-- /Listado de productos -->

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