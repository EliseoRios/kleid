@extends('layouts.layout')

@section('title')
	Clientes
@endsection

@section('header')
<div class="page-header">
	<h4 class="page-title">Clientes</h4>
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
			<a><i class="fas fa-user-tag"></i> Clientes</a>
		</li>
	</ul>
</div>
@endsection
 
@section('content')
<div class="col-md-12">
	<div class="card">
		<div class="card-header">
			<div class="d-flex align-items-center">
				<h4 class="card-title">Formatos</h4>
			</div>
		</div>
		<div class="card-body">
			
		    <div class="row">
		    	
		    	<div class="col-md-3">
		    		<a href="{{ url('formatos/venta_libre') }}" target="_blank">
		    			<img src="{{ asset('img/sistema/formatos/venta_libre.png') }}" class="img-fluid img-thumbnail" alt="Responsive image">
		    		</a>
		    	</div>

		    </div>

		</div>
	</div>
</div>

@endsection 

@section('script')

	<script type="text/javascript">

		$(function(){
		
		});

	</script>

@endsection