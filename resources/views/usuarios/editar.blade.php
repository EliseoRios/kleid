@extends('layouts.layout')

@section('title')
	Usuarios
@endsection

@section('header')
<div class="page-header">
  <h4 class="page-title">Usuarios</h4>
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
      <a href="{{ url('usuarios') }}">Usuarios</a>
    </li>
    <li class="separator">
      <i class="flaticon-right-arrow"></i>
    </li>
    <li class="nav-item">
      <a>
        Editar
      </a>
    </li>
  </ul>
</div>
@endsection
 
@section('content')

<div class="col-md-10 offset-1">

  <div class="card">
    <div class="card-header card-primary">
      Editar > {{ $usuario->nombre }}
    </div>
    <div class="card-body">

      {{-- Perfil --}}
        @if(Auth::user()->permiso(array('menu',9001)) == 2)
          <div align="right">
              <a href="#" class="btn btn-secondary btn-xs" id="boton_editar" title="Consultar" style="color: white;"><i class="fa fa-edit"></i>  </a>          
          </div>
        @endif
        
        {!! Form::open(array('action' => 'UsuariosController@actualizar','class'=>'form','role'=>'form')) !!}

        <div class="row">
          <div class="form-group col-md-4" >
            {!! Form::label('Nombre : ',null, array('class'=>'control-label')) !!} 

            {!! Form::text('nombre',$usuario->nombre ,array( 'class' => 'form-control', 'placeholder' => 'Nombre completo del usuario', 'readonly'=>'false')) !!} 
            <p class="text-danger"> {!! $errors->first('nombre')!!} </p>
          </div>  

          <div class="form-group col-md-4">
            {!! Form::label('Correo :',null, array('class'=>'control-label')) !!}

            {!! Form::email('email',$usuario->email,array( 'class' => 'form-control','placeholder' => 'Correo Electronico', 'readonly'=>'readonly')) !!}
              <p class="text-danger"> {!! $errors->first('email')!!} </p>
          </div>  

          <div class="form-group col-md-4">
            {!! Form::label('Telefono(s) :',null, array('class'=>'control-label')) !!}

            {!! Form::text('telefonos',$usuario->telefonos,array( 'class' => 'form-control','placeholder' => 'Telefonos', 'readonly'=>'readonly')) !!}
            <p class="text-danger"> {!! $errors->first('telefonos')!!} </p>
          </div>
        </div>          

        <div class="form-group">
          {!! Form::label('Contraseña :', null, array('class'=>'control-label')) !!}

          {!! Form::text('password','',array( 'class' => 'form-control','placeholder' => 'Contraseña', 'readonly'=>'readonly')) !!}
          <p class="text-danger"> {!! $errors->first('password')!!} </p>
        </div>

        <div class="form-group">
          {!! Form::label('Perfil :', null, array('class'=>'control-label')) !!}

          {!! Form::select('perfiles_id',$perfiles,$usuario->perfiles_id,array( 'class' => 'form-control  show-tick select','placeholder' => '-- Seleccione perfil --', 'disabled'=>'disabled')) !!}
          <p class="text-danger"> {!! $errors->first('perfiles_id')!!} </p>
        </div>

        {!! Form::hidden('id',$usuario->id)!!}

        <div align="right" class="box-footer">

          <div class="icon-and-text-button-demo">
            <button type="submit" class="btn btn-primary"  id="boton_grabar", secure = null style="display:none"> 
              <i class="fa fa-save"></i> 
              Guardar
            </button>
          </div>
          
        </div>

        {!! Form::close()!!}
      {{-- /Perfil --}}

    </div>
  </div>

  {{-- Card permisos --}}
  <div class="card">
    <div class="card-header card-primary">
      Permisos
    </div>
    <div class="card-body">
      
        @if( Auth::user()->permiso(array('menu',9001)) == 2)   
        <div align="right" style="padding-bottom:20px">

          <div class="dropdown open float-left" id="botonesTodosPermisos" style="display: none;" title="Selección rápida de permisos globales">
            <button class="btn btn-success dropdown-toggle" type="button" id="dropdownMenu1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
              <i class="fa fa-star"></i>
              Permisos Globales
            </button>
            <div class="dropdown-menu" aria-labelledby="dropdownMenu1">
              <a class="dropdown-item" id="btnAccesoTotal">Acceso Total</a>
              <a class="dropdown-item" id="btnAccesoLectura">Acceso Lectura</a>
              <a class="dropdown-item" id="btnRemoverPermisos">Remover permisos</a>
            </div>
          </div>

          <a href="" class="btn btn-secondary btn-sm" id="boton_editar2" title="Consultar" style="color: white;">
            <i class="fa fa-edit"></i>
            Editar
          </a> 
        </div>
        @endif

        {{-- Acordion permisos --}}
        {!! Form::open(array('action' => 'UsuariosController@update_permisos','class'=>'','role'=>'form')) !!}

          <div id="accordion" role="tablist" aria-multiselectable="true">

            <?php $elemento= 0;?>
                  
            @foreach ($menus as $menu)
            <div class="card">
              <a data-toggle="collapse" data-parent="#accordion" href="#{!! substr($menu->codigo,0,2) !!}" aria-expanded="true" aria-controls="menuid">
                <div class="card-header card-info" role="tab" id="headingOne">
                  {!! $menu->area !!}
                </div>
              </a>
              <div id="{!! substr($menu->codigo,0,2) !!}" class="card-body collapse in" role="tabpanel" aria-labelledby="headingOne">

                <?php                                     
                  $opcs   = DB::table('menus')->where( DB::raw('substr(codigo,1,2)'),'=',substr($menu->codigo,0,2) )->select('id','codigo','dependencia','area','opcion','url')->get();
                ?>

                @foreach( $opcs as $opc)
                <div class="form-group">
                  {!! Form::label($opc->codigo,$opc->opcion, array()) !!}

                  {!! Form::select($opc->codigo,$opciones, $usuario->permiso(array('menu',$opc->codigo)) ,array( 'class' => 'form-control opciones', 'disabled'=>'disabled')) !!}
                  <?php $elemento  = $elemento + 1; ?>
                </div>
                @endforeach

              </div>
            </div>
            @endforeach

            {!! Form::hidden('usuario_id',$usuario->id)!!}

          </div>

          <div align="right" class="box-footer">
            <button type="submit" class="btn btn-primary"  id="boton_grabar2", secure = null style="display:none"> 
              <i class="fa fa-save"></i>
              Guardar
            </button>
          </div>

        {!! Form::close() !!}
        {{-- /Acordion permisos --}}
        
      </div>

    </div>
  </div>
  {{-- /Card permisos --}}

</div>
@endsection


@section('script')
	
	@include('layouts.includes.autocomplete')

	<script type="text/javascript">

		$(function(){ 

			//Deshabilitar Selects al recargar
			$('#grupo').prop("disabled", true);
			$('#proceso').prop("disabled", true);
			$('#puesto').prop("disabled", true);

		 	//Boton Permiso Total
		 	var btnAccesoTotal = $('#btnAccesoTotal');
		 	var btnAccesoLectura = $('#btnAccesoLectura');
		 	var btnRemoverPermisos = $('#btnRemoverPermisos');

		 	$('#boton_editar2').click(function(event) {
		        event.preventDefault();
		        $('#boton_grabar2').show();
		        $('.opciones').removeAttr("disabled",false);			        
		        $('#botonesTodosPermisos').show();
		    });

		    btnAccesoTotal.click(function(event) {
		       	$('.opciones').val(2);
		    });

		    btnAccesoLectura.click(function(event) {
		       	$('.opciones').val(1);
		    });

		    btnRemoverPermisos.click(function(event) {
			    $('.opciones').val(0);
		    });

			//Acciones si pertenece a junta
			$('#boton_editar').click(function(event) {

				event.preventDefault();
				$('#boton_grabar').show();
				//$('#boton_editar').hide();

				$('.select').removeAttr("disabled");

				$('input[name="nombre"]').prop("readonly", false);
				$('input[name="email"]').prop("readonly", false);
				$('input[name="password"]').prop("readonly", false);
				$('input[name="puesto"]').prop("readonly", false);
				$('#grupo').prop("disabled", false);
				$('#proceso').prop("disabled", false);
				$('#puesto').prop("disabled", false);
				$('input[name="pertenece_junta"]').prop("disabled",false);
				$('input[name="puesto_junta"]').prop("readonly",false);
				$('input[name="smtp_usuario"]').prop("readonly", false);
				$('input[name="smtp_pass"]').prop("readonly", false);
				$('input[name="smtp_port"]').prop("readonly", false);
				$('input[name="smtp_server"]').prop("readonly", false);
				$('input[name="telefonos"]').prop("readonly", false);

				$('#smtp_security').removeAttr("readonly");
				$('#smtp_security').removeAttr("disabled");

				$('.empresas_id').removeAttr("disabled",false);

			});

		});
	</script>
@endsection
	