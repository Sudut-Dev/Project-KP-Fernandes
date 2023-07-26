@include('layout.header')

<!--start content-->
<main class="page-content">

    <!--breadcrumb-->
    <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
        <div class="breadcrumb-title pe-3">PENGGUNA</div>
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
        <div class="col-4">
            {{-- Alert set --}}
            @include('components.alert-set')
        </div>
    </div>

    {{-- Card --}}
    <div class="row">
        <div class="col-4">
            <div class="card">
                <div class="card-header d-flex justify-content-end">
                    <button id="show-profile-form-container" class="btn btn-sm">
                        <i class="bi bi-pen"></i>
                    </button>
                </div>
                <div class="card-body p-4">
                    <center class="mb-4">
                        @if ($user->gender == 'Pria')
                            <img src="{{ asset('images/avatars/man.png') }}" alt="" class="rounded-circle" width="150"
                                height="150">
                        @else
                            <img src="{{ asset('images/avatars/woman.png') }}" alt="" class="rounded-circle"
                                width="150" height="150">
                        @endif
                    </center>

                    <span class="text-dark d-block">Nama :</span>
                    <span class="mb-3 d-block">{{ $user->name }}</span>

                    <span class="text-dark d-block">Email :</span>
                    <span class="mb-3 d-block">{{ $user->email }}</span>

                    <span class="text-dark d-block">Telepon :</span>
                    <span class="mb-3 d-block">{{ $user->phone }}</span>

                    <span class="text-dark d-block">Jenis Kelamin :</span>
                    <span class="mb-3 d-block">{{ $user->gender }}</span>
                </div>
            </div>
        </div>
        <div id="profile-form-container" class="col-8 d-none">
            <div class="">
                <div class="card-body">
                    <form action="{{ route('profile.edit') }}" method="POST">
                        @csrf
                        @method('PATCH')
                        <div class="row">
                            <div class="col-lg-6">
                                {{-- Username --}}
                                <div class="mb-4">
                                    <label class="mb-2" for="username">Username :</label>
                                    <div class="input-group">
                                        <span class="input-group-text">
                                            <i class="bi bi-person"></i>
                                        </span>
                                        <input name="username" id="username" type="text"
                                            class="form-control
                                    @error('username') is-invalid @enderror"
                                            placeholder="Username" aria-label="Username"
                                            value="{{ old('username', $user->username) }}">
                                    </div>
                                    @error('username')
                                        <span class="text-danger position-absolute d-block">
                                            <small>
                                                {{ $message }}
                                            </small>
                                        </span>
                                    @enderror
                                </div>

                                {{-- Name --}}
                                <div class="mb-4">
                                    <label class="mb-2" for="name">Nama :</label>
                                    <div class="input-group">
                                        <span class="input-group-text">
                                            <i class="bi bi-card-heading"></i>
                                        </span>
                                        <input name="name" id="name" type="text"
                                            class="form-control
                                    @error('name') is-invalid @enderror"
                                            placeholder="Nama" aria-label="name"
                                            value="{{ old('name', $user->name) }}">
                                    </div>
                                    @error('name')
                                        <span class="text-danger position-absolute d-block">
                                            <small>
                                                {{ $message }}
                                            </small>
                                        </span>
                                    @enderror
                                </div>

                                {{-- Email --}}
                                <div class="mb-4">
                                    <label class="mb-2" for="email">Email :</label>
                                    <div class="input-group">
                                        <span class="input-group-text">
                                            <i class="bi bi-envelope"></i>
                                        </span>
                                        <input name="email" id="email" type="email"
                                            class="form-control
                                    @error('email') is-invalid @enderror"
                                            placeholder="Email" aria-label="email"
                                            value="{{ old('email', $user->email) }}">
                                    </div>
                                    @error('email')
                                        <span class="text-danger position-absolute d-block">
                                            <small>
                                                {{ $message }}
                                            </small>
                                        </span>
                                    @enderror
                                </div>

                                {{-- Phone --}}
                                <div class="mb-4">
                                    <label class="mb-2" for="phone">Nomor Telepon :</label>
                                    <div class="input-group">
                                        <span class="input-group-text">
                                            <i class="bi bi-phone"></i>
                                        </span>
                                        <input name="phone" id="phone" type="text"
                                            class="form-control
                                    @error('phone') is-invalid @enderror"
                                            placeholder="Nomor Telepon" aria-label="phone"
                                            value="{{ old('phone', $user->phone) }}">
                                    </div>
                                    @error('phone')
                                        <span class="text-danger position-absolute d-block">
                                            <small>
                                                {{ $message }}
                                            </small>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                        </div>
                        <div class="row">
                            <div class="col d-flex justify-content-end">
                                <button type="submit" class="btn btn-sm btn-primary d-inline-block px-5">
                                    Simpan
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    {{-- End card --}}

</main>

@include('layout.footer')
