@extends('sablon.genel')

@section('title')
    İptal Edilen Randevu
@endsection

@section('content')
    <nav aria-label="breadcrumb">
        <ol id="breadcrumb" class="breadcrumb p-2 ">
            <li class="breadcrumb-item">
                <a href="{{ session('userTypeId') != 1 ? '/kullanici' : '/yonetim' }}">
                    {{ session('userTypeId') != 1 ? 'Kullanıcı Müşteri İşlemleri' : 'Yönetim Müşteri İşlemleri' }}
                </a>
            </li>
            <li class="breadcrumb-item"><a href="/musteri/{{ $baseCustomerDetails->id }}">Müşteri Sayfası</a></li>
            <li class="breadcrumb-item"><a href="/musteri/{{ $baseCustomerDetails->id }}/vize">Vize İşlemleri</a></li>
            <li class="breadcrumb-item active">İptal Edilen Randevu</li>
        </ol>
    </nav>
    <div class="card card-primary mb-3">
        <div class="card-header bg-primary text-white">Bütün İşlemler</div>
        <div class="card-body scroll">
            <div class="row">
                <div class="col-lg-4 col-md-6 col-sm-6 ">
                    <div class="card border-success mb-2">
                        <div class="card-body">
                            <h5 class="card-title">Dosyayı Kapat</h5>
                            <p>&nbsp;</p>
                            <form action="" method="POST">
                                @csrf
                                <input type="hidden" name="kapat" value="kapat">
                                <button type="submit" class="btn btn-success float-end text-white confirm"
                                    data-title="Dikkat!" data-content="Devam edilsin mi?">Kapat</button>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6 col-sm-6 ">
                    <div class="card border-info mb-2">
                        <div class="card-body">
                            <h5 class="card-title">Uzmana Gönder</h5>
                            <p>&nbsp;</p>
                            <form action="" method="POST">
                                @csrf
                                <input type="hidden" name="uzman" value="ertele">
                                <button type="submit" class="btn btn-info float-end text-white"
                                    onClick="this.form.submit(); this.disabled=true;">Gönder</button>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6 col-sm-6 ">
                    <div class="card border-danger mb-2">
                        <div class="card-body">
                            <h5 class="card-title">Dosyayı Onayla</h5>
                            <p>&nbsp;</p>
                            <form action="" method="POST">
                                @csrf
                                <input type="hidden" name="onay" value="onay">
                                <button type="submit" class="btn btn-danger float-end text-white"
                                    onClick="this.form.submit(); this.disabled=true;">Onayla</button>
                            </form>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    @endsection
