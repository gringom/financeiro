@extends('layouts.app')

@section('title')
Página Principal
@stop

@section('head')
<style>
    html, body {
        height: 100%;
    }

    body {
        margin: 0;
        padding: 0;
        width: 100%;
        font-weight: 100;
        font-family: 'Lato';
    }

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
		</div>
    </div>
</div>
@stop