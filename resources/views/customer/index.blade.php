@extends('sablon.genel')

@section('title')
    Müşteri Anasayfa
@endsection

@section('content')
    <nav aria-label="breadcrumb">
        <ol id="breadcrumb" class="breadcrumb p-2 ">
            <li class="breadcrumb-item">
                <a href="{{ session('userTypeId') != 1 ? '/kullanici' : '/yonetim' }}">
                    {{ session('userTypeId') != 1 ? 'Kullanıcı Müşteri İşlemleri' : 'Yönetim Müşteri İşlemleri' }}
                </a>
            </li>
            <li class="breadcrumb-item active">Müşteri Sayfası</li>
        </ol>
    </nav>

    @include('customer.cards.customer-process')

    @include('customer.cards.base-information')

    @include('customer.cards.access')

    @include('customer.cards.notes')

    <!-- Modal -->
    @include('customer.modals.content-load')

    @include('customer.modals.note-add-modal')
@endsection

@section('js')
    <script>
        function contentLoad(ne, id) {
            var url = "";
            if (ne == 'not') {
                url = "/musteri/ajax/not-goster";
            } else if (ne == 'email') {
                url = "/musteri/ajax/email-goster";
            }
            $("#contentLoad").html('İçerik alınıyor...');
            $.ajax({
                type: 'POST',
                url: url,
                data: {
                    'id': id,
                    "_token": "{{ csrf_token() }}",
                },
                success: function(data, status, xhr) {
                    $("#contentLoad").html(data['content']);
                },
                error: function(data, status, xhr) {
                    $("#contentLoad")
                        .html('<div class="alert alert-error" > ' + xhr + ' </div> ');
                }
            });
        }

        function notSil(id) {
            $.ajax({
                type: 'POST',
                url: "/musteri/ajax/not-sil",
                data: {
                    'id': id,
                    "_token": "{{ csrf_token() }}",
                },
                success: function(data, status, xhr) {
                    location.reload();
                },
                error: function(data, status, xhr) {
                    alert(xhr);
                }
            });
        }
    </script>
@endsection
