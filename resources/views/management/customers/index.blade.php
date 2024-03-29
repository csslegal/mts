@extends('sablon.yonetim')

@section('content')
    <nav aria-label="breadcrumb">
        <ol id="breadcrumb" class="breadcrumb p-2">
            <li class="breadcrumb-item"><a href="/yonetim">Yönetim İşlemleri</a></li>
            <li class="breadcrumb-item active" aria-current="page">Müşteri Bilgileri</li>
        </ol>
    </nav>

    <div class="card mb-3">
        <div class="card-header bg-danger text-white">Müşteri Bilgileri
            <a class="float-end text-white" href="/yonetim/customers/create">Dosya Yükle</a>
        </div>
        <div class="card-body scroll">
            <table id="dtCustomersTable" class="table  table-light table-striped table-bordered display" style="width:100%">
                <thead>
                    <tr>
                        <th>URL</th>
                        <th>Adı</th>
                        <th>Telefon</th>
                        <th>E-posta</th>
                        <th>Adres</th>
                    </tr>
                </thead>
            </table>
        </div>
    </div>
@endsection
@section('js')
    <script>

    </script>
@endsection
