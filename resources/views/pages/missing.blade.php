@extends('layouts.app')

@section('title')
Página Não Encontrada (erro 404)
@stop

@section('head')
<style>
    .content {
        width: 100%;
    	margin-top: 50px;
        text-align: center;
        vertical-align: middle;
    }

    .title {
        font-size: 60px;
    }

    .sub-title {
        margin: 0 auto;
        font-size: 30px;
        max-width: 600px;
    }
</style>
@stop

@section('content')
<div class="row">
    <div class="col-md-10 col-md-offset-1">
        <div class="content">
	        <div class="title">Página Não Encontrada (erro 404)</div>
	        <div class="sub-title">Pode ser que não tenha acesso a essa página, caso for, entre em contato com o administrador do sistema.</div>
		</div>
    </div>
</div>
@stop