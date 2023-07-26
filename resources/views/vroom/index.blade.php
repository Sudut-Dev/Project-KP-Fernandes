{{-- Include header --}}
@include('layout.header')

<!--start content-->
<main class="page-content">
    {{-- Alert set --}}
    @include('components.alert-set')

    <!--breadcrumb-->
    <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
        <div class="breadcrumb-title pe-3">V-RUANGAN</div>
        <div class="ps-3">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0 p-0">
                    <li class="breadcrumb-item"><i class="bx bx-home-alt"></i>
                    </li>
                    <li class="breadcrumb-item active" aria-current="page">{{ $title ??= 'Title' }}</li>
                </ol>
            </nav>
        </div>
    </div>
    <!--end breadcrumb-->

    <div class="row">
        <div class="col-12">
            {{-- table --}}
            <div class="card">
                <div class="card-body">
                    {{-- user buttons --}}
                    <div>
                        <a id="btn-room-create" class="btn btn-white" title="Tambah Ruangan" data-bs-toggle="tooltip"
                            data-bs-placement="bottom">
                            <i class="bi bi-plus-lg"></i>
                        </a>
                    </div>
                    <div id="rooms-table-wrapper" class="table-responsive">
                        <table id="rooms-table" class="table align-middle">
                            @if (count($vrooms) > 0)
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Nama V-Ruangan</th>
                                        <th class="cell-head-center">Status</th>
                                        <th class="cell-head-center">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($vrooms as $i => $room)
                                        <tr>
                                            <td>{{ $i + 1 }}</td>
                                            <td>{{ $room->name }}</td>

                                            <td class="cell-head-center">
                                                @if ($room->status)
                                                    <span class="badge bg-success w-75">Aktif</span>
                                                @else
                                                    <span class="badge bg-danger w-75">Nonaktif</span>
                                                @endif
                                            </td>

                                           {{-- Aksi --}}
                                           <td class="d-flex justify-content-center">
                                            <div class="table-actions d-flex align-items-center">
                                                {{-- Ubah --}}
                                                <a class="btn-room-edit btn btn-sm text-dark"
                                                    data-bs-toggle="tooltip" data-bs-placement="bottom"
                                                    title="Ubah" data-name="{{ $room->name }}"
                                                    data-id="{{ $room->id }}">
                                                    <i class="bi bi-pen"></i>
                                                </a>

                                                {{-- <a class="btn-room-edit btn btn-sm text-dark"
                                                    data-bs-toggle="tooltip" data-bs-placement="bottom"
                                                    title="Ubah" data-name="{{ $room->link }}"
                                                    data-id="{{ $room->id }}">
                                                    <i class="bi bi-pen"></i>
                                                </a> --}}

                                                    @if ($room->status)
                                                        {{-- Tombol disable room --}}
                                                        <div data-bs-toggle="tooltip" data-bs-placement="bottom"
                                                            title="Nonaktifkan Ruangan">
                                                            <button type="button" class="btn" data-bs-toggle="modal"
                                                                data-bs-target="#modal-room-disable-{{ $room->id }}">
                                                                <i class="fa-solid fa-power-off text-danger"></i>
                                                            </button>
                                                        </div>
                                                    @else
                                                        {{-- Tombol enable room --}}
                                                        <div data-bs-toggle="tooltip" data-bs-placement="bottom"
                                                            title="Aktifkan Ruangan">
                                                            <button type="button" class="btn" data-bs-toggle="modal"
                                                                data-bs-target="#modal-room-enable-{{ $room->id }}">
                                                                <i class="fa-solid fa-power-off text-success"></i>
                                                            </button>
                                                        </div>
                                                    @endif


                                                      {{-- Tombol delete room --}}
                                                      <div data-bs-toggle="tooltip" data-bs-placement="bottom"
                                                      title="Hapus Ruangan">
                                                      <button type="button" class="btn" data-bs-toggle="modal"
                                                          data-bs-target="#modal-room-destroy-{{ $room->id }}">
                                                          <i class="bi bi-trash text-danger"></i>
                                                      </button>
                                                  </div>

                                                 {{-- Modal delete --}}
                                                <div class="modal fade" id="modal-room-destroy-{{ $room->id }}" tabindex="-1" aria-labelledby="exampleModalLabel"
                                               aria-hidden="true">
                                                <div class="modal-dialog modal-lg">
                                               <form action="{{ route('vroom.destroy', $room->id) }}" method="POST">
                                                @csrf
                                                @method('DELETE')
                                                <div class="modal-content">
                                                <div class="modal-header">
                                                <h5 class="modal-title" id="exampleModalLabel">Hapus Ruangan</h5>
                                                </div>
                                                <div class="modal-body">
                                                Ruangan <strong>{{ $room->name }}</strong> akan dihapus. Tekan <strong>OK</strong> untuk melanjutkan.
                                               </div>
                                               <div class="modal-footer">
                                               <button type="button" class="btn btn-light border" data-bs-dismiss="modal">Batal</button>
                                               <button type="submit" class="btn btn-danger">OK</button>
                                                     </div>
                                                         </div>
                                                              </form>
                                                                  </div>
                                                                      </div>


                                                    {{-- Modal enable --}}
                                                    <div class="modal fade" id="modal-room-enable-{{ $room->id }}"
                                                        tabindex="-1" aria-labelledby="exampleModalLabel"
                                                        aria-hidden="true">
                                                        <div class="modal-dialog modal-lg">
                                                            <form action="{{ route('vroom.enable', $room->id) }}"
                                                                method="GET">
                                                                <div class="modal-content">
                                                                    <div class="modal-header">
                                                                        <h5 class="modal-title" id="exampleModalLabel">
                                                                            Aktifkan Ruangan
                                                                        </h5>
                                                                    </div>
                                                                    <div class="modal-body">
                                                                        Ruangan <strong>{{ $room->name }}</strong>
                                                                        akan
                                                                        diaktifkan. Tekan <strong>OK</strong> untuk
                                                                        melanjutkan.
                                                                    </div>
                                                                    <div class="modal-footer">
                                                                        <button type="button"
                                                                            class="btn btn-light border"
                                                                            data-bs-dismiss="modal">Batal</button>
                                                                        <button type="submit"
                                                                            class="btn btn-primary">OK</button>
                                                                    </div>
                                                                </div>
                                                            </form>
                                                        </div>
                                                    </div>

                                                    {{-- Modal disable --}}
                                                    <div class="modal fade" id="modal-room-disable-{{ $room->id }}"
                                                        tabindex="-1" aria-labelledby="exampleModalLabel"
                                                        aria-hidden="true">
                                                        <div class="modal-dialog modal-lg">
                                                            <form action="{{ route('vroom.disable', $room->id) }}"
                                                                method="POST">
                                                                @csrf
                                                                @method('PUT')
                                                                <div class="modal-content">
                                                                    <div class="modal-header">
                                                                        <h5 class="modal-title" id="exampleModalLabel">
                                                                            Nonaktifkan Ruangan
                                                                        </h5>
                                                                    </div>
                                                                    <div class="modal-body">
                                                                        <hr class="text-white">

                                                                        <p class="d-block">
                                                                            <strong>{{ $room->name }}</strong> akan
                                                                            dinonaktifkan
                                                                            dari sistem. Tekan <strong>OK</strong> untuk
                                                                            melanjutkan.
                                                                        </p>
                                                                    </div>
                                                                    <div class="modal-footer">
                                                                        <button type="button"
                                                                            class="btn btn-light border"
                                                                            data-bs-dismiss="modal">Batal</button>
                                                                        <button type="submit"
                                                                            class="btn btn-primary">OK</button>
                                                                    </div>
                                                                </div>
                                                            </form>
                                                        </div>
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            @else
                                <thead>
                                    <h6 class="text-center">Data ruangan tidak ditemukan.</h6>
                                </thead>
                            @endif
                        </table>
                    </div>
                </div>
            </div>
            {{-- end table --}}
        </div>
        <div class="col-6">
            {{-- Form tambah & ubah --}}
            <div class="">
                <div class="card-body">
                    {{-- Input Tambah --}}
                    <form id="form-room-create" class="d-block w-100 d-none" action="{{ route('vroom.store') }}"
                        method="POST">
                        @csrf

                        <div>
                            <a class="h6 text-dark">
                                Form Tambah Ruangan
                            </a>
                        </div>

                        <div class="my-4">
                            <label class="mb-2" for="username">Nama V-Ruangan :</label>
                            <div class="input-group">
                                <span class="input-group-text">
                                    <i class="bi bi-door-closed"></i>
                                </span>
                                <input name="name" id="name" type="text"
                                    class="form-control @error('name') is-invalid @enderror w-75"
                                    placeholder="Nama ruangan" aria-label="name" value="{{ old('name') }}"
                                    required autocomplete="off">
                            </div>
                            @error('name')
                                <span class="text-danger position-absolute d-block">
                                    <small>
                                        {{ $message }}
                                    </small>
                                </span>
                            @enderror
                        </div>


                        {{-- Tombol Tambah --}}
                        <button type="submit" class="btn btn-primary">Simpan</button>
                    </form>

                    {{-- Input Ubah --}}
                    <form id="form-room-edit" class="d-block w-100 d-none" action="{{ route('vroom.update') }}"
                        method="POST">
                        @csrf
                        @method('PUT')

                        <div>
                            <a class="h6 text-dark">
                                Form Ubah Ruangan
                            </a>
                        </div>

                        <input id="input-room-id" type="hidden" name="id">
                        <div class="my-4">
                            <label class="mb-2" for="username">Nama V-Ruangan :</label>
                            <div class="input-group">
                                <span class="input-group-text">
                                    <i class="bi bi-door-closed"></i>
                                </span>
                                <input id="input-room-name" name="name" type="text"
                                    class="form-control @error('name') is-invalid @enderror w-75"
                                    placeholder="Nama ruangan" aria-label="name" value="{{ old('name') }}" required>
                            </div>
                            @error('name')
                                <span class="text-danger position-absolute d-block">
                                    <small>
                                        {{ $message }}
                                    </small>
                                </span>
                            @enderror
                        </div>

                        {{-- Tombol Tambah --}}
                        <button type="submit" class="btn btn-primary">Ubah</button>
                    </form>
                </div>
            </div>
        </div>

    </div>



</main>
<!--end page main-->

{{-- Include footer --}}
@include('layout.footer')
