@extends('layouts.layout')

@section('title')
	Usuarios
@endsection

@section('breadcrumb')
  <li><a href=""><i class="material-icons">home</i> Inicio</a></li>
  <li class="breadcrumb-item"><a href="{!! URL::to('usuarios') !!}"><i class="material-icons">people</i> Usuarios </a> </li>
  <li class="breadcrumb-item active"><i class="fa fa-edit"></i> Editar </li>
@endsection
 
@section('content')
<!-- Tabs With Icon Title -->
<div class="row clearfix">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
      <div class="card">
          <div class="header bg-cyan">
              <h2>
                  {{ $usuario->nombre }}
              </h2>
          </div>
          <div class="body">
              
              <dir class="row">

                <div class="col-md-3">

                  <div class="thumbnail">
                      <img class="profile-user-img img-responsive img-circle" src="{{ asset('img/profile-temporal.jpg') }}" alt="User profile picture">
                      <div class="caption">
                          
                          <h3 class="profile-username text-center">{{ $usuario->nombre }}</h3>

                          <p class="text-muted text-center">{{ $usuario->departamento->nombre or "N/D" }}</p>

                          <ul class="list-group list-group-unbordered">
                            <li class="list-group-item">
                              <b>Ventas</b> <a class="pull-right">45</a>
                            </li>
                            <li class="list-group-item">
                              <b>Clientes</b> <a class="pull-right">8</a>
                            </li>
                            <li class="list-group-item">
                              <b>Poductividad</b> <a class="pull-right">89%</a>
                            </li>
                          </ul>

                          <a href="#" onclick="return confirm('Desea eliminar?');" class="btn btn-danger btn-block"><b>Dar de baja</b></a>

                      </div>
                  </div>

                </div>

                <div class="col-md-9">
                  <!-- Nav tabs -->
                  <ul class="nav nav-tabs" role="tablist">
                      <li role="presentation" class="active">
                          <a href="#perfil" data-toggle="tab">
                              <i class="material-icons">face</i> PERFIL
                          </a>
                      </li>
                      <li role="presentation">
                          <a href="#permisos" data-toggle="tab">
                              <i class="material-icons">dashboard</i> PERMISOS
                          </a>
                      </li>
                      <li role="presentation">
                          <a href="#ventas" data-toggle="tab">
                              <i class="material-icons">store</i> VENTAS
                          </a>
                      </li>
                  </ul>

                  <!-- Tab panes -->
                  <div class="tab-content">

                    {{-- Perfil --}}
                    <div role="tabpanel" class="tab-pane fade in active" id="perfil">
                      @if(Auth::user()->permiso(array('menu',9001)) == 2)
                        <div align="right">
                            <a href="#" class="btn btn-primary btn-xs" id="boton_editar" title="Consultar"><i class="material-icons">edit</i>  </a>          
                        </div>
                      @endif
                      
                      {!! Form::open(array('action' => 'UsuariosController@actualizar','class'=>'form','role'=>'form')) !!}

                      <div class="form-group" >
                        {!! Form::label('Nombre : ',null, array('class'=>'control-label')) !!} 
                        <div class="form-line">

                          {!! Form::text('nombre',$usuario->nombre ,array( 'class' => 'form-control', 'placeholder' => 'Nombre completo del usuario', 'readonly'=>'false')) !!} 
                          <p class="text-danger"> {!! $errors->first('nombre')!!} </p>
                        </div>

                      </div>  

                      <div class="form-group">
                        {!! Form::label('Correo :',null, array('class'=>'control-label')) !!}
                        <div class="form-line">
                          {!! Form::email('email',$usuario->email,array( 'class' => 'form-control','placeholder' => 'Correo Electronico', 'readonly'=>'readonly')) !!}
                          <p class="text-danger"> {!! $errors->first('email')!!} </p>
                        </div>                
                      </div>  

                      <div class="form-group">
                        {!! Form::label('Telefono(s) :',null, array('class'=>'control-label')) !!}
                        <div class="form-line">
                          {!! Form::text('telefonos',$usuario->telefonos,array( 'class' => 'form-control','placeholder' => 'Telefonos', 'readonly'=>'readonly')) !!}
                          <p class="text-danger"> {!! $errors->first('telefonos')!!} </p>
                        </div>                
                      </div>  

                      <div class="form-group">
                        {!! Form::label('Contraseña :', null, array('class'=>'control-label')) !!}
                        <div class="form-line">
                          {!! Form::text('password','',array( 'class' => 'form-control','placeholder' => 'Contraseña', 'readonly'=>'readonly')) !!}
                          <p class="text-danger"> {!! $errors->first('password')!!} </p>
                        </div>

                      </div>

                      <div class="form-group">
                        {!! Form::label('Departamento :', null, array('class'=>'control-label')) !!}

                        <div class="form-line">
                          {!! Form::select('departamentos_id',$departamentos,$usuario->departamentos_id,array( 'class' => 'form-control  show-tick select','placeholder' => '-- Seleccione departamento --', 'disabled'=>'disabled')) !!}
                        </div>
                          <p class="text-danger"> {!! $errors->first('departamentos')!!} </p>
                      </div>

                      {!! Form::hidden('id',$usuario->id)!!}
                      <div align="right" class="box-footer">

                        <div class="icon-and-text-button-demo">
                          <button type="submit" class="btn btn-primary"  id="boton_grabar", secure = null style="display:none"> 
                            <i class="material-icons">save</i> 
                            <span>Guardar</span>
                          </button>
                        </div>
                        
                      </div>

                      {!! Form::close()!!}    
                    </div>

                    {{-- Permisos --}}
                    <div role="tabpanel" class="tab-pane fade" id="permisos">

                      @if( Auth::user()->permiso(array('menu',9001)) == 2)   
                      <div align="right" style="padding-bottom:20px">

                        <div class="btn-group pull-left" id="botonesTodosPermisos" style="display: none;" title="Selección rápida de permisos globales">
                            <button type="button" class="btn btn-success dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                              <i class="material-icons">star</i>
                              Permisos Globales <span class="caret"></span>
                            </button>
                            <ul class="dropdown-menu">
                                <li><a id="btnAccesoTotal"><i class="material-icons">brightness_auto</i> Acceso Total</a></li>
                                <li><a id="btnAccesoLectura"><i class="material-icons">format_align_justify</i> Acceso Lectura</a></li>
                                <li><a id="btnRemoverPermisos"><i class="material-icons">remove_circle</i> Remover permisos</a></li>
                            </ul>
                        </div>

                        <div class="icon-and-text-button-demo">
                          <a class="btn btn-primary btn-xs" id="boton_editar2" title="Consultar">
                            <i class="material-icons">edit</i>
                            <span>Editar</span>
                          </a>
                        </div>    
                      </div>
                      @endif

                      {!! Form::open(array('action' => 'UsuariosController@update_permisos','class'=>'','role'=>'form')) !!}

                      <div class="panel-group" id="accordion_10" role="tablist" aria-multiselectable="true">

                          <?php $elemento= 0;?>
                                
                          @foreach ($menus as $menu)

                          <div class="panel panel-col-cyan">
                              <div class="panel-heading" role="tab" id="headingTwo_10">
                                  <h4 class="panel-title">
                                      <a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion_10" href="##{!! substr($menu->codigo,0,2) !!}" aria-expanded="false" aria-controls="collapseTwo_10">
                                          {!! $menu->area !!}
                                      </a>
                                  </h4>
                              </div>
                              <div id="{!! substr($menu->codigo,0,2) !!}" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingTwo_10">
                                  <div class="panel-body">
                                     
                                     <?php                                     
                                        $opcs   = DB::table('menus')->where( DB::raw('substr(codigo,1,2)'),'=',substr($menu->codigo,0,2) )->select('id','codigo','dependencia','area','opcion','url')->get();                                    
                                     ?>      

                                     @foreach( $opcs as $opc)
                                     {!! Form::label($opc->codigo,$opc->opcion, array()) !!}
                                     <div class="form-line">
                                       {!! Form::select($opc->codigo,$opciones, $usuario->permiso(array('menu',$opc->codigo)) ,array( 'class' => 'form-control opciones', 'disabled'=>'disabled')) !!}
                                     </div>
                                     <?php $elemento  = $elemento + 1; ?>
                                     @endforeach

                                  </div>
                              </div>
                          </div>
                          @endforeach

                          {!! Form::hidden('usuario_id',$usuario->id)!!}

                          <br>

                          <div align="right" class="box-footer">
                            <button type="submit" class="btn btn-primary"  id="boton_grabar2", secure = null style="display:none"> 
                              <i class="material-icons">save</i>
                              <span>Guardar</span>
                            </button>
                          </div>

                      </div>
                      {!! Form::close() !!}
                      
                    </div>

                    {{-- Ventas --}}
                    <div role="tabpanel" class="tab-pane fade" id="ventas">
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
	