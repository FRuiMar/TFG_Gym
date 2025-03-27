@extends('errors::minimal')

@section('title', __('Acceso No Autorizado'))
@section('code', '403')
@section('message', __($exception->getMessage() ?: '¡Consulta con el Administrador!'))
