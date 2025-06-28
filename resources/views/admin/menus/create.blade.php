@extends('layouts.main')
@section('title', 'Tambah Menu')
@section('content')

    <div class="container-fluid">
        <h1 class="mb-3">Tambah Menu</h1>
        @if($errors->any())
            <div class="alert alert-danger">
                <ul class="mb-0">
                    @foreach($errors->all() as $err)
                        <li>{{ $err }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('menus.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <div class="form-group">
                <label>Nama</label>
                <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" required
                    value="{{ old('name') }}">
                @error('name')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label>Kategori</label>
                <select name="category_id" class="form-control @error('category_id') is-invalid @enderror" required>
                    <option value="">-- Pilih Kategori --</option>
                    @foreach($categories as $cat)
                        <option value="{{ $cat->id }}" {{ old('category_id') == $cat->id ? 'selected' : '' }}>
                            {{ $cat->name }}
                        </option>
                    @endforeach
                </select>
                @error('category_id')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label>Harga</label>
                <input type="number" name="price" class="form-control @error('price') is-invalid @enderror" required
                    value="{{ old('price') }}">
                @error('price')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label>Deskripsi</label>
                <textarea name="description"
                    class="form-control @error('description') is-invalid @enderror">{{ old('description') }}</textarea>
                @error('description')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label>Gambar (opsional)</label>
                <input type="file" name="image_url" class="form-control-file @error('image_url') is-invalid @enderror">
                @error('image_url')
                    <div class="text-danger mt-1">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group form-check">
                <input type="hidden" name="is_available" value="0">
                <input type="checkbox" name="is_available" class="form-check-input" value="1" {{ old('is_available', true) ? 'checked' : '' }}>
                <label class="form-check-label">Tersedia</label>
            </div>

            <button class="btn btn-success">Simpan</button>
            <a href="{{ route('menus.index') }}" class="btn btn-secondary">Kembali</a>
        </form>

    </div>
@endsection