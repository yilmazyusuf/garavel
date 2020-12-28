@extends('adminlte::layouts.errors')

@section('trace', null)
@section('title', __('Forbidden'))
@section('code', '403')
@section('message', __($exception->getMessage() ?: 'Forbidden'))
