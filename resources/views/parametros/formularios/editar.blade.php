{!! Form::open(array('action' => 'ParametrosController@actualizar',"class" => "form")) !!}
<div class="modal-body">
	@if(Auth::user()->permiso(array('menu',9002)) == 2 || Auth::user()->departamentos_id == 1)
	<button type="button" id="btnEditar" class="btn btn-xs btn-info pull-right" style="margin: 5px;" title="Editar"><i class="material-icons">edit</i> <span>Editar</span></button>
	<br>
	@endif

	{!! Form::label('identificador', 'Identificador : ', []) !!}
	<div class="form-group">
		<div class="form-line">
			{!! Form::text('identificador',  $parametro->identificador, ['class'=>'form-control input-text', 'readonly','required']) !!}
		</div>
	</div>

	{!! Form::label('nombre', 'Nombre : ', ['class'=>'control-label']) !!}
	<div class="form-group">
		<div class="form-line">
			{!! Form::text('nombre', $parametro->nombre, ['class'=>'form-control input-text', 'readonly','required']) !!}
		</div>
	</div>

	{!! Form::label('valor', 'Valor : ', ['class'=>'control-label']) !!}
	<div class="form-group">
		<div class="form-line">
			{!! Form::number('valor', $parametro->valor, ['class'=>'form-control input-text', 'readonly','required', 'step'=>'any']) !!}			
		</div>
	</div>

	{!! Form::hidden('id', $parametro->id, ['style'=>'width: 0px;']) !!}
</div>
<div class="modal-footer">
	<button type="button" class="btn btn-default" data-dismiss="modal"><i class="material-icons">clear</i> Cerrar</button>
	<button type="submit" class="btn btn-primary" style="display: none;" id="btnGuardar"><i class="material-icons">save</i> Guardar</button>
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