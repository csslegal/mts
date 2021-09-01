@extends('sablon.yonetim')

@section('content')
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb ">
            <li class="breadcrumb-item"><a href="/yonetim">Yönetim İşlemleri</a></li>
            <li class="breadcrumb-item"><a href="/yonetim/vize">Vize İşlemleri</a></li>
            <li class="breadcrumb-item active" aria-current="page">Dosya Aşamaları</li>
        </ol>
    </nav>
    <div class="card card-primary mb-3">
        <div class="card-header bg-primary text-white">
            Dosya Aşamaları
            <a class="float-end text-white" href="/yonetim/vize/dosya-asama/create">Ekle</a>
        </div>
        <div class="card-body scroll">
            <table id="dataTable" class="table table-striped table-bordered display table-light " style="width:100%">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Adı</th>
                        <th>E. Tarih</th>
                        <th>G. Tarih</th>
                        <th class="text-center">Sırala</th>
                        <th class="text-center">İşlem</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($kayitlar as $kayit)
                        <tr>
                            <td>{{ $kayit->orderby }}</td>
                            <td>{{ $kayit->name }}</td>
                            <td>{{ $kayit->created_at }}</td>
                            <td>{{ $kayit->updated_at }}</td>
                            <td class="text-center">
                                <div class="btn-group" role="group" aria-label="Basic example">
                                    <button data-bs-toggle="tooltip" data-bs-placement="top"
                                        onclick="sorting({{ $kayit->id }},'up','visa_file_grades')" title="Üst">
                                        <i class="bi bi-arrow-up"></i>
                                    </button>
                                    <button data-bs-toggle="tooltip" data-bs-placement="top"
                                        onclick="sorting({{ $kayit->id }},'down','visa_file_grades')" title="Alt">
                                        <i class="bi bi-arrow-down"></i>
                                    </button>
                                </div>
                            </td>
                            <td class="text-center">
                                <div class="btn-group" role="group" aria-label="Basic example">
                                    <a href="/yonetim/vize/dosya-asama/{{ $kayit->id }}/edit">
                                        <button data-bs-toggle="tooltip" data-bs-placement="top" title="Düzenle">
                                            <i class="bi bi-pencil-square "></i>
                                        </button>
                                    </a>
                                    <form action="/yonetim/vize/dosya-asama/{{ $kayit->id }}" method="post">
                                        @method('DELETE')
                                        @csrf
                                        <button type="submit" data-bs-toggle="tooltip" data-bs-placement="top" title="Sil">
                                            <i class="bi bi-x-lg"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection
@section('js')
    <script>
        function sorting(id,status,table) {
            $.ajax({
                type: 'POST',
                url: "/yonetim/ajax/sirala",
                data: {
                    'id': id,
                    'table': table,
                    'status': status,
                    "_token": "{{ csrf_token() }}",
                },
                success: function(data, status, xhr) {
                    location.reload();
                },
                error: function(data, status, xhr) {
                    location.reload();
                }
            });
        }
    </script>
@endsection