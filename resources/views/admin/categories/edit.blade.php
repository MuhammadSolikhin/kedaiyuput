@extends('layouts.main')
@section('title', 'Edit Kategori')
@section('content')

    <div class="container-fluid">
        <h1 class="mb-3">Edit Kategori</h1>

        <form action="{{ route('categories.update', $category->id) }}" method="POST">
            @csrf @method('PUT')
            <div class="form-group">
                <label>Nama Kategori</label>
                <input type="text" name="name" class="form-control" required value="{{ old('name', $category->name) }}">
            </div>

            <div class="form-group">
                <label>Deskripsi</label>
                <textarea name="description"
                    class="form-control">{{ old('description', $category->description) }}</textarea>
            </div>

            <button type="submit" class="btn btn-success">Update</button>
            <a href="{{ route('categories.index') }}" class="btn btn-secondary">Batal</a>
        </form>
    </div>

@endsection