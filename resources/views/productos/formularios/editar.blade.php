{!! Form::open(array('action' => 'ParametrosController@actualizar',"class" => "form")) !!}
<div class="modal-body">
	@if(Auth::user()->permiso(array('menu',9002)) == 2 || Auth::user()->departamentos_id == 1)
	<button type="button" id="btnEditar" class="btn btn-xs btn-info pull-right" style="margin: 5px;" title="Editar"><i class="fa fa-edit"></i> <span>Editar</span></button>
	<br>
	@endif

	{!! Form::label('identificador', 'Identificador : ', []) !!}
	<div class="form-group">
		{!! Form::text('identificador',  $parametro->identificador, ['class'=>'form-control input-text', 'readonly','required']) !!}
	</div>

	{!! Form::label('nombre', 'Nombre : ', ['class'=>'control-label']) !!}
	<div class="form-group">
		{!! Form::text('nombre', $parametro->nombre, ['class'=>'form-control input-text', 'readonly','required']) !!}
	</div>

	{!! Form::label('valor', 'Valor : ', ['class'=>'control-label']) !!}
	<div class="form-group">
		{!! Form::number('valor', $parametro->valor, ['class'=>'form-control input-text', 'readonly','required', 'step'=>'any']) !!}
	</div>

	{!! Form::hidden('id', $parametro->id, ['style'=>'width: 0px;']) !!}
</div>
<div class="modal-footer">
	<button type="button" class="btn btn-default" data-dismiss="modal"><i class="fas fa-times"></i>  Cerrar</button>
	<button type="submit" class="btn btn-primary" style="display: none;" id="btnGuardar"><i class="fa fa-save"></i> Guardar</button>
</div>
{!! Form::close() !!}

<script>
$(function(){
	$('#btnEditar').click(function(){
		$('.input-text').removeAttr('readonly');
		$('#btnGuardar').show();
	});
});
</script>