@extends('layouts.app')

@section('content')
<h1 class="text-2xl font-semibold mb-4">Buat Event</h1>
<form method="POST" action="{{ route('events.store') }}" enctype="multipart/form-data"
      class="bg-white p-6 rounded-2xl shadow">
  @include('events._form')
</form>
@endsection
