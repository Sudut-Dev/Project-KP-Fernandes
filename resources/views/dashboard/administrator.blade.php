{{-- Include header --}}
@include('layout.header')

<!--Start content-->
<main class="page-content">
    <!--breadcrumb-->
    <div>
        <div class="row">
            <div class="col">
                <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
                    <div class="breadcrumb-title pe-3">DASHBOARD</div>
                    <div class="ps-3">
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb mb-0 p-0">
                                <li class="breadcrumb-item"><i class="bx bx-home-alt"></i>
                                </li>
                                <li class="breadcrumb-item active" aria-current="page">
                                    {{ auth()->user()->role->name }}</li>
                            </ol>
                        </nav>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!--end breadcrumb-->

    {{-- Alert set --}}
    @include('components.alert-set')

    <div>
        <div class="row">
            {{-- Jumlah Pengguna --}}
            <div class="col-4">
                <div class="card radius-10 border-0 border-3">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <div class="">
                                <p class="mb-1">Pengguna</p>
                                <h4 class="mb-0">{{ $countUser }}</h4>
                            </div>
                            <div class="ms-auto widget-icon bg-info text-white">
                                <i class="bi bi-people-fill"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Jumlah Pengajuan --}}
            {{-- <div class="col-4">
                <div class="card radius-10 border-0 border-3">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <div class="">
                                <p class="mb-1">Jadwal Pending</p>
                                <h4 class="mb-0">{{ $countPending }}</h4>
                            </div>
                            <div class="ms-auto widget-icon bg-warning text-white">
                                <i class="bi bi-list"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div> --}}

            {{-- Jumlah Jadwal --}}
            <div class="col-4">
                <div class="card radius-10 border-0 border-3">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <div class="">
                                <p class="mb-1">Jadwal Aktif</p>
                                <h4 class="mb-0">{{ $countActive }}</h4>
                            </div>
                            <div class="ms-auto widget-icon bg-primary text-white">
                                <i class="bi bi-list-check"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Jumlah Link --}}
            <div class="col-4">
                <div class="card radius-10 border-0 border-3">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <div class="">
                                <p class="mb-1">Jumlah Link Aktif</p>
                                <h4 class="mb-0">{{ $countActive_link }}</h4>
                            </div>
                            <div class="ms-auto widget-icon bg-success text-white">
                                <i class="bi bi-list-check"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    {{-- Jadwal Aktif --}}
    <div class="card">
        <div class="card-header">
            <h6 class="text-center text-dark mt-2">Jadwal Aktif</h6>
        </div>
        <div class="card-body" style="max-height: 260px; overflow-y: scroll">
            @if (count($activeSchedules) > 0)
                <div id="users-table-wrapper" class="table-responsive">
                    <table id="users-table" class="table align-middle">
                        <thead>
                            <tr>
                                <td>#</td>
                                <td>Nama Peminjam</td>
                                <td>No_Siltik</td>
                                <td>P-Ruangan</td>
                                <td>V-Ruangan</td>
                                <td>Tanggal Rapat</td>
                                <td>Mulai</td>
                                <td>Selesai</td>
                                <td class="cell-head-center">Informasi</td>
                                <td class="cell-head-center">Countdown</td>
                                <td class="cell-head-center">Aksi</td>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($activeSchedules as $i => $active)
                                <tr>
                                    <td>{{ $i + 1 }}</td>
                                    <td>{{ $active->user_borrower_id}}</td>
                                    <td>{{ $active->description }}</td>
                                    <td>
                                        @foreach ($active->rooms as $room)
                                            {{ $room->name ?? '-' }},
                                        @endforeach
                                    </td>
                                    <td>
                                        @foreach ($active->vrooms as $vroom)
                                            {{ $vroom->name ?? '-' }},
                                        @endforeach
                                    </td>
                                    <td>{{ dateFormat($active->date) }}</td>
                                    <td>{{ timeFormat($active->start) }}</td>
                                    <td>{{ timeFormat($active->end) }}</td>

                                    {{-- Detail --}}
                                    <td>
                                        <center>
                                            <div data-bs-toggle="tooltip" data-bs-placement="bottom"
                                                title="Tampilkan Detail Jadwal" class="d-inline">
                                                <a href="#" data-bs-toggle="modal"
                                                    data-bs-target="#modal-detail-active-{{ $active->id }}">Detail</a>
                                            </div>
                                        </center>

                                        {{-- Modal Detail Jadwal Aktif --}}
                                        <div class="modal fade" id="modal-detail-active-{{ $active->id }}"
                                            tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="exampleModalLabel">
                                                            Detail Jadwal <strong>{{ $active->description }}</strong>
                                                        </h5>
                                                    </div>
                                                    <div class="modal-body">
                                                        <table class="table table-sm table-borderless">
                                                            {{-- Diajukan Pada --}}
                                                            @if ($active->requested_at)
                                                                <tr>
                                                                    <td>Diajukan pada</td>
                                                                    <td>:</td>
                                                                    <td>{{ dateTimeFormat($active->requested_at) }}
                                                                    </td>
                                                                </tr>
                                                            @endif

                                                            {{-- Disetujui Pada --}}
                                                            @if ($active->approved_at)
                                                                <tr>
                                                                    <td>Disetujui pada</td>
                                                                    <td>:</td>
                                                                    <td>{{ dateTimeFormat($active->approved_at) }}
                                                                    </td>
                                                                </tr>
                                                            @endif

                                                            {{-- Dibuat Pada --}}
                                                            @if ($active->created_at)
                                                                <tr>
                                                                    <td>Dibuat pada</td>
                                                                    <td>:</td>
                                                                    <td>{{ dateTimeFormat($active->created_at) }}
                                                                    </td>
                                                                </tr>
                                                            @endif
                                                        </table>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-light border"
                                                            data-bs-dismiss="modal">Tutup</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </td>

                                    {{-- Countdown --}}
                                    <td>
                                        <center>
                                            @if (!is_null($active->approved_at) || !is_null($active->created_at))
                                                <strong>
                                                    <span class="countdown"
                                                        data-then="{{ $active->date . ' ' . $active->start }}"
                                                        data-schedule-id="{{ $active->id }}"></span>
                                                </strong>
                                            @else
                                                -
                                            @endif
                                        </center>
                                    </td>

                                    {{-- Aksi --}}
                                    <td class="d-flex justify-content-center">
                                        <div class="table-actions d-flex align-items-center gap-3">
                                            {{-- Selesaikan rapat --}}
                                            <div data-bs-toggle="tooltip" data-bs-placement="bottom"
                                                title="Selesaikan Rapat"
                                                class="on-schedule-finish-{{ $active->id }} d-none">
                                                <a href="#" class="d-inline-block" data-bs-toggle="modal"
                                                    data-bs-target="#modal-schedule-finish-{{ $active->id }}">
                                                    <i class="bi bi-check-circle-fill text-success"></i>
                                                </a>
                                            </div>

                                            {{-- Batal rapat --}}
                                            <div data-bs-toggle="tooltip" data-bs-placement="bottom" title="Batal">
                                                <a href="#" class="d-inline-block" data-bs-toggle="modal"
                                                    data-bs-target="#modal-schedule-delete-{{ $active->id }}">
                                                    <i class="bi bi-x-circle-fill text-danger"></i>
                                                </a>
                                            </div>

                                            {{-- Modal Batalkan rapat --}}
                                            <div class="modal fade" id="modal-schedule-delete-{{ $active->id }}"
                                                tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                <div class="modal-dialog">
                                                    <form action="{{ route('schedule.cancel', $active->id) }}"
                                                        method="post">
                                                        @csrf
                                                        @method('DELETE')
                                                        <input type="hidden" name="subject"
                                                            value="Jadwal Telah Dibatalkan Oleh Peminjam">

                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h5 class="modal-title" id="exampleModalLabel">
                                                                    Konfirmasi
                                                                </h5>
                                                            </div>
                                                            <div class="modal-body">
                                                                <span class="text-wrap">
                                                                    Jadwal
                                                                    <strong>{{ $active->description }}</strong> akan
                                                                    dibatalkan.
                                                                </span>
                                                                <!-- <div class="py-3">
                                                                    <div class="form-floating">
                                                                        <textarea required name="cancelMessage" class="form-control" placeholder="Masukan alasan penolakan"
                                                                            id="alasanPenolakan" style="height: 100px"></textarea>
                                                                        <label for="alasanPenolakan">Alasan
                                                                            pembatalan</label>
                                                                    </div>
                                                                </div> -->
                                                                <span>
                                                                    Tekan <strong>OK</strong> untuk melanjutkan
                                                                    pembatalan jadwal.
                                                                </span>
                                                            </div>
                                                            <div class="modal-footer">
                                                                <button type="button" class="btn btn-light border"
                                                                    data-bs-dismiss="modal">Batal</button>
                                                                <button type="submit"
                                                                    class="btn btn-primary">OK</button>
                                                            </div>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>

                                            {{-- Modal Selesaikan rapat --}}
                                            <div class="modal fade" id="modal-schedule-finish-{{ $active->id }}"
                                                tabindex="-1" aria-labelledby="exampleModalLabel"
                                                aria-hidden="true">
                                                <div class="modal-dialog">
                                                    <form action="{{ route('schedule.finish', $active->id) }}"
                                                        method="GET">
                                                        <input name="id" type="hidden"
                                                            value="{{ $active->id }}">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h5 class="modal-title" id="exampleModalLabel">
                                                                    Selesaikan Rapat
                                                                </h5>
                                                            </div>
                                                            <div class="modal-body">
                                                                <p>
                                                                    Tekan OK untuk menyelesaikan rapat
                                                                </p>
                                                            </div>
                                                            <div class="modal-footer">
                                                                <button type="button" class="btn btn-light border"
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
                    </table>
                </div>
            @else
                <h6 class="text-center">-</h6>
            @endif
        </div>
    </div>

   {{-- <div class="card">
    <div class="card-header">
        <h6 class="text-center text-dark mt-2">Jadwal Pending</h6>
    </div>
    <div class="card-body" style="max-height: 260px; overflow-y: scroll">
        @if (count($pendingSchedules) > 0)
            <div id="users-table-wrapper" class="table-responsive">
                <table id="users-table" class="table align-middle">
                    <thead>
                        <tr>
                            <td>#</td>
                            <td>P-Ruangan</td>
                            <td>V-Ruangan</td>
                            <td>Tanggal Rapat</td>
                            <td>Mulai</td>
                            <td>Selesai</td>
                            <td>No_Siltik</td>
                            <td class="cell-head-center">Informasi</td>
                            <td class="cell-head-center">Status</td>
                            <td class="cell-head-center">Aksi</td>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($pendingSchedules as $i => $pending)
                            <tr>
                                <td>{{ $i + 1 }}</td>
                                <td>{{ $pending->room->name ?? '-'}}</td>
                                <td>{{ $pending->vroom->name ?? '-'}}</td>
                                <td>{{ dateFormat($pending->date) }}</td>
                                <td>{{ timeFormat($pending->start) }}</td>
                                <td>{{ timeFormat($pending->end) }}</td>
                                <td>{{ $pending->description }}</td>

                                <td class="cell-center">
                                    <center>
                                        <div data-bs-toggle="tooltip" data-bs-placement="bottom"
                                            title="Tampilkan Detail Pengajuan" class="d-inline">
                                            <a href="#" data-bs-toggle="modal"
                                                data-bs-target="#modal-detail-pending-{{ $pending->id }}">Detail</a>
                                        </div>
                                    </center>

                                    <div class="modal fade" id="modal-detail-pending-{{ $pending->id }}"
                                        tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="exampleModalLabel">
                                                        Detail Pengajuan
                                                        <strong>{{ $pending->description }}</strong>
                                                    </h5>
                                                </div>
                                                <div class="modal-body">
                                                    <table class="table table-sm table-borderless">
                                                        @if ($pending->requested_at)
                                                            <tr>
                                                                <td>Diajukan pada</td>
                                                                <td>:</td>
                                                                <td>{{ dateTimeFormat($pending->requested_at) }}
                                                                </td>
                                                            </tr>
                                                        @endif
                                                    </table>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-light border"
                                                        data-bs-dismiss="modal">Tutup</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </td>

                                <td>
                                    <center>
                                        {!! makeStatus($pending->status) !!}
                                    </center>
                                </td>

                                <td class="d-flex justify-content-center">
                                    <div class="table-actions d-flex align-items-center gap-3">
                                        @if ($pending->status == 'decline')
                                            <a href="{{ route('request.edit', $pending->id) }}"
                                                class="d-inline-block" data-bs-toggle="tooltip"
                                                data-bs-placement="bottom" title="Ajukan Kembali">
                                                <i class="bi bi-arrow-up-circle-fill text-dark"></i>
                                            </a>
                                        @endif
                                        <a href="{{ route('request.edit', $pending->id) }}"
                                            class="d-inline-block" data-bs-toggle="tooltip"
                                            data-bs-placement="bottom" title="Ajukan Kembali">
                                            <i class="bi bi-arrow-up-circle-fill text-dark"></i>
                                        </a>
                                        <div data-bs-toggle="tooltip" data-bs-placement="bottom" title="Batal">
                                            <a href="#" type="button" class="d-inline-block"
                                                data-bs-toggle="modal"
                                                data-bs-target="#modal-schedule-delete-{{ $pending->id }}">
                                                <i class="bi bi-x-circle-fill text-danger"></i>
                                            </a>
                                        </div>

                                        <div class="modal fade" id="modal-schedule-delete-{{ $pending->id }}"
                                            tabindex="-1" aria-labelledby="exampleModalLabel"
                                            aria-hidden="true">
                                            <div class="modal-dialog">
                                                <form action="{{ route('schedule.cancel', $pending->id) }}"
                                                    method="post">
                                                    @csrf
                                                    @method('DELETE')
                                                    <input type="hidden" name="subject"
                                                        value="Pengajuan Jadwal Telah Dibatalkan Oleh Peminjam">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title" id="exampleModalLabel">
                                                                Konfirmasi
                                                            </h5>
                                                        </div>
                                                        <div class="modal-body">
                                                            <span class="text-wrap">
                                                                Jadwal
                                                                <strong>{{ $pending->description }}</strong> akan
                                                                dibatalkan. Silahkan cantumkan alasan dari
                                                                pembatalan jadwal.
                                                            </span>
                                                            <div class="py-3">
                                                                <div class="form-floating">
                                                                    <textarea required name="cancelMessage" class="form-control" placeholder="Masukan alasan penolakan"
                                                                        id="alasanPenolakan" style="height: 100px"></textarea>
                                                                    <label for="alasanPenolakan">Alasan
                                                                        pembatalan</label>
                                                                </div>
                                                            </div>
                                                            <span>
                                                                Tekan <strong>OK</strong> untuk melanjutkan
                                                                pembatalan jadwal.
                                                            </span>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-light border"
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
                </table>
            </div>
        @else
            <h6 class="text-center">-</h6>
        @endif
    </div>
</div> --}}

    {{-- Jadwal Aktif --}}
    <div class="card">
        <div class="card-header">
            <h6 class="text-center text-dark mt-2">Informasi Link</h6>
        </div>
        <div class="card-body" style="max-height: 260px; overflow-y: scroll">
            @if (count($activeSchedules) > 0)
                <div id="users-table-wrapper" class="table-responsive">
                    <table id="users-table" class="table align-middle">
                        <thead>
                            <tr>
                                <td>#</td>
                                <td>Link</td>
                                <td>Virtual Ruangan</td>
                                <td>Tanggal Link Aktif</td>
                                {{-- <td>Tanggal Rapat</td> --}}
                                <td>Mulai</td>
                                <td>Selesai</td>
                                <td class="cell-head-center">Informasi</td>
                                <td class="cell-head-center">Countdown</td>
                                {{-- <td class="cell-head-center">Aksi</td> --}}
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($activeLinks as $i => $active_link)
                                <tr>
                                    <td>{{ $i + 1 }}</td>
                                    <td>{{ $active_link->link}}</td>
                                    <td>{{ $active_link->vroom ? $active_link->vroom->name : '' }}</td>
                                    <td>{{ dateFormat($active_link->date) }}</td>
                                    <td>{{ timeFormat($active_link->start) }}</td>
                                    <td>{{ timeFormat($active_link->end) }}</td>

                                    {{-- Detail --}}
                                    <td>
                                        <center>
                                            <div data-bs-toggle="tooltip" data-bs-placement="bottom"
                                                title="Tampilkan Detail Jadwal" class="d-inline">
                                                <a href="#" data-bs-toggle="modal"
                                                    data-bs-target="#modal-detail-active-{{ $active_link->id }}">Detail</a>
                                            </div>
                                        </center>

                                        {{-- Modal Detail Jadwal Aktif --}}
                                        <div class="modal fade" id="modal-detail-active-{{ $active_link->id }}"
                                            tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="exampleModalLabel">
                                                            Detail Jadwal <strong>{{ $active_link->description }}</strong>
                                                        </h5>
                                                    </div>
                                                    <div class="modal-body">
                                                        <table class="table table-sm table-borderless">
                                                            {{-- Diajukan Pada --}}
                                                            @if ($active_link->requested_at)
                                                                <tr>
                                                                    <td>Diajukan pada</td>
                                                                    <td>:</td>
                                                                    <td>{{ dateTimeFormat($active_link->requested_at) }}
                                                                    </td>
                                                                </tr>
                                                            @endif

                                                            {{-- Disetujui Pada --}}
                                                            @if ($active_link->approved_at)
                                                                <tr>
                                                                    <td>Disetujui pada</td>
                                                                    <td>:</td>
                                                                    <td>{{ dateTimeFormat($active_link->approved_at) }}
                                                                    </td>
                                                                </tr>
                                                            @endif

                                                            {{-- Dibuat Pada --}}
                                                            @if ($active_link->created_at)
                                                                <tr>
                                                                    <td>Dibuat pada</td>
                                                                    <td>:</td>
                                                                    <td>{{ dateTimeFormat($active_link->created_at) }}
                                                                    </td>
                                                                </tr>
                                                            @endif
                                                        </table>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-light border"
                                                            data-bs-dismiss="modal">Tutup</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </td>

                                    {{-- Countdown --}}
                                    <td>
                                        <center>
                                            @if (!is_null($active_link->approved_at) || !is_null($active_link->created_at))
                                                <strong>
                                                    <span class="countdown"
                                                        data-then="{{ $active_link->date . ' ' . $active_link->start }}"
                                                        data-schedule-id="{{ $active_link->id }}"></span>
                                                </strong>
                                            @else
                                                -
                                            @endif
                                        </center>
                                    </td>

                                    {{-- Aksi --}}
                                    {{-- <td class="d-flex justify-content-center">
                                        <div class="table-actions d-flex align-items-center gap-3">

                                            <div data-bs-toggle="tooltip" data-bs-placement="bottom"
                                                title="Selesaikan Rapat"
                                                class="on-schedule-finish-{{ $active_link->id }} d-none">
                                                <a href="#" class="d-inline-block" data-bs-toggle="modal"
                                                    data-bs-target="#modal-schedule-finish-{{ $active_link->id }}">
                                                    <i class="bi bi-check-circle-fill text-success"></i>
                                                </a>
                                            </div>

                                            <div data-bs-toggle="tooltip" data-bs-placement="bottom" title="Batal">
                                                <a href="#" class="d-inline-block" data-bs-toggle="modal"
                                                    data-bs-target="#modal-schedule-delete-{{ $active_link->id }}">
                                                    <i class="bi bi-x-circle-fill text-danger"></i>
                                                </a>
                                            </div>

                                            <div class="modal fade" id="modal-schedule-delete-{{ $active_link->id }}"
                                                tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                <div class="modal-dialog">
                                                    <form action="{{ route('schedule.cancel', $active_link->id) }}"
                                                        method="post">
                                                        @csrf
                                                        @method('DELETE')
                                                        <input type="hidden" name="subject"
                                                            value="Jadwal Telah Dibatalkan Oleh Peminjam">

                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h5 class="modal-title" id="exampleModalLabel">
                                                                    Konfirmasi
                                                                </h5>
                                                            </div>
                                                            <div class="modal-body">
                                                                <span class="text-wrap">
                                                                    Jadwal
                                                                    <strong>{{ $active_link->description }}</strong> akan
                                                                    dibatalkan. Silahkan cantumkan alasan dari
                                                                    pembatalan jadwal.
                                                                </span>
                                                                <div class="py-3">
                                                                    <div class="form-floating">
                                                                        <textarea required name="cancelMessage" class="form-control" placeholder="Masukan alasan penolakan"
                                                                            id="alasanPenolakan" style="height: 100px"></textarea>
                                                                        <label for="alasanPenolakan">Alasan
                                                                            pembatalan</label>
                                                                    </div>
                                                                </div>
                                                                <span>
                                                                    Tekan <strong>OK</strong> untuk melanjutkan
                                                                    pembatalan jadwal.
                                                                </span>
                                                            </div>
                                                            <div class="modal-footer">
                                                                <button type="button" class="btn btn-light border"
                                                                    data-bs-dismiss="modal">Batal</button>
                                                                <button type="submit"
                                                                    class="btn btn-primary">OK</button>
                                                            </div>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>

                                            <div class="modal fade" id="modal-schedule-finish-{{ $active_link->id }}"
                                                tabindex="-1" aria-labelledby="exampleModalLabel"
                                                aria-hidden="true">
                                                <div class="modal-dialog">
                                                    <form action="{{ route('schedule.finish', $active_link->id) }}"
                                                        method="GET">
                                                        <input name="id" type="hidden"
                                                            value="{{ $active_link->id }}">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h5 class="modal-title" id="exampleModalLabel">
                                                                    Selesaikan Rapat
                                                                </h5>
                                                            </div>
                                                            <div class="modal-body">
                                                                <p>
                                                                    Tekan OK untuk menyelesaikan rapat
                                                                </p>
                                                            </div>
                                                            <div class="modal-footer">
                                                                <button type="button" class="btn btn-light border"
                                                                    data-bs-dismiss="modal">Batal</button>
                                                                <button type="submit"
                                                                    class="btn btn-primary">OK</button>
                                                            </div>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </td> --}}
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <h6 class="text-center">-</h6>
            @endif
        </div>
    </div>




        @include('components.calendar-dashboard')
    </div>
</main>
<!--End Page Main-->

{{-- Include footer --}}
@include('layout.footer')
