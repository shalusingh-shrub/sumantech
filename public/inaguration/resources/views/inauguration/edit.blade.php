@extends('layouts.admin')

@section('title', 'Edit Inauguration')

@section('content')
<div class="container">
    <h1>Edit Inauguration</h1>

    <form action="{{ route('inauguration.update', $inauguration) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        @include('inauguration._form', ['buttonText' => 'Update'])
    </form>
</div>
@endsection
