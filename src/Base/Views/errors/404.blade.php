@extends('adminlte::layouts.errors')

@section('title', __('Not Found'))
@section('code', $exception->getStatusCode())

@section('message', 'Aradığınız sayfa bulunamadı !')
@section('trace', null)

