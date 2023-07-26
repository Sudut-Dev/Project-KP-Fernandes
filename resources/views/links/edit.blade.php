{{-- Include header --}}
@include('layout.header')

<!--Start content-->
<main class="page-content">
    <!--breadcrumb-->
    <section>
        <div class="row">
            <div class="col">
                <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
                    <a href="{{ route('links.index') }}" class="d-inline-block" data-bs-toggle="tooltip"
                        data-bs-placement="bottom" title="Kembali">
                        <i class="bi bi-chevron-left text-dark"></i>
                    </a>
                    <div class="breadcrumb-title mx-2 pe-3">JADWAL</div>
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
            </div>
        </div>
    </section>
    <!--end breadcrumb-->

    {{-- Alert set --}}
    @include('components.alert-set')

    <div class="row">
        <div class="col-12">
            {{-- Form pengajuan --}}
            <section>
                <div class="card">
                    <div class="card-header bg-light">
                        Form Ubah Links
                    </div>
                    <div class="card-body">
                        <form action="{{ route('links.update', $schedule->id) }}" method="POST">
                            @csrf
                            @method('PATCH')
                            <div class="container-fluid">
                                <div class="row">
                                    <div class="col-lg-12">
                                        {{-- Date --}}
                                        <div class="mb-4">
                                            <label class="mb-2" for="date">Tanggal :</label>
                                            <div class="input-group mb-1">
                                                <span class="input-group-text">
                                                    <i class="bi bi-calendar"></i>
                                                </span>
                                                <input name="date" id="date" type="date"
                                                    class="form-control
                                            @error('date') is-invalid @enderror"
                                                    aria-label="date" value="{{ old('date', $schedule->date) }}"
                                                    onchange="validateDate()">
                                            </div>
                                            @error('date')
                                                <span class="text-danger position-absolute d-block">
                                                    <small>
                                                        {{ $message }}
                                                    </small>
                                                </span>
                                            @enderror
                                            <span id="msg-date-invalid" class="text-danger d-none mt-1">
                                                <small>
                                                    Tanggal yang dipilih tidak valid.
                                                </small>
                                            </span>
                                        </div>

                                        <div class="row mb-4">
                                            <div class="col-6">
                                                {{-- Start --}}
                                                <div>
                                                    <label class="mb-2" for="start">Waktu Mulai :</label>
                                                    <div class="input-group">
                                                        <span class="input-group-text">
                                                            <i class="bi bi-clock"></i>
                                                        </span>
                                                        <input name="start" id="start" type="time"
                                                            class="form-control
                                                    @error('start') is-invalid @enderror"
                                                            aria-label="start"
                                                            value="{{ old('start', $schedule->start) }}"
                                                            onchange="validateHour()">
                                                    </div>
                                                    @error('start')
                                                        <span class="text-danger position-absolute d-block">
                                                            <small>
                                                                {{ $message }}
                                                            </small>
                                                        </span>
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="col-6">
                                                {{-- End --}}
                                                <div>
                                                    <label class="mb-2" for="end">Waktu Selesai :</label>
                                                    <div class="input-group">
                                                        <span class="input-group-text">
                                                            <i class="bi bi-clock-history"></i>
                                                        </span>
                                                        <input name="end" id="end" type="time"
                                                            class="form-control
                                                    @error('end') is-invalid @enderror"
                                                            aria-label="end" value="{{ old('end', $schedule->end) }}"
                                                            onchange="validateHour()">
                                                    </div>
                                                    @error('end')
                                                        <span class="text-danger position-absolute d-block">
                                                            <small>
                                                                {{ $message }}
                                                            </small>
                                                        </span>
                                                    @enderror
                                                </div>
                                            </div>
                                            <span id="msg-time-invalid"
                                                class="text-danger {{ session('invalidTime') ? 'd-block' : 'd-none' }} mt-1">
                                                <small>
                                                    Waktu yang dipilih tidak valid.
                                                </small>
                                            </span>
                                        </div>

                                        {{-- Link --}}

                                        <div class="row mb-4">

                                            <div class="col-6">
                                                <label class="mb-2" for="link">Link :</label>
                                                <div class="input-group">
                                                    <span class="input-group-text">
                                                        <i class="bi bi-link"></i>
                                                    </span>
                                                    <input name="link" id="link" type="text" class="form-control @error('link') is-invalid @enderror" placeholder="nomor siltik" aria-label="link" value="{{ old('link', $schedule->link) }}">
                                                    </input>
                                                </div>
                                                @error('link')
                                                    <span class="text-danger position-absolute d-block">
                                                        <small>
                                                            {{ $message }}
                                                        </small>
                                                    </span>
                                                @enderror
                                            </div>

                                            <div class="col-6">
                                                <label class="mb-2" for="description">Status :</label>
                                                <div class="input-group">
                                                    <span class="input-group-text">
                                                        <i class="bi bi-person"></i>
                                                    </span>
                                                    <select name="status" class="form-select" required>
                                                        <option value="1" {{ $schedule->status == 1 ? 'selected' : '' }}>Pending</option>
                                                        <option value="2" {{ $schedule->status == 2 ? 'selected' : '' }}>Aktif</option>
                                                        <option value="3" {{ $schedule->status == 3 ? 'selected' : '' }}>Ditolak</option>
                                                        <option value="4" {{ $schedule->status == 4 ? 'selected' : '' }}>Finish</option>
                                                        <!-- Tambahkan opsi status lainnya sesuai kebutuhan -->
                                                    </select>
                                                </div>
                                                @error('description')
                                                    <span class="text-danger position-absolute d-block">
                                                        <small>
                                                            {{ $message }}
                                                        </small>
                                                    </span>
                                                @enderror
                                            </div>
                                        </div>



                                        {{-- Ruangan --}}
                                        <div class="mb-4">
                                            <label class="mb-2" for="vroom">Pilih V-Ruangan :</label>
                                            <div class="input-group">
                                                <span class="input-group-text">
                                                    <i class="bi bi-building"></i>
                                                </span>
                                                <select name="vroom" id="vroom"
                                                    class="form-select
                                                    @error('vroom') is-invalid @enderror">
                                                    <option selected hidden value="">Pilih V-ruangan</option>
                                                    @foreach ($vrooms as $vroom)
                                                        @if (old('vroom') && old('vroom') == $vroom->id)
                                                            <option selected value="{{ $vroom->id }}">
                                                                {{ $vroom->name }}
                                                            </option>
                                                        @elseif ($schedule->vroom_id == $vroom->id)
                                                            <option selected value="{{ $vroom->id }}">
                                                                {{ $vroom->name }}
                                                            </option>
                                                        @else
                                                            <option value="{{ $vroom->id }}">
                                                                {{ $vroom->name }}
                                                            </option>
                                                        @endif
                                                    @endforeach
                                                </select>
                                            </div>
                                            @error('vroom')
                                                <span class="text-danger position-absolute d-block">
                                                    <small>
                                                        {{ $message }}
                                                    </small>
                                                </span>
                                            @enderror
                                        </div>


                                    </div>
                                </div>
                                <div class="row ">
                                    <div class="col-12 d-flex justify-content-center">
                                        <button id="btn-request-submit"
                                            class="btn btn-primary my-3 mt-3 px-5">Simpan</button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </section>
        </div>
        <div class="col-8">
            {{-- Kalender --}}
        </div>
    </div>

</main>
<!--End Page Main-->

{{-- Include footer --}}
@include('layout.footer')

