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
      <a>{{ $cliente->nombre }}</a>
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
      </div>
    </div>
    <div class="card-body">
      @if (Auth::user()->permiso(array('menu',2002)) == 2 || in_array(Auth::user()->perfiles_id, [1,2]))
      <div class="float-right" style="margin-bottom: 15px;">

        @if(Auth::user()->permiso(['menu',4002]) == 2)
        <div class="btn-group" role="group" aria-label="Basic example">
          
          <a href="" data-toggle="modal" data-target="#modalAbono" class="btn btn-secondary btn-sm" title="Abonar" style="color: white;">
              <i class="fas fa-piggy-bank"></i>
              &nbsp;Abonar
          </a>

          @if($cliente->a_favor > 0)
          <a href="" data-toggle="modal" data-target="#modalReembolso" class="btn btn-dark btn-sm" title="Reembolsar" style="color: white;">
              <i class="far fa-frown"></i>
              &nbsp;Reembolso
          </a>
          @endif

          <a href="" data-target="#modalApartar" data-toggle="modal" class="btn btn-primary btn-sm" title="Agregar" style="color: white;">
              <i class="fas fa-cart-plus"></i>
              &nbsp;Apartar productos
          </a>

        </div>
        @endif
        
      </div>
      @endif

      <div class="float-left" style="margin-bottom: 15px;">
        <a href="" class="btn btn-dark btn-xs" data-toggle="modal" data-target="#modalResumen" style="color: white;"><i class="fa fa-file"></i> RESUMEN</a>

        <a href="{{ url('sistema_apartado/abonos/'.Hashids::encode($cliente->id)) }}" class="btn btn-info btn-xs" style="color: white;"><i class="fa fa-money-bill-alt"></i> HISTORIAL</a>

        <a class="btn btn-danger btn-xs" href="{{ url('sistema_apartado/estado_cuenta/'.Hashids::encode($cliente->id)) }}" target="_blank" style="color: white;"><i class="fas fa-file-pdf"></i> ESTADO DE CUENTA</a>
      </div>        
      
        <!-- Listado de productos -->
        <div class="table-responsive">
          <table id="" class="display table table-condensed small">                               
            <thead>
              <tr>

                <th style="max-width:25px"></th>
                <th>Foto</th>
                <th title="Código del sistema">C.S</th>
                {{-- <th>Código</th> --}}
                <th>Nombre</th>
                <th>Género</th>
                <th>Costo</th>
                <th>Vencimiento</th>

              </tr>
            </thead>
            <tbody>
              {!! Form::open(['action'=>'ApartadoController@agregar_abono', 'role'=>'form', 'class'=>'form']) !!}
              @foreach ($ventas_sin_liquidar as $venta)

                @php
                  $producto = $venta->producto;

                  $imagen = '<img src="'.url('imagen/'.$producto->imagen_principal_id).'" class="img-thumbnail" alt="Foto" style="width: 80px;" title="#'.str_pad($producto->id, 5,'0',STR_PAD_LEFT).'">';
                @endphp
                
                <tr>
                  <td style="max-width: 30px;">
                    <div role="group" aria-label="Toolbar with button groups">


                      @if(!$venta->liquidado && $venta->comision_pagada && $venta->entregado && $venta->pago < $cliente->a_favor)
                        @if(Auth::user()->perfiles_id == 1 || Auth::user()->id == $venta->usuarios_id)
                        <a href="{{ url('sistema_apartado/liquidar/'.Hashids::encode($venta->id)) }}" class="btn btn-xs btn-primary" style="margin: 1px; width: 30px;" title="Liquidar" onclick="return confirm('Liquidar pieza?');"><i class="fas fa-donate"></i></a>
                        @endif  
                      @elseif($venta->pago < $cliente->a_favor)
                      <i class="fa fa-hand-holding-usd text-primary text-center" style="width: 30px; font-size: 18px;" title="Puede liquidarse"></i>
                      @endif

                      @if(!$venta->entregado)
                        @if(Auth::user()->perfiles_id == 1 || Auth::user()->id == $venta->usuarios_id)
                        <a href="{{ url('sistema_apartado/entregar/'.Hashids::encode($venta->id)) }}" class="btn btn-xs btn-success" style="margin: 1px; width: 30px;" title="Entregar" onclick="return confirm('Entregar pieza?');"><i class="fas fa-diagnoses"></i></a>
                        @endif
                      @endif
                      @if($venta->entregado)
                      <i class="fas fa-diagnoses text-success text-center" style="width: 30px;" title="Entregado"></i>
                      @endif

                      @if(!$venta->comision_pagada)
                        @if(Auth::user()->perfiles_id == 1)
                        <a href="{{ url('sistema_apartado/saldar_comision/'.Hashids::encode($venta->id)) }}" class="btn btn-xs btn-dark" style="margin: 1px; width: 30px;" title="Pagar comisión ${{ number_format($venta->comision,2) }}" onclick="return confirm('Pagar comisión?');"><i class="fas fa-golf-ball"></i></a>
                        @endif                      
                      @else
                      <i class="fas fa-golf-ball text-dark text-center" style="width: 30px;" title="Comisión pagada ${{ number_format($venta->comision,2) }}"></i>
                      @endif

                      @if(!$venta->comision_pagada)
                        @if(Auth::user()->perfiles_id == 1 || Auth::user()->id == $venta->usuarios_id)
                        <a href="{{ url('sistema_apartado/eliminar/'.Hashids::encode($venta->id)) }}" class="btn btn-xs btn-danger" style="margin: 1px; width: 30px;" title="Eliminar" onclick="return confirm('Eliminar apartado?');"><i class="fas fa-trash"></i></a>
                        @endif
                      @endif                     

                    </div>
                  </td>
                  <td><?php echo $imagen; ?></td>
                  <td>{{ $producto->id }}</td>
                  {{-- <td>{{ $producto->codigo }}</td> --}}
                  <td>{{ $producto->nombre }}</td>
                  <td>{{ config('sistema.generos')[$venta->producto->genero] }}</td>
                  <td class="text-right">${{ number_format($venta->pago,2,'.',',') }}</td>
                  <td class="text-{{ ($venta->fecha_plazo < date('Y-m-d'))?'danger':'primary' }}">{{ date('d/m/Y', strtotime($venta->fecha_plazo)) }}</td>
                </tr>

              @endforeach
              {!! Form::close() !!}
            </tbody>
            <tfoot>
              <tr>
                <th class="text-right" colspan="6">TOTAL ADEUDO</th>
                <th class="text-right" colspan="1">${{ number_format(($cliente->adeudo > 0)?$cliente->adeudo:0,2,'.',',') }}</th>
                <th></th>
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
              <td class="text-right">${{ number_format(($cliente->adeudo > 0)?$cliente->adeudo:0,2,'.',',') }}</td>
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
        <h4 class="modal-title"><i class="fa fa-hand-holding-usd"></i> Abono</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
          <span class="sr-only">Close</span>
        </button>
      </div>

      {!! Form::open(array('action' => 'ApartadoController@agregar_abono','class'=>'form','role'=>'form','files'=>'true')) !!}  
      {!! Form::hidden('_token', csrf_token(),array('id'=>'token')) !!}
      <div class="modal-body">
        <div class="form-group">
          {!! Form::label('abono', 'Cantidad :', ['class'=>'control-label']) !!}

          {!! Form::number('abono', null, ['min'=>1, 'class'=>'form-control','step'=>'any','required']) !!}
        </div>

        {!! Form::hidden('clientes_id', $cliente->id, []) !!}
        {!! Form::hidden('formulario', 'abono', []) !!}
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

{{-- Modal reembolso --}}
<div class="modal fade" id="modalReembolso">
  <div class="modal-dialog modal-sm" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title"><i class="far fa-frown"></i> Reembolso</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
          <span class="sr-only">Close</span>
        </button>
      </div>

      {!! Form::open(array('action' => 'ApartadoController@agregar_abono','class'=>'form','role'=>'form','files'=>'true')) !!}  
      {!! Form::hidden('_token', csrf_token(),array('id'=>'token')) !!}
      <div class="modal-body">
        <div class="form-group">
          {!! Form::label('abono', 'Cantidad :', ['class'=>'control-label']) !!}

          {!! Form::number('abono', null, ['min'=>0, 'max'=>$cliente->a_favor,'class'=>'form-control','step'=>'any','required']) !!}
        </div>

        {!! Form::hidden('clientes_id', $cliente->id, []) !!}
        {!! Form::hidden('formulario', 'reembolso', []) !!}
      </div>

      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal"><i class="fa fa-times"></i> Cancelar</button>
        <button type="submit" class="btn btn-primary"><i class="fa fa-minus"></i> Reembolsar</button>
      </div>
      {!! Form::close() !!}

    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
{{-- /Modal reembolso --}}

{{-- Modal apartar --}}
<div class="modal fade" id="modalApartar" role="dialog" aria-labelledby="modalApartar">
  <div class="modal-dialog ">
    <div class="modal-content">
      <div class="modal-header" style="background-color: #f5f5f5">
        <h4 class="modal-title" id="myModalLabel"><i class="fas fa-cart-plus"></i> Apartar producto</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
      </div>

      {!! Form::open(array('action' => 'ApartadoController@apartar','class'=>'form','role'=>'form','files'=>'true')) !!}      

      <div class="modal-body">

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

        {!! Form::hidden('clientes_id', $cliente->id, ['style'=>'width: 0px;']) !!}

      </div>

      <div class="modal-footer">
        <button type="button" class="btn bg-grey waves-effect" data-dismiss="modal"> 
          <i class="fa fa-times"></i>
          <span>Cancelar</span>
        </button>

        <button type="submit" class="btn btn-primary" id="grabar", secure = null>
          <i class="fas fa-people-carry"></i>
          <span>Apartar</span>
        </button>
      </div>
      {!! Form::close()!!}
    </div>
  </div>
</div>
{{-- /Modal apartar --}}

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

              select_precio.append('<option val="'+resultado.precio.min+'" selected>'+resultado.precio.min+'</option>');
              select_precio.append('<option val="'+resultado.precio.max+'">'+resultado.precio.max+'</option>');

            });
          }          
        });
    
    });

  </script>

@endsection