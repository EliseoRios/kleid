@extends('layouts.layout')

@section('title')
  Productos
@endsection

@section('header')
<div class="page-header">
  <h4 class="page-title">Productos</h4>
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
      <a href="{{ url('productos') }}"><i class="fas fa-barcode"></i> Productos</a>
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
        <h4 class="card-title">
          Editar producto > CS #{{ $producto->id }}
          <small> > {{ date('d/m/Y h:i A', strtotime($producto->created_at)) }}</small>
        </h4>
      </div>
    </div>

    <div class="card-body">

      {{-- Caroucel --}}
      <div class="col-md-4 float-left">
        <div id="demo" class="carousel slide" data-ride="carousel">

          <!-- Indicators -->
          <ul class="carousel-indicators">
            @foreach ($imagenes as $index => $imagen)
            <li data-target="#demo" data-slide-to="{{ $index }}" class="{{ ($index == 0)?'active':'' }}"></li>
            @endforeach 
          </ul>

          <!-- The slideshow -->
          <div class="carousel-inner">
            @foreach ($imagenes as $index => $imagen)
            <div class="carousel-item {{ ($index == 0)?'active':'' }}">
              <img src="{{ url('imagen/'.$imagen->id) }}" style="width: 100%;" class="img-fluid" alt="Foto de producto">
            </div>
            @endforeach            
          </div>

          <!-- Left and right controls -->
          <a class="carousel-control-prev" href="#demo" data-slide="prev">
            <span class="carousel-control-prev-icon"></span>
          </a>
          <a class="carousel-control-next" href="#demo" data-slide="next">
            <span class="carousel-control-next-icon"></span>
          </a>

        </div>
      </div>
      {{-- /Caroucel --}}

      {{-- Edicion de producto --}}
      <div class="col-md-8 float-right">
        
      @if (Auth::user()->permiso(['menu',2002]) == 2){{-- $producto->ventas()->count() <= 0 && --}}
      <a class="btn btn-success btn-sm ml-auto" data-toggle="modal" href='#modalResumen' style="margin-top: 25px; color: white;"><i class="fa fa-money-bill-alt"></i> Resumen</a>

      <div align="right" style="margin-top: 25px;">
          <button type="button" class="btn btn-info btn-sm" id="boton_editar" title="Consultar" style="color: white;"><i class="fa fa-edit"></i> Editar</button>          
      </div>
      @endif

      <hr>

      {!! Form::open(array('action' => 'ProductosController@actualizar','class'=>'form','role'=>'form','files'=>'true')) !!}  
        {!! Form::hidden('_token', csrf_token(),array('id'=>'token')) !!}

        <div class="row">
          <div class="form-group col-md-8">
            {!! Form::label('nombre', 'Nombre :',['class'=>'control-label']) !!}

            {!! Form::text('nombre',$producto->nombre,array( 'class' => 'form-control input-readonly', 'placeholder' => 'Descripción del producto','readonly')) !!}
          </div>

          <div class="form-group col-md-4">
            {!! Form::label('codigo', 'Código :',['class'=>'control-label']) !!}

            {!! Form::text('codigo',$producto->codigo,array( 'class' => 'form-control input-readonly', 'placeholder' => 'Código de barras','readonly')) !!}
          </div>          
        </div>

        <div class="row">
          <div class="form-group col-md-4" >
            {!! Form::label('categorias_id', 'Categoría : ',['class'=>'control-label']) !!}

            {!! Form::select('categorias_id',$categorias,$producto->categorias_id,array( 'class' => 'form-control input-disabled','placeholder'=>'-- Seleccionar categoria --','disabled')) !!}
          </div>

          <div class="form-group col-md-4" >
            {!! Form::label('genero', 'Genero : ',['class'=>'control-label']) !!}

            {!! Form::select('genero',$generos,$producto->genero,array( 'class' => 'form-control input-disabled', 'disabled','required')) !!}
          </div>

          <div class="form-group col-md-4" >
            {!! Form::label('piezas', 'Disponibles : ',['class'=>'control-label']) !!}

            {!! Form::number('piezas',$producto->existencia->disponibles,array( 'class' => 'form-control', 'min'=>1,'required','readonly')) !!}
          </div>
        </div>

        <div class="row">
          <div class="form-group col-md-4" >
            {!! Form::label('costo', 'Costo : ',['class'=>'control-label']) !!}

            {!! Form::number('costo',$producto->costo,array( 'class' => 'form-control input-readonly', 'step'=>'any','readonly','required')) !!}
          </div>

          <div class="form-group col-md-4" >
            {!! Form::label('precio', 'Precio : ',['class'=>'control-label']) !!}

            {!! Form::number('precio',$producto->precio,array( 'class' => 'form-control input-readonly', 'step'=>'any','readonly','required')) !!}
          </div>

          <div class="form-group col-md-4" >
            {!! Form::label('precio_minimo', 'Precio mínino : ',['class'=>'control-label']) !!}

            {!! Form::number('precio_minimo',$producto->precio_minimo,array( 'class' => 'form-control input-readonly', 'placeholder'=>'Precio mímino','step'=>'any','readonly','required')) !!}
          </div>
        </div>

        <div class="row">
          <div class="form-group col-md-4">
            {!! Form::label('imagen1', 'Imagen 1 :', ['class'=>'control-label']) !!}
            <input name="imagen1" class="imagen input-disabled" disabled="disabled" type="file" data-preview-file-type="text" >
          </div>

          <div class="form-group col-md-4">
            {!! Form::label('imagen2', 'Imagen 2 :', ['class'=>'control-label']) !!}
            <input name="imagen2" class="imagen input-disabled" disabled="disabled" type="file" data-preview-file-type="text" >
          </div>

          <div class="form-group col-md-4">
            {!! Form::label('imagen3', 'Imagen 3 :', ['class'=>'control-label']) !!}
            <input name="imagen3" class="imagen input-disabled" disabled="disabled" type="file" data-preview-file-type="text" >
          </div>
        </div>

        {!! Form::hidden('id', $producto->id, []) !!}

        <button type="submit" class="btn btn-secondary float-right" style="display: none;" id="grabar", secure = null>
          <i class="fa fa-save"></i>
          <span>Guardar</span>
        </button>
      {!! Form::close()!!}
      </div>
      {{-- /Edicion de producto --}}      

    </div>
  </div>
</div>

{{-- Modal Resumen --}}
<div class="modal fade" id="modalResumen">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title">Resumen</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
          <span class="sr-only">Close</span>
        </button>
      </div>
      <div class="modal-body">

        <table class="table table-sm table-hover">
          <tbody>
            <tr>
              <th>Total compras</th>
              <td>${{ number_format($producto->existencia->total_compras,2,'.',',') }}</td>
            </tr>
            <tr>
              <th>Total ventas</th>
              <td>${{ number_format($producto->existencia->total_ventas,2,'.',',') }}</td>
            </tr> 
            <tr>
              <th>Total comisiones</th>
              <td>${{ number_format($producto->existencia->total_comisiones,2,'.',',') }}</td>
            </tr>                                  
            <tr>
              <th>Total ganancia</th>
              <td>${{ number_format($producto->existencia->total_ganancias,2,'.',',') }}</td>
            </tr>
            <tr>
              <th>Total ganancia neta</th>
              <td>${{ number_format($producto->existencia->total_ganancias_netas,2,'.',',') }}</td>
            </tr>
            <tr>
              <th>Vedidas</th>
              <td>{{ $producto->ventas()->count() }}</td>
            </tr>          
            <tr>
              <th>Disponibles</th>
              <td>{{ $producto->existencia->disponibles }}</td>
            </tr>
          </tbody>
        </table>
        
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal"><i class="fa fa-times"></i> Cerrar</button>
      </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
{{-- /Modal Resumen --}}
@endsection 

@section('script')
  @include('layouts.includes.bootstrap-file-upload')

  <script type="text/javascript">

    $(function(){

        $('.imagen').fileinput({
          language: 'es',
          showUpload: false,
          showCancel: false,
          showRemove: false,
          allowedFileExtensions: ['jpg', 'jpeg','png', 'gif']
        });

        $('#boton_editar').click(function(event) {
          $('.input-disabled').removeAttr('disabled');
          $('.input-readonly').removeAttr('readonly');
          $('#grabar').show();
        });
    
    });

  </script>

@endsection