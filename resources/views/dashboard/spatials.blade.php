<style>
    #btn-subtle {
        --bs-bg-opacity: .2;
        background-color: rgba(var(--bs-primary-rgb), var(--bs-bg-opacity)) !important;
    }
</style>

@extends('layouts.material')
@section('content')
<div class="px-5 py-2">
    <h1 class="fw-bold display-4 text-center">Kelola spasial</h1>
    <div class="py-2"></div>
    @if (session('success'))
    <div class="alert alert-success border-0 text-center" role="alert">
        {{ session('success') }}
    </div>
    @endif

    @if ($errors->any())
    <div class="alert alert-danger border-0 text-center" role="alert">
        {{ $errors->first() }}
    </div>
    @endif

    <div class="d-flex flex-row align-items-baseline">
        <div class="flex-grow-1 me-auto pe-3">
            <form action="{{ route('spatials.index') }}" method="GET">
                <div class="input-group">
                    <input type="search" name="search" class="form-control" placeholder="Cari berdasarkan nama"
                        @if(request('search')) value="{{ request('search') }}" @endif aria-label="Search"
                        aria-describedby="search">
                    <button type="submit" class="btn btn-primary btn-primary-subtle">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                            class="bi bi-search" viewBox="0 0 16 16">
                            <path
                                d="M11.742 10.344a6.5 6.5 0 1 0-1.397 1.398h-.001c.03.04.062.078.098.115l3.85 3.85a1 1 0 0 0 1.415-1.414l-3.85-3.85a1.007 1.007 0 0 0-.115-.1zM12 6.5a5.5 5.5 0 1 1-11 0 5.5 5.5 0 0 1 11 0z" />
                        </svg>
                    </button>
                </div>
            </form>
        </div>
        <button class="btn btn-primary" type="button" data-bs-toggle="collapse" data-bs-target="#collapseFormAdd"
            aria-expanded="false" aria-controls="collapseFormAdd">
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-plus-lg"
                viewBox="0 0 16 16">
                <path fill-rule="evenodd"
                    d="M8 2a.5.5 0 0 1 .5.5v5h5a.5.5 0 0 1 0 1h-5v5a.5.5 0 0 1-1 0v-5h-5a.5.5 0 0 1 0-1h5v-5A.5.5 0 0 1 8 2Z" />
            </svg>
            Tambah baru
        </button>
    </div>

    @if (request('search'))
    <div class="d-flex align-items-baseline flex-row">
        @if ($spatials->count() > 0)
        Menampilkan {{ $spatials->count() }} hasil untuk '{{ request('search') }}'
        @else
        Tidak menemukan data dengan kata kunci '{{ request('search') }}'
        @endif
        <a href="{{ route('spatials.index') }}" class="btn btn-sm btn-danger ms-2">Hapus</a>
    </div>
    <div class="my-3"></div>
    @endif

    <div class="collapse" id="collapseFormAdd">
        <div class="card p-3 d-flex flex-column">
            <h5 class="text-center">Spasial baru</h5>
            <form action="{{ route('spatials.store') }}" method="POST">
                @csrf
                <div class="mb-3">
                    <label for="formControlName" class="form-label">Nama</label>
                    <input type="text" class="form-control" id="formControlName" name="name"
                        placeholder="Misal: Kafe Adam 😎">
                </div>
                <div class="mb-3">
                    <label class="form-label">Kategori</label>
                    <select class="form-select" aria-label="Category" name="category_id">
                        @foreach ($categories as $key => $value)
                        <option value="{{ $value->id }}">{{ $value->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="mb-3">
                    <label for="formControlAddress" class="form-label">Alamat</label>
                    <input type="text" class="form-control" id="formControlAddress" name="address"
                        placeholder="Misal: Jl. Kemang">
                </div>
                <div class="mb-3">
                    <label for="formControlContact" class="form-label">Kontak</label>
                    <input type="text" class="form-control" id="formControlContact" name="contact"
                        placeholder="Misal: +62 851-5606-4770">
                </div>
                <div class="mb-3">
                    <label for="formControlAdditionalDescription" class="form-label">Deskripsi tambahan</label>
                    <input type="text" class="form-control" id="formControlAdditionalDescription"
                        name="additional_description" placeholder="Misal: Situs web risetsmartvillage.my.id">
                </div>
                <div class="mb-3">
                    <label class="form-label">Area</label>
                    <select class="form-select" aria-label="Area" name="area_id">
                        @foreach ($areas as $key => $value)
                        <option value="{{ $value->id }}">{{ $value->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="mb-3">
                    <label for="formControlLatitude" class="form-label">Latitude</label>
                    <input type="text" class="form-control" id="formControlLatitude" name="latitude"
                        placeholder="Misal: -6.12345">
                </div>
                <div class="mb-3">
                    <label for="formControlLongitude" class="form-label">Longitude</label>
                    <input type="text" class="form-control" id="formControlLongitude" name="longitude"
                        placeholder="Misal: 106.12345">
                </div>
                <div class="mb-3 d-flex flex-row justify-content-between align-items-baseline">
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" value="1" id="flexCheckMascot"
                            name="is_village_mascot">
                        <label class="form-check-label" for="flexCheckMascot">
                            Apakah pionir utama?
                        </label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" value="1" id="flexCheckOnlineStore"
                            name="has_online_store">
                        <label class="form-check-label" for="flexCheckOnlineStore">
                            Memiliki toko online?
                        </label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" value="1" id="flexCheckSmartPayment"
                            name="has_smart_payment_support">
                        <label class="form-check-label" for="flexCheckSmartPayment">
                            Mendukung smart payment?
                        </label>
                    </div>
                </div>
                <div class="d-grid gap-2">
                    <button class="btn btn-primary" type="submit">Simpan</button>
                </div>
            </form>
        </div>
        <div class="my-3"></div>
    </div>
    <div class="card p-3">
        <div class="table-responsive">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Nama</th>
                        <th scope="col">Kategori</th>
                        <th scope="col">Area</th>
                        <th scope="col" class="text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($spatials as $key => $value)
                    <tr style="vertical-align: middle">
                        <th scope="row">{{ $spatials->firstItem() + $key }}</th>
                        <td>{{ $value->name }}</td>
                        <td>{{ $value->category->name }}</td>
                        <td>{{ $value->area->name }}</td>
                        <td align="center">

                            <button type="button" class="btn btn-sm btn-primary mx-1" data-bs-toggle="modal"
                                data-bs-target="#editModal{{ $value->id }}">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                                    class="bi bi-eye" viewBox="0 0 16 16">
                                    <path
                                        d="M16 8s-3-5.5-8-5.5S0 8 0 8s3 5.5 8 5.5S16 8 16 8zM1.173 8a13.133 13.133 0 0 1 1.66-2.043C4.12 4.668 5.88 3.5 8 3.5c2.12 0 3.879 1.168 5.168 2.457A13.133 13.133 0 0 1 14.828 8c-.058.087-.122.183-.195.288-.335.48-.83 1.12-1.465 1.755C11.879 11.332 10.119 12.5 8 12.5c-2.12 0-3.879-1.168-5.168-2.457A13.134 13.134 0 0 1 1.172 8z" />
                                    <path
                                        d="M8 5.5a2.5 2.5 0 1 0 0 5 2.5 2.5 0 0 0 0-5zM4.5 8a3.5 3.5 0 1 1 7 0 3.5 3.5 0 0 1-7 0z" />
                                </svg>
                                Lihat
                            </button>

                            <a href="{{ route('spatials.destroy', $value->id) }}" class="btn btn-sm btn-danger mx-1"
                                onclick="event.preventDefault(); document.getElementById('delete-id-{{ $value->id }}').submit();">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                                    class="bi bi-trash3-fill" viewBox="0 0 16 16">
                                    <path
                                        d="M11 1.5v1h3.5a.5.5 0 0 1 0 1h-.538l-.853 10.66A2 2 0 0 1 11.115 16h-6.23a2 2 0 0 1-1.994-1.84L2.038 3.5H1.5a.5.5 0 0 1 0-1H5v-1A1.5 1.5 0 0 1 6.5 0h3A1.5 1.5 0 0 1 11 1.5Zm-5 0v1h4v-1a.5.5 0 0 0-.5-.5h-3a.5.5 0 0 0-.5.5ZM4.5 5.029l.5 8.5a.5.5 0 1 0 .998-.06l-.5-8.5a.5.5 0 1 0-.998.06Zm6.53-.528a.5.5 0 0 0-.528.47l-.5 8.5a.5.5 0 0 0 .998.058l.5-8.5a.5.5 0 0 0-.47-.528ZM8 4.5a.5.5 0 0 0-.5.5v8.5a.5.5 0 0 0 1 0V5a.5.5 0 0 0-.5-.5Z" />
                                </svg>
                                Hapus
                            </a>

                            <form id="delete-id-{{ $value->id }}" action="{{ route('spatials.destroy', $value->id) }}"
                                method="POST" class="d-none">
                                @method('DELETE')
                                @csrf
                            </form>

                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        {{ $spatials->links() }}
    </div>

</div>
@endsection


@foreach ($spatials as $key => $value)
<!-- Modal -->
<div class="modal fade" id="editModal{{ $value->id }}" tabindex="-1" aria-labelledby="editModalLabel"
    aria-hidden="true">
    <form action="{{ route('spatials.update', $value->id) }}" method="POST">
        @method('PUT')
        @csrf
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="editModalLabel">Informasi spasial</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="formControlName" class="form-label">Nama</label>
                        <input type="text" class="form-control" id="formControlName" name="name"
                            placeholder="{{ $value->name }}">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Kategori</label>
                        <select class="form-select" aria-label="Category" name="category_id">
                            @foreach ($categories as $subkey => $subvalue)
                            <option value="{{ $subvalue->id }}" @if ($value->category->id == $subvalue->id) selected
                                @endif>{{ $subvalue->name }}
                            </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="formControlAddress" class="form-label">Alamat</label>
                        <input type="text" class="form-control" id="formControlAddress" name="address"
                            placeholder="{{ $value->address }}">
                    </div>
                    <div class="mb-3">
                        <label for="formControlContact" class="form-label">Kontak</label>
                        <input type="text" class="form-control" id="formControlContact" name="contact"
                            placeholder="{{ $value->contact }}">
                    </div>
                    <div class="mb-3">
                        <label for="formControlAdditionalDescription" class="form-label">Deskripsi tambahan</label>
                        <input type="text" class="form-control" id="formControlAdditionalDescription"
                            name="additional_description" placeholder="{{ $value->additional_description }}">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Area</label>
                        <select class="form-select" aria-label="Area" name="area_id">
                            @foreach ($areas as $subkey => $subvalue)
                            <option value="{{ $subvalue->id }}" @if ($value->area->id == $subvalue->id) selected
                                @endif>{{ $subvalue->name }}
                            </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="formControlLatitude" class="form-label">Latitude</label>
                        <input type="text" class="form-control" id="formControlLatitude" name="latitude"
                            placeholder="{{ $value->latitude }}">
                    </div>
                    <div class="mb-3">
                        <label for="formControlLongitude" class="form-label">Longitude</label>
                        <input type="text" class="form-control" id="formControlLongitude" name="longitude"
                            placeholder="{{ $value->longitude }}">
                    </div>
                    <div class="mb-3 d-flex flex-row justify-content-between align-items-baseline">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" value="1" id="flexCheckMascot"
                                name="is_village_mascot" @if ($value->is_village_mascot) checked @endif>
                            <label class="form-check-label" for="flexCheckMascot">
                                Pionir utama?
                            </label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" value="1" id="flexCheckOnlineStore"
                                name="has_online_store" @if ($value->has_online_store) checked @endif>
                            <label class="form-check-label" for="flexCheckOnlineStore">
                                Memiliki toko online?
                            </label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" value="1" id="flexCheckSmartPayment"
                                name="has_smart_payment_support" @if ($value->has_smart_payment_support) checked @endif>
                            <label class="form-check-label" for="flexCheckSmartPayment">
                                Mendukung smart payment?
                            </label>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn bg-primary-subtle text-primary" data-bs-dismiss="modal">Tutup</button>
                    <button type="submit" class="btn btn-primary">Simpan perubahan</button>
                </div>
            </div>
        </div>
    </form>
</div>
@endforeach