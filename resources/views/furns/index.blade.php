@extends('furns.layout.master')

@section('content')

@include('furns.partials.banner')
@include('furns.partials.product-category')
@include('furns.partials.products')
@include('furns.partials.mini-banner')
{{-- @include('furns.partials.blog') --}}
{{-- @include('furns.partials.social-network') --}}
@include('furns.partials.modal-preview-product')

@endsection
