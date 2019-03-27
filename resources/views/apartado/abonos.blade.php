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
<div class="col-md-12">
  <div class="card">
   {{--  <div class="card-header">
      <div class="d-flex align-items-center">
        <h4 class="card-title" title="Pendientes de pagar">Abonos</h4>
      </div>
    </div> --}}
    <div class="card-body">

      <div class="ml-auto">
        <div class="btn-group">
          
        </div>
      </div>

      <div class="row">
        {{-- Resumen --}}
        <div class="col-md-3">

          <div class="card">
            <div class="card-header">
              RESUMEN
            </div>
            <div class="card-body">

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
                    <td class="text-right">${{ number_format(($cliente->adeudo > 0)?$cliente->adeudo:0,2,'.',',') }}</td>
                  </tr>
                </tbody>
              </table>

            </div>
          </div>
          
        </div>
        {{-- /Resumen --}}

        {{-- Ventas liquidadas --}}
        <div class="col-md-6">

          <div class="card full-height">
            <div class="card-header">
              <div class="card-title">Ventas liquidadas</div>
            </div>
            <div class="card-body pre-scrollable">
              
              <!-- Listado de productos -->
              <div class="table-responsive">
                <table id="" class="display table table-condensed small">                               
                  <thead>
                    <tr>

                      <th>Foto</th>
                      <th title="Código del sistema">C.S</th>
                      <th>Nombre</th>
                      <th>Costo</th>
                      <th>Liquidado</th>

                    </tr>
                  </thead>
                  <tbody>
                    @foreach ($ventas_liquidadas as $venta)

                      @php
                        $producto = $venta->producto;

                        $imagen = '<img src="'.url('imagen/'.$producto->imagen_principal_id).'" class="img-thumbnail" alt="Foto" style="width: 80px;" title="#'.str_pad($producto->id, 5,'0',STR_PAD_LEFT).'">';
                      @endphp
                      
                      <tr>

                        <td><?php echo $imagen; ?></td>
                        <td>{{ $producto->id }}</td>
                        <td>{{ $producto->nombre }}</td>
                        <td class="text-right">${{ number_format($venta->pago,2,'.',',') }}</td>
                        <td>{{ ($venta->fecha_saldado != null)?date('d/m/Y', strtotime($venta->fecha_saldado)):date('d/m/Y', strtotime($venta->updated_at)) }}</td>

                      </tr>

                    @endforeach
                  </tbody>

                </table>
              </div>
              <!-- /Listado de productos -->

            </div>
            <div class="card-footer">
              <strong class="pull-right">TOTAL &nbsp;&nbsp;&nbsp;${{ number_format($ventas_liquidadas->sum('total_pago'),2) }}</strong>
            </div>
          </div>

        </div>
        {{-- /Ventas liquidadas --}}
        
        <!-- Listado de abonos -->
        {{-- Totales --}}
        <?php $sum_abonos = 0; $paso = 0; ?>
        <div class="col-md-3">

          <div class="card full-height">
            <div class="card-header">
              <div class="card-title">Abonos</div>
              <span style="font-size: 12px;">
                <i class="fas fa-circle text-success"></i> Sin aplicar &nbsp;
                <i class="fas fa-circle text-warning"></i> Porción aplicada &nbsp;
                <i class="fas fa-circle text-danger"></i> Aplicado
              </span>
            </div>
            <div class="card-body pre-scrollable">
              <ol class="activity-feed">
                @foreach ($abonos as $abono)
                  <?php $sum_abonos += $abono->abono; ?>
                  
                  @if ($sum_abonos > $cliente->a_favor)
                    @if ($paso == 0)
                    <li class="feed-item feed-item-warning">
                      <time class="date" datetime="9-25">{{ $abono->created_at }}</time>
                        <s>${{ number_format($abono->abono,2,'.',',') }}</s>

                        <?php 
                          $libre = $cliente->a_favor - ($sum_abonos - $abono->abono);
                        ?>
                        <span class="text">
                          <i class="fas fa-arrow-right"></i>${{ number_format($libre,2) }}
                        </span>

                    </li>
                    @else
                    <li class="feed-item feed-item-danger">
                      <time class="date" datetime="9-25">{{ $abono->created_at }}</time>
                      <s>${{ number_format($abono->abono,2,'.',',') }}</s>
                    </li>            
                    @endif

                    <?php $paso = 1; ?>
                  @else                  
                  <li class="feed-item feed-item-success">
                    <time class="date" datetime="9-25">{{ $abono->created_at }}</time>
                    <span class="text">${{ number_format($abono->abono,2,'.',',') }}</span>
                  </li>
                  @endif                  

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