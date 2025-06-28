@extends('layouts.main')
@section('title', 'Kategori Menu')
@section('content')

    <div class="container-fluid">
        <h1 class="mb-3">Kategori Menu</h1>

        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        <a href="{{ route('tables.create') }}" class="btn btn-primary mb-3">+ Tambah Meja</a>

        <table class="table table-bordered table-hover">
            <thead>
                <tr>
                    <th>Nama</th>
                    <th>Status</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($tables as $table)
                    <tr>
                        <td>{{ $table->table_number }}</td>
                        <td>
                            <span class="badge {{ $table->is_active ? 'badge-success' : 'badge-danger' }}">
                                {{ $table->is_active ? 'Aktif' : 'Tidak Aktif' }}
                            </span>
                        </td>
                        <td>
                            <a href="{{ route('tables.edit', $table->id) }}" class="btn btn-warning btn-sm">Edit</a>
                            <form action="{{ route('tables.destroy', $table->id) }}" method="POST" class="d-inline"
                                onsubmit="return confirm('Yakin ingin menghapus?')">
                                @csrf @method('DELETE')
                                <button class="btn btn-danger btn-sm">Hapus</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="3">Belum ada Meja.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>

        {{ $tables->links() }}
    </div>

@endsection