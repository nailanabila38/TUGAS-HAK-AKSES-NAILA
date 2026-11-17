<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ruang &amp; Fasilitas Sidang</title>
    <link rel="stylesheet" href="{{ asset('style.css') }}">
</head>
<body>

@php
    $bolehTambah = auth()->user()->bisa('ruangan', 'create');
    $bolehEdit   = auth()->user()->bisa('ruangan', 'edit');
    $bolehHapus  = auth()->user()->bisa('ruangan', 'delete');
@endphp

<div class="main">

    <div class="header">
        <div>
            <h1>Ruang &amp; Fasilitas Sidang</h1>
            <p>Kelola data ruang ujian dan fasilitas sidang</p>
        </div>

        <div style="display:flex; gap:10px; align-items:center; white-space:nowrap;">
            @if($bolehTambah)
                <a href="{{ url('/tambah-ruang') }}" class="btn-tambah">
                    + Tambah Ruangan
                </a>
            @endif

            <form method="POST" action="{{ route('logout') }}" style="margin:0;">
                @csrf
                <button type="submit" class="btn-hapus">
                    Logout ({{ auth()->user()->name }})
                </button>
            </form>
        </div>
    </div>

    <div class="statistik">
        <div class="card">
            <p>Total Ruangan</p>
            <h2>{{ $total }}</h2>
        </div>

        <div class="card">
            <p>Ruang Aktif</p>
            <h2>{{ $aktif }}</h2>
        </div>

        <div class="card">
            <p>Memiliki Proyektor</p>
            <h2>{{ $proyektor }}</h2>
        </div>

        <div class="card">
            <p>Memiliki PC</p>
            <h2>{{ $pc }}</h2>
        </div>
    </div>

    <div class="data-container">
        <div class="data-header">
            <h2>Data Ruangan</h2>
        </div>

        <table>
            <thead>
                <tr>
                    <th>No</th>
                    <th>Gedung</th>
                    <th>Nomor Ruang</th>
                    <th>Kapasitas</th>
                    <th>Proyektor</th>
                    <th>PC</th>
                    <th>Status</th>
                    <th>Aksi</th>
                </tr>
            </thead>

            <tbody>
            @if(count($ruangan) > 0)
                <?php $no = 1; ?>
                @foreach($ruangan as $row)
                    <tr>
                        <td>{{ $no++ }}</td>
                        <td>{{ $row->gedung }}</td>
                        <td>{{ $row->nomor_ruang }}</td>
                        <td>{{ $row->kapasitas }} Orang</td>

                        <td class="{{ $row->proyektor === 'Tersedia' ? 'tersedia' : 'tidak' }}">
                            {{ $row->proyektor === 'Tersedia' ? '✓ Tersedia' : '✕ Tidak Ada' }}
                        </td>

                        <td class="{{ $row->pc === 'Tersedia' ? 'tersedia' : 'tidak' }}">
                            {{ $row->pc === 'Tersedia' ? '✓ Tersedia' : '✕ Tidak Ada' }}
                        </td>

                        <td>
                            <span class="status {{ $row->status === 'Aktif' ? 'aktif-status' : 'nonaktif-status' }}">
                                {{ $row->status }}
                            </span>
                        </td>

                        <td>
                            @if($bolehEdit)
                                <a class="btn-edit" href="{{ url('/edit-ruang/' . $row->id) }}">Edit</a>
                            @endif

                            @if($bolehHapus)
                                <form
                                    action="{{ url('/hapus-ruang/' . $row->id) }}"
                                    method="POST"
                                    style="display:inline"
                                    onsubmit="return confirm('Yakin ingin menghapus ruangan ini?');"
                                >
                                    @csrf
                                    @method('DELETE')

                                    <button type="submit" class="btn-hapus">
                                        Hapus
                                    </button>
                                </form>
                            @endif

                            @if(!$bolehEdit && !$bolehHapus)
                                -
                            @endif
                        </td>
                    </tr>
                @endforeach
            @else
                <tr>
                    <td colspan="8" style="text-align:center;">
                        Belum ada data ruangan.
                    </td>
                </tr>
            @endif
            </tbody>
        </table>
    </div>

</div>

</body>
</html>