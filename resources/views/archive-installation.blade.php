@extends('layouts.app')

@section('content')
  <?php $redirect_url = get_field('product_link_category', 'options'); ?>
  @if($redirect_url)
    <script>window.location.href = '{{ $redirect_url }}';</script>
  @else
    @include('partials.installation-products')
  @endif
@endsection
