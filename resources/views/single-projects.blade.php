@extends('layouts.app')
@section('content')
<script>window.location.href = '{{ get_post_type_archive_link("projects") }}';</script>
@endsection
