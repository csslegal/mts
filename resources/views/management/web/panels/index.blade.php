@extends('sablon.yonetim')

@section('content')
    <nav aria-label="breadcrumb">
        <ol id="breadcrumb" class="breadcrumb p-2">
            <li class="breadcrumb-item"><a href="/yonetim">Yönetim İşlemleri</a></li>
            <li class="breadcrumb-item"><a href="/yonetim/web">Web İşlemleri</a></li>
            <li class="breadcrumb-item active" aria-current="page">Paneller</li>
        </ol>
    </nav>

    <div class="card mb-3">
        <div class="card-header bg-danger text-white">Paneller
            <a class="float-end text-white" href="/yonetim/web/panels/create">Ekle</a>
        </div>
        <div class="card-body scroll">
            <table id="dataTable" class="table  table-light table-striped table-bordered display" style="width:100%">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Panel Statusu</th>
                        <th>Grup Adı</th>
                        <th>Panel Adı</th>
                        <th>Token</th>
                        <th>E. Tarih</th>
                        <th>G. Tarih</th>
                        <th>İşlem</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($results as $result)
                        <tr>
                            <td>{{ $result->id }}</td>

                            @if ($result->panel_status == 1)
                                <td>Site Paneli</td>
                            @else
                                <td>Web API Paneli</td>
                            @endif

                            <td>{{ $result->g_name }}</td>
                            <td>{{ $result->p_name }}</td>
                            <td>{{ $result->p_token }}</td>
                            <td>{{ date('Y-m-d', strtotime($result->created_at)) }}</td>
                            <td>{{ date('Y-m-d', strtotime($result->updated_at)) }}</td>
                            <td>
                                <div class="btn-group" role="group" aria-label="Basic example">
                                    <a href="/yonetim/web/panels/{{ $result->id }}/edit">
                                        <button data-bs-toggle="tooltip" data-bs-placement="top" title="Düzenle">
                                            <i class="bi bi-pencil-square "></i>
                                        </button>
                                    </a>
                                    <form action="/yonetim/web/panels/{{ $result->id }}" method="post">
                                        @method('DELETE')
                                        @csrf
                                        <button type="submit" data-bs-toggle="tooltip" data-bs-placement="right"
                                            title="Sil"><i class="bi bi-x-lg"></i>
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
