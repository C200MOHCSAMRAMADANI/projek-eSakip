@extends('layouts.admin')

@section('content')
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/dataTables.bootstrap5.min.css">

<style>
    /* Menghilangkan ikon sorting sesuai permintaan sebelumnya */
    table.dataTable thead .sorting:after, 
    table.dataTable thead .sorting:before { display: none !important; }
    table.dataTable thead th { background-image: none !important; }

    /* Style untuk navigasi internal */
    .nav-pills .nav-link {
        color: #495057;
        border-radius: 8px;
        margin-bottom: 5px;
        transition: all 0.3s;
        font-weight: 500;
        border: 1px solid transparent;
    }
    .nav-pills .nav-link:hover {
        background-color: rgba(13, 110, 253, 0.05);
        color: var(--primary-blue);
    }
    .nav-pills .nav-link.active {
        background-color: var(--primary-blue) !important;
        color: white !important;
        box-shadow: 0 4px 10px rgba(0,0,0,0.1);
    }
</style>

<div class="container-fluid p-0">
    <div class="admin-header-title mb-4">
        <h3 class="fw-bold mb-0 me-3" style="color: var(--primary-blue);">{{ $title }}</h3>
        <span class="text-muted border-start ps-3">Manajemen Dokumen Perencanaan Perangkat Daerah</span>
    </div>

    <div class="row">
        <div class="col-md-3">
    <div class="card border-0 shadow-sm rounded-3 mb-4">
        <div class="card-header bg-white fw-bold border-0 pt-3">
            <i class="fas fa-list me-2"></i> Kategori Dokumen
        </div>
        <div class="card-body p-2">
            <div class="nav flex-column nav-pills" role="tablist">
            <a href="/admin/dokumen/rencana-strategis" class="nav-link {{ Request::is('admin/dokumen/rencana-strategis') ? 'active' : '' }}">
                <i class="fas fa-file-contract me-2 small"></i> Rencana Strategis
            </a>
            <a href="/admin/dokumen/laporan-kinerja" class="nav-link {{ Request::is('admin/dokumen/laporan-kinerja') ? 'active' : '' }}">
                <i class="fas fa-file-invoice me-2 small"></i> Laporan Kinerja (LKJIP)
            </a>
            <a href="/admin/dokumen/rencana-kerja" class="nav-link {{ Request::is('admin/dokumen/rencana-kerja') ? 'active' : '' }}">
                <i class="fas fa-calendar-alt me-2 small"></i> Rencana Kerja
            </a>
            <a href="/admin/dokumen/rencana-aksi" class="nav-link {{ Request::is('admin/dokumen/rencana-aksi') ? 'active' : '' }}">
                <i class="fas fa-tasks me-2 small"></i> Rencana Aksi
            </a>
            <a href="/admin/dokumen/sk-iku" class="nav-link {{ Request::is('admin/dokumen/sk-iku') ? 'active' : '' }}">
                <i class="fas fa-certificate me-2 small"></i> SK-IKU
            </a>
            <a href="/admin/dokumen/ik-program" class="nav-link {{ Request::is('admin/dokumen/ik-program') ? 'active' : '' }}">
                <i class="fas fa-chart-line me-2 small"></i> IK-Program
            </a>
            <a href="/admin/dokumen/perjanjian-kinerja" class="nav-link {{ Request::is('admin/dokumen/perjanjian-kinerja') ? 'active' : '' }}">
                <i class="fas fa-handshake me-2 small"></i> Perjanjian Kinerja
            </a>
            <a href="/admin/dokumen/cascading" class="nav-link {{ Request::is('admin/dokumen/cascading') ? 'active' : '' }}">
                <i class="fas fa-sitemap me-2 small"></i> Cascading Program
            </a>
            <a href="/admin/dokumen/kak" class="nav-link {{ Request::is('admin/dokumen/kak') ? 'active' : '' }}">
                <i class="fas fa-book me-2 small"></i> Kerangka Acuan Kerja
            </a>
        </div>
        </div>
    </div>
</div>

        <div class="col-md-9">
            <div class="card border-0 shadow-sm rounded-3">
                <div class="card-body p-4">
                    <div class="table-responsive">
                        <table id="tableDokumen" class="table table-bordered table-hover align-middle w-100">
                            <thead class="table-light">
                                <tr>
                                    <th class="text-center" width="5%">No</th>
                                    <th>Nama Perangkat Daerah</th>
                                    <th class="text-center">File</th>
                                    <th class="text-center">Tanggal</th>
                                    <th class="text-center" width="10%">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($dokumen as $index => $d)
                                <tr>
                                    <td class="text-center">{{ $index + 1 }}</td>
                                    <td>{{ $d->nama_satker }}</td>
                                    <td class="text-center">
                                        @if($d->file_path)
                                            <a href="{{ asset('storage/' . $d->file_path) }}" target="_blank" class="btn btn-sm btn-outline-danger">
                                                <i class="fas fa-file-pdf me-1"></i> PDF
                                            </a>
                                        @else
                                            <span class="text-muted small">Kosong</span>
                                        @endif
                                    </td>
                                    <td class="text-center">
                                        {{ $d->update_at ? date('d-m-Y', strtotime($d->update_at)) : date('d-m-Y', strtotime($d->create_at)) }}
                                    </td>
                                    <td class="text-center">
                                        <button class="btn btn-sm btn-warning text-white"><i class="fas fa-edit"></i></button>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.4/js/dataTables.bootstrap5.min.js"></script>

<script>
    $(document).ready(function() {
        $('#tableDokumen').DataTable({
            "ordering": false,
            "language": {
                "lengthMenu": "Show _MENU_",
                "search": "Cari Satker:",
                "paginate": { "next": ">", "previous": "<" }
            }
        });
    });
</script>
@endsection