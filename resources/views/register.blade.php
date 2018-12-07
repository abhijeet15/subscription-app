@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <register-component></register-component>
    </div>
</div>
@endsection


@section( 'app' )
<!-- Scripts -->
<script src="{{ asset('js/app.js') }}"></script>
@endsection