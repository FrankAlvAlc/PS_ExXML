@extends('layout')

@section('MenuPrincipal')
	@php
	  echo $MenuPrincipal
	@endphp
@stop


@section('customScript')
<script>
  jQuery(document).ready(function() {
    Main.init();

  });
</script>
@stop
