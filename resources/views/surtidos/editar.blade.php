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
        Surtidos
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
        <h4 class="card-title">Productos <small>> {{ date('d/m/Y h:i A', strtotime($surtido->created_at)) }}</small></h4>

        @if (Auth::user()->permiso(array('menu',9001)) == 2 ) 
        <a href="" data-target="#modalNuevo" data-toggle="modal" class="btn btn-primary btn-round ml-auto" title="Agregar" style="color: white;">
            <i class="fa fa-plus"></i>
            Agregar
        </a>
          @endif
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

<!-- Modal -->
<div class="modal fade" id="modalNuevo" role="dialog" aria-labelledby="modalNuevo">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header" style="background-color: #f5f5f5">
        <h4 class="modal-title" id="myModalLabel">Agregar producto</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
      </div>

      {!! Form::open(array('action' => 'ProductosController@guardar','class'=>'','role'=>'form','files'=>'true')) !!}      

      <div class="modal-body">

        {!! Form::hidden('_token', csrf_token(),array('id'=>'token')) !!}

        <div class="row">
          <div class="form-group col-md-8">
            {!! Form::label('nombre', 'Nombre :',['class'=>'control-label']) !!}

            {!! Form::text('nombre','',array( 'class' => 'form-control', 'placeholder' => 'Descripción del producto')) !!}
          </div>

          <div class="form-group col-md-4" >
            {!! Form::label('piezas', 'Piezas : ',['class'=>'control-label']) !!}

            {!! Form::number('piezas',1,array( 'class' => 'form-control', 'min'=>1,'required')) !!}
          </div>
        </div>

        <div class="row">
          <div class="form-group col-md-4" >
            {!! Form::label('genero', 'Genero : ',['class'=>'control-label']) !!}

            {!! Form::select('genero',$generos,'f',array( 'class' => 'form-control', 'required')) !!}
          </div>

          <div class="form-group col-md-4" >
            {!! Form::label('talla', 'Talla : ',['class'=>'control-label']) !!}

            {!! Form::text('talla','',array( 'class' => 'form-control', 'list'=>'tallas','autocomplete'=>'off','placeholder' => '')) !!}

            <datalist id="tallas">
            @foreach ($tallas as $talla)
              <option value="{{ $talla }}"></option>
            @endforeach
            </datalist>
          </div>

          <div class="form-group col-md-4" >
            {!! Form::label('color', 'Color : ',['class'=>'control-label']) !!}

            {!! Form::text('color','',array( 'class' => 'form-control', 'list'=>'colores','autocomplete'=>'off','placeholder' => '')) !!}
            
            <datalist id="colores">
            @foreach ($colores as $color)
              <option value="{{ $color }}"></option>
            @endforeach
            </datalist>
          </div>
        </div>

        <div class="row">
          <div class="form-group col-md-4" >
            {!! Form::label('costo', 'Costo : ',['class'=>'control-label']) !!}

            {!! Form::number('costo',0,array( 'class' => 'form-control', 'step'=>'any','required')) !!}
          </div>

          <div class="form-group col-md-4" >
            {!! Form::label('precio', 'Precio : ',['class'=>'control-label']) !!}

            {!! Form::number('precio',0,array( 'class' => 'form-control', 'step'=>'any','required')) !!}
          </div>

          <div class="form-group col-md-4" >
            {!! Form::label('precio_minimo', 'Precio mínino : ',['class'=>'control-label']) !!}

            {!! Form::number('precio_minimo',0,array( 'class' => 'form-control', 'placeholder'=>'Precio mímino','step'=>'any','required')) !!}
          </div>
        </div>

        <div class="row">
          <div class="form-group col-md-4">
            {!! Form::label('imagen1', 'Imagen 1 :', ['class'=>'control-label']) !!}
            <input name="imagen1" class="imagen" type="file" data-preview-file-type="text" >
          </div>

          <div class="form-group col-md-4">
            {!! Form::label('imagen2', 'Imagen 2 :', ['class'=>'control-label']) !!}
            <input name="imagen2" class="imagen" type="file" data-preview-file-type="text" >
          </div>

          <div class="form-group col-md-4">
            {!! Form::label('imagen3', 'Imagen 3 :', ['class'=>'control-label']) !!}
            <input name="imagen3" class="imagen" type="file" data-preview-file-type="text" >
          </div>
        </div>

        {!! Form::hidden('surtidos_id', $surtido->id, []) !!}

      </div>

      <div class="modal-footer">
        <button type="button" class="btn bg-grey waves-effect" data-dismiss="modal"> 
          <i class="fa fa-times"></i>
          <span>Cancelar</span>
        </button>

        <button type="submit" class="btn btn-primary" id="grabar", secure = null>
          <i class="fa fa-save"></i>
          <span>Guardar</span>
        </button>
      </div>
      {!! Form::close()!!}
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
            ajax: "{!!URL::to('productos/datatables/'.$surtido->id)!!}",
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
