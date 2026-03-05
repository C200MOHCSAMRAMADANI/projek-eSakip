@extends('layouts.admin')

@section('content')
<div class="container-fluid p-0">
    <div class="d-flex align-items-center mb-4">
        <h4 class="fw-bold mb-0 text-dark">Galeri Foto 2026</h4>
        <span class="text-muted ms-2 small">(ADMIN)</span>
    </div>

    <div class="card border-0 shadow-sm rounded-3">
        <div class="card-body p-4">
            
            <div class="mb-4">
                <button class="btn btn-primary btn-sm px-3 shadow-sm">
                    TAMBAH
                </button>
            </div>

            <div class="table-responsive">
                <table class="table table-bordered table-hover align-middle">
                    <thead class="table-light">
                        <tr class="small text-uppercase">
                            <th class="text-center" width="5%">#</th>
                            <th>Judul Foto</th>
                            <th>Album</th>
                            <th>Keterangan</th>
                            <th class="text-center">Gambar</th>
                            <th class="text-center" width="15%">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($galleries as $index => $row)
                        <tr>
                            <td class="text-center">{{ $index + 1 }}</td>
                            <td>{{ $row->jdl_gallery }}</td>
                            <td>
                                <span class="badge bg-info text-dark">{{ $row->jdl_album ?? 'Tanpa Album' }}</span>
                            </td>
                            <td>{{ \Illuminate\Support\Str::limit($row->keterangan, 50) }}</td>
                            <td class="text-center">
                                @if($row->gbr_gallery)
                                    <img src="{{ asset('storage/'.$row->gbr_gallery) }}" width="50" class="rounded shadow-sm">
                                @else
                                    <span class="text-muted small">Kosong</span>
                                @endif
                            </td>
                            <td class="text-center">
                                <button class="btn btn-sm btn-warning text-white"><i class="fas fa-edit"></i></button>
                                <button class="btn btn-sm btn-danger"><i class="fas fa-trash"></i></button>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="text-center py-5 text-muted">
                                <i class="fas fa-images fa-3x mb-3 opacity-25"></i>
                                <p>Belum ada foto di galeri.</p>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection