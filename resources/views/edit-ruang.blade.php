<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Ruangan</title>
    <link rel="stylesheet" href="{{ asset('style.css') }}">
</head>
<body>

<div class="halaman-tambah">
    <div class="form-box">
        <h1>Edit Ruangan</h1>
        <p class="subjudul">Ubah data ruang dan fasilitas sidang</p>

        @if ($errors->any())
            <p style="color:red;">Periksa kembali data yang dimasukkan.</p>
        @endif

        <form method="POST" action="{{ url('/edit-ruang/' . $ruangan->id) }}">
            @csrf
            @method('PUT') <!-- Karena update menggunakan method PUT/PATCH di Laravel -->

            <label for="gedung">Gedung</label>
            <input
                type="text" id="gedung" name="gedung"
                maxlength="50" required
                value="{{ old('gedung', $ruangan->gedung) }}"
            >

            <label for="nomor_ruang">Nomor Ruang</label>
            <input
                type="text" id="nomor_ruang" name="nomor_ruang"
                maxlength="20" required
                value="{{ old('nomor_ruang', $ruangan->nomor_ruang) }}"
            >

            <label for="kapasitas">Kapasitas Ruangan</label>
            <input
                type="number" id="kapasitas" name="kapasitas"
                min="1" required
                value="{{ old('kapasitas', $ruangan->kapasitas) }}"
            >

            <label>Proyektor</label>
            <div class="radio-group">
                <label>
                    <input type="radio" name="proyektor"
                        value="Tersedia"
                        {{ old('proyektor', $ruangan->proyektor) === 'Tersedia' ? 'checked' : '' }}
                        required>
                    Tersedia
                </label>

                <label>
                    <input type="radio" name="proyektor"
                        value="Tidak Ada"
                        {{ old('proyektor', $ruangan->proyektor) === 'Tidak Ada' ? 'checked' : '' }}>
                    Tidak Ada
                </label>
            </div>

            <label>PC</label>
            <div class="radio-group">
                <label>
                    <input type="radio" name="pc"
                        value="Tersedia"
                        {{ old('pc', $ruangan->pc) === 'Tersedia' ? 'checked' : '' }}
                        required>
                    Tersedia
                </label>

                <label>
                    <input type="radio" name="pc"
                        value="Tidak Ada"
                        {{ old('pc', $ruangan->pc) === 'Tidak Ada' ? 'checked' : '' }}>
                    Tidak Ada
                </label>
            </div>

            <label for="status">Status Ruangan</label>
            <select id="status" name="status" required>
                <option value="Aktif" {{ old('status', $ruangan->status) === 'Aktif' ? 'selected' : '' }}>
                    Aktif
                </option>
                <option value="Nonaktif" {{ old('status', $ruangan->status) === 'Nonaktif' ? 'selected' : '' }}>
                    Nonaktif
                </option>
            </select>

            <div class="tombol-form">
                <a href="{{ url('/rooms') }}" class="btn-kembali">Kembali</a>
                <button type="submit" class="btn-simpan">
                    Simpan Perubahan
                </button>
            </div>
        </form>
    </div>
</div>

</body>
</html>