@extends('layouts.app')

@section('content')
<h1 class="text-2xl font-semibold mb-4">Edit Event</h1>
<form method="POST" action="{{ route('events.update', $event) }}" enctype="multipart/form-data"
      class="bg-white p-6 rounded-2xl shadow">
  @csrf
  @method('PUT')
  @include('events._form')
</form>
@endsection
