@extends('sablon.yonetim')

@section('content')
    <nav aria-label="breadcrumb">
        <ol id="breadcrumb" class="breadcrumb p-2">
            <li class="breadcrumb-item"><a href="/yonetim">Yönetim İşlemleri</a></li>
            <li class="breadcrumb-item"><a href="/yonetim/customers">Müşteri Bilgileri</a></li>
            <li class="breadcrumb-item active" aria-current="page">Dosya Yükle</li>
        </ol>
    </nav>

    <div class="card mb-3">
        <div class="card-header bg-danger text-white">Müşteri Bilgilerini Sisteme Yükle</div>
        <div class="card-body">
            <form method="POST" action="/yonetim/customers" enctype="multipart/form-data">
                @csrf
                <div class="row g-3">
                    <div class="col-12">
                        <label class="form-label">Excel Dosyası</label>
                        <input type="file" value="{{ old('file') }}" name="file" class="form-control">
                        @error('file')
                            <div class="alert alert-danger">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <button class="w-100 mt-3 btn btn-secondary text-white btn-lg" type="submit">Tamamla</button>
            </form>
        </div>
    </div>
@endsection
