@extends('layouts.app')

@section('content')

<div class="container">
    <div class="row">
        <subcription-component></subcription-component>
        <subcription-listing-component></subcription-listing-component>
        <subcription-delete-component></subcription-delete-component>
    </div>
</div>
@endsection


@section( 'app' )
<!-- Scripts -->
<script src="{{ asset('js/subscription.js') }}"></script>
@endsection