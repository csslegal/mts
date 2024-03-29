@extends('sablon.yonetim')

@section('content')
    <nav aria-label="breadcrumb">
        <ol id="breadcrumb" class="breadcrumb p-2">
            <li class="breadcrumb-item"><a href="/yonetim">Yönetim İşlemleri</a></li>
            <li class="breadcrumb-item"><a href="/yonetim/application-office">Başvuru Ofisleri</a></li>
            <li class="breadcrumb-item active" aria-current="page">Ekle</li>
        </ol>
    </nav>

    <div class="card mb-3">
        <div class="card-header bg-danger text-white">Ekle</div>
        <div class="card-body">
            <form method="POST" action="/yonetim/application-office">
                @csrf
                <div class="row g-3">
                    <div class="col-12">
                        <label class="form-label"> Adı</label>
                        <input type="text" value="{{ old('name') }}" name="name" class="form-control">
                        @error('name')
                            <div class="alert alert-danger">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <div class="row g-3">
                    <div class="col-12">
                        <label class="form-label"> IP Adresi</label>
                        <input type="text" value="{{ old('ip') }}" name="ip" class="form-control">
                        @error('ip')
                            <div class="alert alert-danger">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <button class="w-100 mt-3 btn btn-secondary text-white btn-lg" type="submit">Tamamla</button>
            </form>
        </div>
    </div>

@endsection
