@extends('layouts.layout')

@section('title')
  Productos
@endsection

@section('breadcrumb')
  <li><a href=""><i class="material-icons">home</i> Inicio</a></li>
  <li class="breadcrumb-item"><a href="{!! URL::to('productos') !!}"><i class="material-icons">card_giftcard</i> Productos </a> </li>
  <li class="breadcrumb-item active"><i class="fa fa-edit"></i> Editar </li>
@endsection
 
@section('content')
<!-- Tabs With Icon Title -->
<div class="row clearfix">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
      <div class="card">
          <div class="header bg-cyan">
              <h2>
                  {{ $producto->nombre }}
              </h2>
          </div>
          <div class="body">
              
              <dir class="row">

                <div class="col-md-3">

                  <div class="thumbnail">
                      <img class="profile-user-img img-responsive img-circle" src="{{ asset('img/profile-temporal.jpg') }}" alt="User profile picture">
                      <div class="caption">
                          
                          <h3 class="profile-username text-center">{{ $producto->nombre }}</h3>

                          <p class="text-muted text-center">{{ $producto->descripcion or "" }}</p>

                          <ul class="list-group list-group-unbordered">
                            <li class="list-group-item">
                              <b>Disponibles</b> <a class="pull-right">45</a>
                            </li>
                            <li class="list-group-item">
                              <b>Vendidos</b> <a class="pull-right">8</a>
                            </li>
                            <li class="list-group-item">
                              <b>Comprados</b> <a class="pull-right">89</a>
                            </li>
                          </ul>

                          {{-- <a href="#" onclick="return confirm('Desea eliminar?');" class="btn btn-danger btn-block"><b>Dar de baja</b></a> --}}

                      </div>
                  </div>

                </div>

                <div class="col-md-9">
                  <!-- Nav tabs -->
                  <ul class="nav nav-tabs" role="tablist">
                      <li role="presentation" class="active">
                          <a href="#derivados" data-toggle="tab">
                              <i class="material-icons">card_giftcard</i> DERIVADOS
                          </a>
                      </li>
                      <li role="presentation">
                          <a href="#edicion" data-toggle="tab">
                              <i class="material-icons">border_color</i> EDICIÓN
                          </a>
                      </li>
                      <li role="presentation">
                          <a href="#historial" data-toggle="tab">
                              <i class="material-icons">access_time</i> HISTORIAL
                          </a>
                      </li>
                  </ul>

                  <!-- Tab panes -->
                  <div class="tab-content">

                    {{-- Derivados --}}
                    <div role="tabpanel" class="tab-pane fade in active" id="derivados">

                      @if( Auth::user()->permiso(array('menu',2002)) == 2)   
                      <div align="right" style="padding-bottom:20px">

                        <div class="icon-and-text-button-demo">
                          <a class="btn btn-primary btn-xs" data-target="#modalNuevo" data-toggle="modal" id="btnAgregarDerivado" title="Consultar">
                            <i class="material-icons">library_add</i>
                            <span>Agregar</span>
                          </a>
                        </div>

                      </div>
                      @endif

                      <table class="table table-responsive table-inverse" id="dtDetalles">
                        <thead>
                          <tr>
                            <th>Acciones</th>
                            <th>Color</th>
                            <th>Talla</th>
                            <th>Piezas</th>
                            <th>Descripción</th>
                          </tr>
                        </thead>
                        <tbody>
                          <tr>
                            <td></td>
                          </tr>
                        </tbody>
                      </table>
                      
                    </div>

                    {{-- Edición --}}
                    <div role="tabpanel" class="tab-pane fade" id="edicion">
                      @if(Auth::user()->permiso(array('menu',9001)) == 2)
                        <div align="right">
                            <a href="#" class="btn btn-primary btn-xs" id="btnEditarProducto" title="Habilitar edición"><i class="material-icons">edit</i> Editar</a>          
                        </div>
                      @endif

                      {!! Form::open(array('action' => 'ProductosController@actualizar','class'=>'form','role'=>'form')) !!}
                        <div class="form-group" >
                          {!! Form::label('codigo', 'Código :' ,array('class'=>'control-label')) !!}

                          <div class="form-line">
                            {!! Form::text('codigo',$producto->codigo,array( 'class' => 'form-control input-readonly', 'placeholder' => 'Código', 'required', 'readonly')) !!}
                          </div>          
                        </div>

                        <div class="form-group" >
                          {!! Form::label('nombre', 'Nombre :' ,array('class'=>'control-label')) !!}

                          <div class="form-line">
                            {!! Form::text('nombre',$producto->nombre,array( 'class' => 'form-control input-readonly', 'placeholder' => 'Nombre', 'required','readonly')) !!}
                          </div>          
                        </div>

                        <div class="form-group" >
                          {!! Form::label('genero', 'Genero :' ,array('class'=>'control-label')) !!}

                          <div class="form-line">
                            {!! Form::select('genero',[0=>'Unisex', 1=>'Masculino', 2=>'Femenino'],$producto->genero,array( 'class' => 'form-control input-disabled', 'required','disabled')) !!}
                          </div>          
                        </div> 

                        <div class="form-group" >
                          {!! Form::label('costo', 'Costo :' ,array('class'=>'control-label')) !!}

                          <div class="form-line">
                            {!! Form::number('costo',$producto->costo,array( 'class' => 'form-control input-readonly', 'step'=>'any','placeholder' => 'Costo', 'required','readonly')) !!}
                          </div>          
                        </div>   

                        <div class="form-group" >
                          {!! Form::label('precio', 'Precio :' ,array('class'=>'control-label')) !!}

                          <div class="form-line">
                            {!! Form::number('precio',$producto->precio,array( 'class' => 'form-control input-readonly', 'step'=>'any','placeholder' => 'Precio', 'required','readonly')) !!}
                          </div>          
                        </div>

                        <div align="right" class="box-footer">
                          <div class="icon-and-text-button-demo">
                            <button type="submit" class="btn btn-primary"  id="btnGuardar", secure = null style="display:none"> 
                              <i class="material-icons">save</i> 
                              <span>Guardar</span>
                            </button>
                          </div>                    
                        </div>

                        {!! Form::hidden('id',$producto->id)!!}

                      {!! Form::close()!!} 
                    </div>
                    

                    {{-- Historial --}}
                    <div role="tabpanel" class="tab-pane fade" id="historial">
                        <b>Message Content</b>
                        <p>
                            Lorem ipsum dolor sit amet, ut duo atqui exerci dicunt, ius impedit mediocritatem an. Pri ut tation electram moderatius.
                            Per te suavitate democritum. Duis nemore probatus ne quo, ad liber essent aliquid
                            pro. Et eos nusquam accumsan, vide mentitum fabellas ne est, eu munere gubergren
                            sadipscing mel.
                        </p>
                    </div>

                  </div>
                </div>
                
              </dir>

          </div>
      </div>

        
    </div>
</div>
<!-- #END# Tabs With Icon Title -->

<!-- Modal -->
<div class="modal fade" id="modalNuevo" role="dialog" aria-labelledby="modalNuevo">
  <div class="modal-dialog modal-sm">
    <div class="modal-content">
      <div class="modal-header" style="background-color: #f5f5f5">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Agregar detalle</h4>
      </div>

      {!! Form::open(array('action' => 'ProductosController@guardar','class'=>'','role'=>'form')) !!}     

      <div class="modal-body">

        {!! Form::hidden('_token', csrf_token(),array('id'=>'token')) !!}

        <div class="col-md-12">
          <div class="form-group" >
            {!! Form::label('color', 'Color :' ,array('class'=>'control-label')) !!}

            <div class="form-line">
              {!! Form::text('color',null,array( 'class' => 'form-control', 'placeholder' => 'Color', 'required')) !!}
            </div>          
          </div>

          <div class="form-group" >
            {!! Form::label('talla', 'Talla :' ,array('class'=>'control-label')) !!}

            <div class="form-line">
              {!! Form::text('talla',null,array( 'class' => 'form-control', 'placeholder' => 'Talla', 'style'=>'width: 100%;', 'required')) !!}
            </div>          
          </div>

          <div class="form-group" >
            {!! Form::label('piezas_disponibles', 'Piezas :' ,array('class'=>'control-label')) !!}

            <div class="form-line">
              {!! Form::number('piezas_disponibles',null,array( 'class' => 'form-control','placeholder' => 'Número de piezas', 'required')) !!}
            </div>          
          </div>

          <div class="form-group" >
            {!! Form::label('detalles', 'Descripción :' ,array('class'=>'control-label')) !!}

            <div class="form-line">
              {!! Form::textarea('detalles',null,array( 'class' => 'form-control', 'rows'=>3,'placeholder' => 'Descripción de producto', 'required')) !!}
            </div>          
          </div>  

          {!! Form::hidden('formulario', 'detalle', []) !!}
          {!! Form::hidden('productos_id', $producto->id, []) !!}

        </div>

      </div>      

      <div class="modal-footer">
        <button type="button" class="btn bg-grey waves-effect" data-dismiss="modal"> 
          <i class="material-icons" aria-hidden="true">cancel</i>
          <span>Cancelar</span>
        </button>

        <button type="submit" class="btn bg-blue waves-effect" id="grabar", secure = null>
          <i class="material-icons" aria-hidden="true" >save</i> 
          <span>Guardar</span>
        </button>
      </div>
      {!! Form::close()!!}
    </div>
  </div>
</div>

@endsection


@section('script')
  
  @include('layouts.includes.autocomplete')
  @include('layouts.includes.datatables')

  <script type="text/javascript">

    $(function(){
      //Habilitar edicion
      $('#btnEditarProducto').click(function(event) {
        habilitar_edicion();
      });

      function habilitar_edicion(){
        $('#btnGuardar').show();
        $('.input-readonly').removeAttr("readonly");
        $('.input-disabled').removeAttr("disabled",false);
      }

      //Datatable
      $('#dtDetalles').DataTable({
          processing: true,
          serverSide: true,
          ajax: "{!!URL::to('productos/dtdetalles')!!}",
          columns: [
            {data: 'id', name: 'id'},                
            {data: 'color', name: 'color'},                
            {data: 'talla', name: 'talla'},               
            {data: 'piezas_disponibles', name: 'piezas_disponibles'},
            {data: 'detalles', name: 'detalles'}
          ],
          order: [],
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