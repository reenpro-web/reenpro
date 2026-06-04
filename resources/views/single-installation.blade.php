@extends('layouts.app')
@section('content')
<script>window.location.href = '{{ get_field("product_link_category", "options") }}';</script>
@endsection
