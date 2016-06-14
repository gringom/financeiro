@extends('layouts.app')

@section('title')
Página Principal
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
        font-size: 80px;
    }

    .sub-title {
        font-size: 30px;
    }
</style>
@stop

@section('content')
<div class="row">
    <div class="col-md-10 col-md-offset-1">
        <div class="content">
	        <div class="title">Financeiro.</div>
	        <div class="sub-title">Tuva Editora</div>
            <?php
            if( !Auth::user()->can('view-reports') ){
            ?>
            <p style="margin-top: 25px">Você não tem nenhum acesso concedido.</p><p>Entre em contato com o administrador pedindo acesso.</p>
            <?php
            }
            ?>
		</div>
    </div>
</div>
@stop