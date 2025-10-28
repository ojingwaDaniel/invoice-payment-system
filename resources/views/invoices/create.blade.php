@extends('layouts.app')
@section('content')
    @include('invoices.form', ['action'=>route('invoice.store')])
@endsection
