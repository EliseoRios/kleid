{!! Form::open(array('action' => 'ClientesController@guardar','class'=>'','role'=>'form')) !!}	

<div class="modal-body">

	{!! Form::hidden('_token', csrf_token(),array('id'=>'token')) !!}

	<div class="form-group" >
		{!! Form::label('Nombre : ', null ,['class'=>'control-label']) !!}

		{!! Form::text('nombre','',array( 'class' => 'form-control', 'placeholder' => 'Nombre completo del usuario','autocomplete'=>'off','required')) !!} 
		<p class="text-danger">	{!! $errors->first('nombre')!!} </p>
	</div>

	<div class="form-group">
		{!! Form::label('Correo :',null, ['class'=>'control-label']) !!}

		{!! Form::email('email','',array( 'class' => 'form-control','placeholder' => 'Correo electrónico','autocomplete'=>'off','required')) !!}
		<p class="text-danger">	{!! $errors->first('email')!!} </p>
	</div>

	<div class="form-group">
		{!! Form::label('Contraseña :', null, ['class'=>'control-label']) !!}

		{!! Form::text('password','',array( 'class' => 'form-control','placeholder' => '*******','autocomplete'=>'off','required')) !!}
		<p class="text-danger">	{!! $errors->first('password')!!} </p>
	</div>
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