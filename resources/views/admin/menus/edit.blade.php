@extends('layouts.main')
@section('title', 'Edit Menu')
@section('content')

    <div class="container-fluid">
        <h1 class="mb-3">Edit Menu</h1>

        <form action="{{ route('menus.update', $menu->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="form-group">
                <label>Nama</label>
                <input type="text" name="name" class="form-control @error('name') is-invalid @enderror"
                    value="{{ old('name', $menu->name) }}" required>
                @error('name')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label>Kategori</label>
                <select name="category_id" class="form-control @error('category_id') is-invalid @enderror" required>
                    @foreach($categories as $cat)
                        <option value="{{ $cat->id }}" {{ old('category_id', $menu->category_id) == $cat->id ? 'selected' : '' }}>
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
                <input type="number" name="price" class="form-control @error('price') is-invalid @enderror"
                    value="{{ old('price', $menu->price) }}" required>
                @error('price')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label>Deskripsi</label>
                <textarea name="description"
                    class="form-control @error('description') is-invalid @enderror">{{ old('description', $menu->description) }}</textarea>
                @error('description')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label>Gambar Sekarang</label><br>
                @if($menu->image_url)
                    <img src="{{ asset('storage/' . $menu->image_url) }}" width="100">
                @else
                    <p class="text-muted">Tidak ada gambar</p>
                @endif
            </div>

            <div class="form-group">
                <label>Ganti Gambar</label>
                <input type="file" name="image_url" class="form-control-file @error('image_url') is-invalid @enderror">
                @error('image_url')
                    <div class="text-danger mt-1">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group form-check">
                <input type="hidden" name="is_available" value="0"> {{-- Agar terkirim walau tidak dicentang --}}
                <input type="checkbox" name="is_available" value="1"
                    class="form-check-input @error('is_available') is-invalid @enderror" {{ old('is_available', $menu->is_available) ? 'checked' : '' }}>
                <label class="form-check-label">Tersedia</label>
                @error('is_available')
                    <div class="invalid-feedback d-block">{{ $message }}</div>
                @enderror
            </div>

            <button class="btn btn-success">Update</button>
            <a href="{{ route('menus.index') }}" class="btn btn-secondary">Batal</a>
        </form>

    </div>
@endsection