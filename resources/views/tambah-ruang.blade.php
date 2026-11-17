<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Ruangan</title>
    <link rel="stylesheet" href="{{ asset('style.css') }}">
</head>
<body>

<div class="halaman-tambah">
    <div class="form-box">
        <h1>Tambah Ruangan</h1>

        <p class="subjudul">
            Masukkan data ruangan dan fasilitas sidang
        </p>

        @if(session('error'))
            <p style="color:red;">
                {{ session('error') }}
            </p>
        @endif

        <form method="POST" action="{{ url('/tambah-ruang') }}">
            @csrf <!-- Wajib ada di setiap form POST Laravel -->

            <label for="gedung">Gedung</label>
            <input
                type="text"
                id="gedung"
                name="gedung"
                placeholder="Contoh: Gedung A"
                maxlength="50"
                value="{{ old('gedung') }}"
                required
            >

            <label for="nomor_ruang">Nomor Ruang</label>
            <input
                type="text"
                id="nomor_ruang"
                name="nomor_ruang"
                placeholder="Contoh: A301"
                maxlength="20"
                value="{{ old('nomor_ruang') }}"
                required
            >

            <label for="kapasitas">Kapasitas Ruangan</label>
            <input
                type="number"
                id="kapasitas"
                name="kapasitas"
                min="1"
                placeholder="Contoh: 30"
                value="{{ old('kapasitas') }}"
                required
            >

            <label>Proyektor</label>
            <div class="radio-group">
                <label>
                    <input type="radio" name="proyektor" value="Tersedia" required>
                    Tersedia
                </label>

                <label>
                    <input type="radio" name="proyektor" value="Tidak Ada">
                    Tidak Ada
                </label>
            </div>

            <label>PC</label>
            <div class="radio-group">
                <label>
                    <input type="radio" name="pc" value="Tersedia" required>
                    Tersedia
                </label>

                <label>
                    <input type="radio" name="pc" value="Tidak Ada">
                    Tidak Ada
                </label>
            </div>

            <label for="status">Status Ruangan</label>
            <select id="status" name="status" required>
                <option value="Aktif">Aktif</option>
                <option value="Nonaktif">Nonaktif</option>
            </select>

            <div class="tombol-form">
                <a href="{{ url('/') }}" class="btn-kembali">
                    Kembali
                </a>

                <button type="submit" class="btn-simpan">
                    Simpan Ruangan
                </button>
            </div>
        </form>
    </div>
</div>

</body>
</html>