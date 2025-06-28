@extends('layouts.main')
@section('title', 'Tambah Meja')
@section('content')

    <div class="container-fluid">
        <h1 class="mb-3">Tambah No Meja</h1>

        <form action="{{ route('tables.store') }}" method="POST">
            @csrf
            <div class="form-group">
                <label>Nama / No Meja</label>
                <input type="text" name="table_number" class="form-control" required value="{{ old('table_number') }}">
            </div>

            <div class="form-group">
                <label class="form-label">Status</label>
                <select name="is_active" class="form-control">
                    <option value="1">Aktif</option>
                    <option value="0">Tidak Aktif</option>
                </select>
            </div>

            <button type="submit" class="btn btn-success">Simpan</button>
            <a href="{{ route('tables.index') }}" class="btn btn-secondary">Kembali</a>
        </form>
    </div>

@endsection