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
        <div class="ml-auto">          
          <a href="" data-toggle="modal" data-target="#modalAbono" class="btn btn-secondary btn-round" title="Agregar" style="color: white;">
              <i class="fa fa-hand-holding-usd"></i>
              &nbsp;Abonar
          </a>

          <a href="{{ url('sistema_apartado/productos/'.Hashids::encode($cliente->id)) }}" class="btn btn-primary btn-round" title="Agregar" style="color: white;">
              <i class="fa fa-shopping-cart"></i>
              &nbsp;Apartar productos
          </a>
        </div>
        @endif
      </div>
    </div>
    <div class="card-body">

      <div class="ml-auto">
        <div class="btn-group">
          
        </div>
      </div>

        <a href="" class="btn btn-dark btn-xs" data-toggle="modal" data-target="#modalResumen" style="color: white;"><i class="fa fa-file"></i> RESUMEN</a>

        <a href="{{ url('sistema_apartado/abonos/'.Hashids::encode($cliente->id)) }}" class="btn btn-info btn-xs" style="color: white;"><i class="fa fa-money-bill-alt"></i> ABONOS</a>
      
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
                
                <tr>
                  <td>
                    {!! Form::checkbox('ventas_ids[]', $venta->id, false, ['class'=>'checkbox','data-costo'=>$venta->costo]) !!}
                  </td>
                  <td><?php echo $imagen; ?></td>
                  <td>{{ $producto->nombre }}</td>
                  <td>{{ $producto->talla }}</td>
                  <td>{{ $producto->color }}</td>
                  <td>{{ config('sistema.generos')[$venta->producto->genero] }}</td>
                  <td class="text-right">${{ number_format($venta->pago,2,'.',',') }}</td>
                </tr>

              @endforeach
              {!! Form::close() !!}
            </tbody>
            <tfoot>
              <tr>
                <th class="text-right" colspan="6">TOTAL</th>
                <th class="text-right" colspan="1">${{ number_format($cliente->adeudo,2,'.',',') }}</th>
              </tr>
            </tfoot>

          </table>
        </div>
        <!-- /Listado de productos -->

    </div>
  </div>
</div>
{{-- /Ventas sin liquidar --}}

{{-- Modal resumen --}}
<div class="modal fade" id="modalResumen">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title">Resumen</h4>
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
      </div>
      <div class="modal-body">
        
        <table class="table table-sm table-hover">
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
              <td class="text-right">${{ number_format($cliente->adeudo,2,'.',',') }}</td>
            </tr>
          </tbody>
        </table>

      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
      </div>
    </div>
  </div>
</div>
{{-- /Modal resumen --}}

{{-- Modal abono --}}
<div class="modal fade" id="modalAbono">
  <div class="modal-dialog modal-sm" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title">Abono</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
          <span class="sr-only">Close</span>
        </button>
      </div>

      {!! Form::open(array('action' => 'ApartadoController@agregar_abono','class'=>'form','role'=>'form','files'=>'true')) !!}  
      {!! Form::hidden('_token', csrf_token(),array('id'=>'token')) !!}
      <div class="modal-body">
        <div class="form-group">
          {!! Form::label('abono', 'Abono :', ['class'=>'control-label']) !!}

          {!! Form::number('abono', null, ['min'=>1, 'class'=>'form-control','step'=>'any','required']) !!}
        </div>

        {!! Form::hidden('clientes_id', $cliente->id, []) !!}
      </div>

      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal"><i class="fa fa-times"></i> Cancelar</button>
        <button type="submit" class="btn btn-primary"><i class="fa fa-plus"></i> Abonar</button>
      </div>
      {!! Form::close() !!}

    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
{{-- /Modal abono --}}

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