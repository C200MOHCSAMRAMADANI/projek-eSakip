@extends('layouts.admin')

@section('content')
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/dataTables.bootstrap5.min.css">

<style>
    /* Menyesuaikan tampilan agar sesuai dengan tema eSAKIP */
    .dataTables_wrapper .dataTables_paginate .page-item.active .page-link {
        background-color: var(--primary-blue);
        border-color: var(--primary-blue);
    }
    .dataTables_filter input {
        border-radius: 20px;
        padding: 5px 15px;
        border: 1px solid #ddd;
    }
    .dataTables_length select {
        border-radius: 10px;
    }
</style>

<div class="container-fluid p-0">
    <div class="admin-header-title mb-4">
        <h3 class="fw-bold mb-0 me-3" style="color: var(--primary-blue);">Data Pengguna</h3>
        <span class="text-muted border-start ps-3">Manajemen Akun Master & OPD</span>
    </div>

    <div class="card border-0 shadow-sm rounded-3">
        <div class="card-body p-4">
            
            <div class="mb-4">
                <button class="btn btn-primary shadow-sm">
                    <i class="fas fa-plus me-1"></i> Tambah Pengguna
                </button>
            </div>

            <div class="table-responsive">
                <table id="tablePengguna" class="table table-bordered table-hover align-middle w-100">
                    <thead class="table-light">
                        <tr>
                            <th class="text-center" width="5%">No</th>
                            <th>Nama OPD / Satker</th>
                            <th>Username</th>
                            <th>Level</th>
                            <th>ID OPD</th>
                            <th class="text-center">Status</th>
                            <th class="text-center" width="10%">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($pengguna ?? [] as $index => $p)
                        <tr>
                            <td class="text-center">{{ $index + 1 }}</td>
                            <td>{{ $p->nama_satker ?? $p->nama_lengkap ?? '-' }}</td>
                            <td>{{ $p->username }}</td>
                            <td>
                                @if($p->level == 'admin')
                                    <span class="badge bg-danger">Admin</span>
                                @elseif($p->level == 'moderator')
                                    <span class="badge bg-warning text-dark">Moderator</span>
                                @else
                                    <span class="badge bg-secondary">{{ ucfirst($p->level ?? 'Client') }}</span>
                                @endif
                            </td>
                            <td>{{ $p->id_opd ?? '-' }}</td>
                            <td class="text-center">
                                @if(strtolower($p->status) == 'aktif')
                                    <span class="badge bg-success">Aktif</span>
                                @else
                                    <span class="badge bg-danger">Tidak Aktif</span>
                                @endif
                            </td>
                            <td class="text-center">
                                <button class="btn btn-sm btn-warning text-white shadow-sm" title="Edit Data">
                                    <i class="fas fa-edit"></i> Edit
                                </button>
                            </td>
                        </tr>
                        @empty
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.4/js/dataTables.bootstrap5.min.js"></script>

<script>
    $(document).ready(function() {
        $('#tablePengguna').DataTable({
            "ordering": false, // Menghapus fungsi pengurutan di semua kolom
            "columnDefs": [
                { "orderable": false, "targets": "_all" } // Memastikan ikon panah hilang
            ],
            "language": {
                "lengthMenu": "Tampilkan _MENU_ data per halaman",
                "zeroRecords": "Data tidak ditemukan",
                "info": "Menampilkan halaman _PAGE_ dari _PAGES_",
                "infoEmpty": "Tidak ada data tersedia",
                "infoFiltered": "(disaring dari _MAX_ total data)",
                "search": "Cari:",
                "paginate": {
                    "first": "Pertama",
                    "last": "Terakhir",
                    "next": "Selanjutnya",
                    "previous": "Sebelumnya"
                }
            },
            "pageLength": 10
        });
    });
</script>
<style>
    /* Menghilangkan ikon panah sorting DataTables */
    table.dataTable thead .sorting:after,
    table.dataTable thead .sorting:before,
    table.dataTable thead .sorting_asc:after,
    table.dataTable thead .sorting_asc:before,
    table.dataTable thead .sorting_desc:after,
    table.dataTable thead .sorting_desc:before {
        display: none !important;
    }
    
    table.dataTable thead th {
        background-image: none !important;
    }
</style>
@endsection