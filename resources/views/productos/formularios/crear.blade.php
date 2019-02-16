{!! Form::open(array('action' => 'ParametrosController@guardar',"class" => "form")) !!}
<div class="modal-body">
	{!! Form::label('identificador', 'Identificador : ', []) !!}
	<div class="form-group">
		<div class="form-line">
			{!! Form::text('identificador', null, ['class'=>'form-control input-text', 'readonly','required']) !!}
		</div>
	</div>

	{!! Form::label('nombre', 'Nombre : ', ['class'=>'control-label']) !!}
	<div class="form-group">
		<div class="form-line">
			{!! Form::text('nombre', null, ['class'=>'form-control input-text', 'readonly','required']) !!}
		</div>
	</div>

	{!! Form::label('valor', 'Valor : ', ['class'=>'control-label']) !!}
	<div class="form-group">
		<div class="form-line">
			{!! Form::number('valor', 0, ['class'=>'form-control input-text', 'readonly','required', 'step'=>'any']) !!}			
		</div>
	</div>
</div>
<div class="modal-footer">
	<button type="button" class="btn btn-default" data-dismiss="modal"><i class="fa fa-close"></i> Cerrar</button>
	<button type="submit" class="btn btn-primary"><i class="fa fa-save"></i> Guardar</button>
</div>
{!! Form::close() !!}