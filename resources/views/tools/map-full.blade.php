@extends('layouts.full')

@section('styles')
@parent
<style type="text/css">#map { height: 100%; }</style>
@endsection

@section('content')
@include('google.map')
@endsection