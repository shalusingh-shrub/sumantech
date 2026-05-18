@extends('layouts.admin')

@section('title', 'Create Inauguration')
@section('page-title', 'Create Inauguration')

@section('content')
<div class="mb-3">
    <a href="{{ route('admin.dashboard') }}" class="text-decoration-none">Dashboard</a>
    <span class="text-muted mx-1">/</span>
    <a href="{{ route('admin.inaugurations.index') }}" class="text-decoration-none">Inauguration</a>
    <span class="text-muted mx-1">/</span>
    <span class="text-muted">Create</span>
</div>

<h1 class="mb-3" style="font-size:32px;font-weight:800;color:#1f2937;">Create Inauguration</h1>

<form action="{{ route('admin.inaugurations.store') }}" method="POST" enctype="multipart/form-data">
    @csrf
    @include('admin.inaugurations._form', ['buttonText' => 'Create'])
</form>
@endsection
