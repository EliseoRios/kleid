{!! Form::open(array('action' => 'CategoriasController@guardar','class'=>'','role'=>'form')) !!}	

<div class="modal-body">

	{!! Form::hidden('_token', csrf_token(),array('id'=>'token')) !!}

	<div class="form-group" >
		{!! Form::label('Categoría : ', null ,['class'=>'control-label']) !!}

		{!! Form::text('categoria','',array( 'class' => 'form-control', 'placeholder' => 'Categoría','autocomplete'=>'off','required')) !!} 
		<p class="text-danger">	{!! $errors->first('categoria')!!} </p>
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