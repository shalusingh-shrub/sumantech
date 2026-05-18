@extends('layouts.admin')

@section('title', 'Create Inauguration')

@section('content')
<div class="container">
    <h1>Create Inauguration</h1>

    <form action="{{ route('inauguration.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        @include('inauguration._form', ['buttonText' => 'Create'])
    </form>
</div>
@endsection
