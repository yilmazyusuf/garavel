@extends('adminlte::layouts.errors')

@section('title', $exception->getMessage())
@section('code', $exception->getStatusCode())

@section('message',$exception->getMessage())
@section('trace', $exception->getTraceAsString())
