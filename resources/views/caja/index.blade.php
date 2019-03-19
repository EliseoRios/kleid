@extends('layouts.layout')

@section('title')
  Caja
@endsection

@section('header')
<div class="page-header">
  <h4 class="page-title">Cajero</h4>
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
      <a href="{{ url('caja') }}"><i class="fas fa-desktop"></i> Caja</a>
    </li>
    @if(isset($ticket))
    <li class="separator">
      <i class="flaticon-right-arrow"></i>
    </li>
    <li class="nav-home">
      <a>Ticket {{ str_pad($ticket->id,5,0,STR_PAD_LEFT) }}</a>
    </li>
    @endif
  </ul>
</div>
@endsection
 
@section('content')
{{-- Registros en caja --}}
<div class="col-md-4 float-left">
  <div class="card">
    <div class="card-header">
      <h4 class="card-title text-center">AGREGAR PRODUCTO</h4>
    </div>
    <div class="card-body">

    @if(Auth::user()->permiso(['menu',4001]))
      @if(isset($ticket))

      {!! Form::open(array('action' => 'CajaController@agregar','class'=>'form','role'=>'form','files'=>'true')) !!}

        {!! Form::hidden('_token', csrf_token(),array('id'=>'token')) !!}

        <div class="form-group">
          {!! Form::label('productos_id', 'Producto :',['class'=>'control-label']) !!}

          {!! Form::select('productos_id', $productos, null, ['class'=>'form-control select2','style'=>'width: 100%;height: 24px;','placeholder'=>'-- Seleccionar producto --','id'=>'apartado_producto','required']) !!}
        </div>

        <div class="form-group">
          {!! Form::label('pago', 'Pago :',['class'=>'control-label']) !!}

          {!! Form::select('pago', [], null, ['class'=>'form-control','style'=>'width: 100%;height: 24px;','placeholder'=>'-- Precio --','id'=>'apartado_precio','required']) !!}
        </div>

        <div class="form-group" >
          {!! Form::label('piezas', 'Piezas : ',['class'=>'control-label']) !!}

          {!! Form::number('piezas',1,array( 'class' => 'form-control', 'min'=>1,'id'=>'apartado_piezas','required')) !!}
        </div>

        {!! Form::hidden('tickets_id', (isset($ticket))?$ticket->id:0, []) !!}

        <button type="submit" class="btn btn-primary btn-lg btn-block">
          <i class="fas fa-cart-plus"></i> AGREGAR
        </button>

        @else

        <a href="{{ url('caja/ticket/generar') }}" class="btn btn-info btn-lg btn-block">
          <i class="fas fa-shopping-bag"></i> NUEVO TICKET
        </a>

        @endif
      @endif

      {!! Form::close()!!}      

    </div>
  </div>
</div>
{{-- /Registros en caja --}}

{{-- Ventas sin liquidar --}}
<div class="col-md-8 float-right">
  <div class="card">
    <div class="card-header">
      <div class="d-flex align-items-center">

        <h5 class="card-title" title="Pendientes de pagar">
          VENTAS |&nbsp;<strong class="float-right">Total: $ {{ number_format($total,2) }}</strong>
        </h5>

      </div>
    </div>

    <div class="card-body">

      @if (Auth::user()->permiso(array('menu',4001)) == 2 || in_array(Auth::user()->perfiles_id, [1,2]))
      <div class="float-right" style="margin-bottom: 15px;">

        <div class="btn-group">
          
          @if($total > 0 && Auth::user()->permiso(['menu',4001]))
          <a href="" data-toggle="modal" data-target="#modalCompletar" class="btn btn-secondary btn-sm" title="Cobrar" style="color: white; width: 120px;">
              <i class="fas fa-hand-holding-usd"></i>
              &nbsp;Cobrar
          </a>                    
          @endif          

        </div>
        
      </div>
      @endif

      <a href="{{ url('caja/ticket/eliminar/'.Hashids::encode($ticket_id)) }}" class="btn btn-warning btn-sm" style="color: white; width: 120px;" title="Eliminar Ticket" onclick="return confirm('Eliminar Ticket ?');"><i class="fas fa-trash"></i> Cancelar ticket</a>

      <br><br>
      
      @if($total > 0 && Auth::user()->permiso(['menu',4001]))

      <!-- Listado de productos -->
      <div class="table-responsive">
        <table id="" class="display table table-condensed small">                               
          <thead>
            <tr>

              <th style="max-width:40px"></th>
              <th>Foto</th>
              <th title="Código del sistema">C.S</th>
              <th>Nombre</th>
              <th>Género</th>
              <th>Pzas</th>
              <th>Importe</th>

            </tr>
          </thead>
          <tbody>
            {!! Form::open(['action'=>'ApartadoController@agregar_abono', 'role'=>'form', 'class'=>'form']) !!}
            @foreach ($ventas as $venta)

              @php
                $producto = $venta->producto;

                $primer_imagen= $producto->imagenes()->first();
                $imagen_id = (isset($primer_imagen))?$primer_imagen->id:0;

                $imagen = '<img src="'.url('imagen/'.$imagen_id).'" class="img-thumbnail" alt="Foto" style="width: 80px;" title="#'.str_pad($producto->id, 5,'0',STR_PAD_LEFT).'">';
              @endphp
              
              <tr>
                <td style="max-width: 30px;">
                  <div role="group" aria-label="Toolbar with button groups">

                    @if($venta->estatus !== 2 && Auth::user()->permiso(['menu',4001]))
                    <a href="{{ url('sistema_apartado/eliminar/'.Hashids::encode($venta->id)) }}" class="btn btn-xs btn-danger" style="margin: 1px; width: 30px; color: white;" title="Eliminar" onclick="return confirm('Eliminar ?');"><i class="fas fa-trash"></i></a>
                    @endif                     

                  </div>
                </td>
                <td><?php echo $imagen; ?></td>
                <td>{{ $producto->id }}</td>
                <td>{{ $producto->nombre }}</td>
                <td>{{ config('sistema.generos')[$producto->genero] }}</td>
                <td>{{ $venta->piezas }}</td>
                <td class="text-right">${{ number_format($venta->total_pago,2,'.',',') }}</td>
              </tr>

            @endforeach
            {!! Form::close() !!}
          </tbody>

        </table>
      </div>
      <!-- /Listado de productos -->

      @else

      <div class="alert alert-info alert-important" role="alert">
        <strong>Sin registros!</strong>
      </div>

      @endif

    </div>
  </div>
</div>
{{-- /Ventas sin liquidar --}}

{{-- Modal completar venta --}}
<div class="modal fade" id="modalCompletar">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title">Completar venta</h4>
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
      </div>

      {!! Form::open(['action'=>'CajaController@completar','class'=>'form']) !!}

      <div class="modal-body">

        <div class="form-group">
          {!! Form::label('dinero_recibido', 'Dinero recibido :', ['class'=>'control-label']) !!}

          {!! Form::number('dinero_recibido', null, ['class'=>'form-control','min'=>$total,'id'=>'dinero_recibido','step'=>'any','required']) !!}
        </div>

        <div class="form-group">
          {!! Form::label('total', 'Total :', ['class'=>'control-label']) !!}

          {!! Form::number('total', $total, ['class'=>'form-control','id'=>'total','step'=>'any','readonly','required']) !!}
        </div>

        <div class="form-group">
          {!! Form::label('cambio', 'Cambio :', ['class'=>'control-label']) !!}

          {!! Form::number('cambio', 0, ['class'=>'form-control','id'=>'cambio','step'=>'any','readonly','required']) !!}
        </div>

        {!! Form::hidden('id', (isset($ticket))?$ticket->id:0, []) !!}
        
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal"><i class="fa fa-times"></i> Cancelar</button>
        <button type="submit" class="btn btn-primary"><i class="fas fa-check"></i> Cobrar</button>
      </div>

      {!! Form::close() !!}

    </div>
  </div>
</div>
{{-- /Modal completar venta --}}

@endsection 

@section('script')
  @include('layouts.includes.bootstrap-file-upload')
  @include('layouts.includes.select2')

  <script type="text/javascript">

    $(function(){
        $('.select2').select2();

        $('.imagen').fileinput({
          language: 'es',
          showUpload: false,
          showCancel: false,
          allowedFileExtensions: ['jpg', 'png', 'gif']
        });

        var total = $('#total');
        var dinero_recibido = $('#dinero_recibido');
        var cambio = $('#cambio');

        dinero_recibido.bind('change keyup', function(event) {
          var resta_cambio = Number(dinero_recibido.val() - total.val());
          cambio.val(resta_cambio);
        });

        var select_producto = $('#apartado_producto');
        var input_piezas = $('#apartado_piezas');
        var select_precio = $('#apartado_precio');

        select_producto.change(function(event) {
          var productos_id = Number(select_producto.val());
          var url_existencia = "{{ url('productos/existencia') }}/"+productos_id;

          select_precio.empty();
          input_piezas.val(1);
            
          if (productos_id > 0) {
            $.get(url_existencia, function(resultado) {
              input_piezas.prop('max', resultado.existencia.disponibles);

              select_precio.append('<option val="'+resultado.precio.min+'">'+resultado.precio.min+'</option>');
              select_precio.append('<option val="'+resultado.precio.max+'" selected>'+resultado.precio.max+'</option>');

            });
          }          
        });
    
    });

  </script>

@endsection