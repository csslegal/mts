@extends('sablon.genel')

@section('title')
    Başvuru Bekleyen Dosyalar
@endsection

@section('content')
    <nav aria-label="breadcrumb">
        <ol id="breadcrumb" class="breadcrumb p-2">
            <li class="breadcrumb-item">
                <a href="{{ session('userTypeId') != 1 ? '/kullanici' : '/yonetim' }}">
                    {{ session('userTypeId') != 1 ? 'Kullanıcı Müşteri İşlemleri' : 'Yönetim Müşteri İşlemleri' }}
                </a>
            </li>
            <li class="breadcrumb-item"><a href="/musteri/{{ $baseCustomerDetails->id }}">Müşteri Sayfası</a></li>
            <li class="breadcrumb-item"><a href="/musteri/{{ $baseCustomerDetails->id }}/vize">Vize İşlemleri</a></li>
            <li class="breadcrumb-item active">Başvuru Bekleyen Dosyalar</li>
        </ol>
    </nav>
    <div class="card card-danger mb-3">
        <div class="card-header bg-danger text-white">Başvuru Bekleyen Dosya İşlemleri</div>
        <div class="card-body scroll">
            <form action="" method="POST">
                @csrf
                <div class="mb-3">
                    @if (session('userTypeId') == 1)
                        <label class="form-label">Dosya Uzmanı</label>
                        <select name="uzman" class="form-control">
                            <option selected value="">Lütfen seçim yapın</option>
                            @foreach ($users as $user)
                                @if ($user->user_type_id == env('EXPERT_USER_TYPE_ID') && $user->active == 1)
                                    <option {{ old('uzman') == $user->id ? 'selected' : '' }} value="{{ $user->id }}">
                                        {{ $user->name }}</option>
                                @endif
                            @endforeach
                        </select>
                    @endif
                    @error('uzman')
                        <div class="alert alert-danger">{{ $message }}</div>
                    @enderror
                </div>
                <div class="mb-3">
                    <label class="form-label">GWF Numarası</label>
                    <input type="text" name="gwf" autocomplete="off" class="form-control"
                        placeholder="GWF numarası girin" value="{{ old('gwf') }}" />
                    @error('gwf')
                        <div class="alert alert-danger">{{ $message }}</div>
                    @enderror
                </div>
                <div class="mb-3">
                    <label class="form-label">Randevu Ofisi</label>
                    <select class="form-select" name="ofis">
                        <option value="">Randevu ofisini seçiniz</option>
                        @foreach ($appointmentOffices as $appointmentOffice)
                            <option {{ $visaFile->appointment_office_id == $appointmentOffice->id ? 'selected' : '' }}
                                value="{{ $appointmentOffice->id }}">
                                {{ $appointmentOffice->name }}
                            </option>
                        @endforeach
                    </select>
                    @error('ofis')
                        <div class="alert alert-danger">{{ $message }}</div>
                    @enderror
                </div>
                <div class="mb-3">
                    <label class="form-label">Hesap Adı</label>
                    <input type="text" name="hesap_adi" autocomplete="off" class="form-control"
                        placeholder="Hesap adını girin" value="{{ old('hesap_adi') }}" />
                    @error('hesap_adi')
                        <div class="alert alert-danger">{{ $message }}</div>
                    @enderror
                </div>
                <div class="mb-3">
                    <label class="form-label">Hesap Şifresi</label>
                    <input type="text" name="sifre" autocomplete="off" class="form-control"
                        placeholder="Hesap şifresi girin" value="{{ old('sifre') }}" />
                    @error('sifre')
                        <div class="alert alert-danger">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label class="form-label">Randevu Tarihi</label>
                    <input type="text" class="form-control" id="date1" name="tarih" autocomplete="off"
                        placeholder="Randevu tarihi girin" value="{{ old('tarih') }}" />
                    @error('tarih')
                        <div class="alert alert-danger">{{ $message }}</div>
                    @enderror
                </div>
                <div class="mb-3">
                    <label class="form-label">Randevu Saati</label>
                    <select name="saat" class="form-control">
                        <option value="">Seçim yapınız</option>
                        @foreach ($times as $time)
                            <option {{ $time->name == old('saat') ? 'selected' : '' }} value="{{ $time->name }}">
                                {{ $time->name }}
                            </option>
                        @endforeach
                    </select>
                    @error('saat')
                        <div class="alert alert-danger">{{ $message }}</div>
                    @enderror
                </div>
                <button type="submit" class="w-100 mt-2 btn btn-secondary text-white confirm" data-title="Dikkat!"
                    data-content="Müşteri randevusu kaydedilsin mı?">Aşamayı Tamamla</button>
            </form>
        </div>
    </div>
@endsection
