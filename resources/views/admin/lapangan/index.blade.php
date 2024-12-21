<div class="modal fade" id="tambahLapangan" tabindex="-1" aria-labelledby="tambahLapanganLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="tambahLapanganLabel">Tambah Lapangan</h5>
        <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form action="{{ route('store-lapangan') }}" method="POST" enctype="multipart/form-data">
          @csrf
          <div class="mb-3">
            <label for="nama" class="form-label">Nama Lapangan</label>
            <input type="text" class="form-control" id="nama" name="nama" required>
          </div>
          <div class="mb-3">
            <label for="deskripsi" class="form-label">Deskripsi Lapangan</label>
            <textarea class="form-control" id="deskripsi" name="deskripsi" rows="3" required></textarea>
          </div>
          <div class="mb-3">
            <label for="harga_per_jam" class="form-label">Harga Per Jam</label>
            <input type="number" class="form-control" id="harga_per_jam" name="harga_per_jam" required>
          </div>
          <div class="mb-3">
            <label for="kapasitas" class="form-label">Kapasitas Lapangan</label>
            <input type="number" class="form-control" id="kapasitas" name="kapasitas" required>
          </div>
          <div class="mb-3">
            <label for="gambar" class="form-label">Gambar Lapangan</label>
            <input type="file" class="form-control" id="gambar" name="gambar" required>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
            <button type="submit" class="btn btn-primary">Tambah Data</button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>

<!-- edit form -->
@foreach($lapangans as $lapangan)
<div class="modal fade" id="editLapanganModal{{ $lapangan->id }}" tabindex="-1" aria-labelledby="editLapanganModalLabel{{ $lapangan->id }}" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="editLapanganModalLabel{{ $lapangan->id }}">Edit Lapangan</h5>
        <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form action="{{ route('update-lapangan', $lapangan->id) }}" method="POST" enctype="multipart/form-data">
          @csrf
          @method('PUT')
          <div class="mb-3">
            <label for="nama" class="form-label">Nama Lapangan</label>
            <input type="text" class="form-control" id="nama" name="nama" value="{{ $lapangan->nama }}" required>
          </div>
          <div class="mb-3">
            <label for="deskripsi" class="form-label">Deskripsi</label>
            <textarea class="form-control" id="deskripsi" name="deskripsi" rows="3" required>{{$lapangan->deskripsi}}</textarea>
          </div>
          <div class="mb-3">
            <label for="harga_per_jam" class="form-label">Harga Lapangan Per Jam</label>
            <input type="number" class="form-control" id="harga_per_jam" name="harga_per_jam" value="{{ $lapangan->harga_per_jam }}" required>
          </div>
          
          <div class="mb-3">
            <label for="kapasitas" class="form-label">Kapasitas Lapangan</label>
            <input type="number" class="form-control" id="kapasitas" name="kapasitas" value="{{ $lapangan->kapasitas }}" required>
          </div>
          <div class="mb-3">
            <label for="gambar" class="form-label">Gambar Lapangan</label>
            <input type="file" class="form-control" id="gambar" name="gambar">
            <small class="text-muted">Biarkan kosong jika tidak ingin mengubah gambar.</small>
            <br>
            <!-- Preview Image -->
            <img id="preview{{ $lapangan->id }}" src="{{ asset('storage/' . $lapangan->gambar) }}" alt="Pratinjau Gambar" class="img-thumbnail mt-2" style="width: 150px; height: auto;">
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
            <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>
@endforeach

@extends('component.app')
@section('title','Lapangan')
@section('main')
<div class="col-12 col-md-6 col-lg-12">
  <div class="card">
    <div class="card-header justify-content-end">
      <!-- Button to Open Modal -->
      <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#tambahLapangan">
        Tambah Lapangan
      </button>
    </div>
    <div class="card-body p-0">
      <div class="table-responsive">
      <table class="table table-striped table-md">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Nama Lapangan</th>
                    <th>Deskripsi</th>
                    <th>Harga Per Jam</th>
                    <th>Kapasitas</th>
                    <th>Gambar</th>
                    <th style="text-align:center">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($lapangans as $index => $lapangan)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $lapangan->nama }}</td>\<td>{{ $lapangan->deskripsi }}</td>
                    <td>{{ number_format($lapangan->harga_per_jam, 0, ',', '.') }}</td>
                    <td>{{ $lapangan->kapasitas }}</td>
                    <td>
                        <img src="{{ asset('storage/' . $lapangan->gambar) }}" alt="Gambar Lapangan" class="img-thumbnail" style="width: 100px;">
                    </td>
                    <td style="text-align:center">
                        <button class="btn btn-warning" style="width:100px" data-toggle="modal" data-target="#editLapanganModal{{ $lapangan->id }}">
                            <i class="far fa-edit mr-3"></i>Edit
                        </button>
                        <form action="{{ route('delete-lapangan', $lapangan->id) }}" method="POST" class="d-inline">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-danger" style="width:100px" onclick="return confirm('Apakah Anda yakin ingin menghapus lapangan ini?')">
                                <i class="far fa-trash-alt mr-2"></i>Hapus
                            </button>
                        </form>

                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="text-center">Tidak ada data Lapangan.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
      </div>
    </div>
  </div>
</div>
@endsection
