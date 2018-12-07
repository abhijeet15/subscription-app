@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <login-component></login-component>
    </div>
</div>
@endsection


@section( 'app' )
<!-- Scripts -->
<script src="{{ asset('js/app.js') }}"></script>
@endsection