@extends('sablon.genel')

@section('content')

    <nav aria-label="breadcrumb">
        <ol class="breadcrumb ">
            <li class="breadcrumb-item">
                <a href="{{ session('userTypeId') != 1 ? '/kullanici' : '/yonetim' }}">
                    {{ session('userTypeId') != 1 ? 'Kullanıcı Müşteri İşlemleri' : 'Yönetim Müşteri İşlemleri' }}
                </a>
            </li>
            <li class="breadcrumb-item"><a href="/musteri/{{ $baseCustomerDetails->id }}">Müşteri Sayfası</a></li>
            <li class="breadcrumb-item"><a href="/musteri/{{ $baseCustomerDetails->id }}/vize">Vize İşlemleri</a></li>
            <li class="breadcrumb-item active">Ödemeler</li>
        </ol>
    </nav>
    <div class="card card-primary mb-3">
        <div class="card-header bg-primary text-white">
            Alınan Ödemeler
            @if ($visaFileReceivedGradesPermitted)
                {{-- ödeme kaydı yetkisi var mı --}}
                <a class="float-end text-white" data-bs-toggle="modal" data-bs-target="#receivedPayments" href="#">Ekle</a>
            @endif
        </div>
        <div class="card-body scroll">
            <table id="dataTable" class="table table-striped table-bordered display  table-sm table-light "
                style="width:100%">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Başlıklar</th>
                        <th>Onay</th>
                        <th>İşlem Yapan</th>
                        <th>Toplam(TL)</th>
                        <th>Detaylar</th>
                        <th>Ödeme Şekli</th>
                        <th>Ödeme Tarihi</th>
                        <th>İşlem Tarihi</th>
                        <th>İşlemler</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($receivedPayments as $receivedPayment)
                        <tr>
                            <td>{{ $receivedPayment->id }}</td>
                            <td>{{ $receivedPayment->name }}</td>
                            <td>
                                @if ($receivedPayment->confirm)
                                    <span class='text-success'>Onaylı</span>
                                @else
                                    <span class='text-danger'>Onaysız</span>
                                @endif
                            </td>
                            <td>{{ $receivedPayment->user_name }}</td>
                            <td>{{ $receivedPayment->payment_total }}</td>
                            <td>
                                {{ $receivedPayment->received_tl != '' ? $receivedPayment->received_tl . 'TL' : '' }}
                                {{ $receivedPayment->received_euro != '' ? $receivedPayment->received_euro . '£' : '' }}
                                {{ $receivedPayment->received_dolar != '' ? $receivedPayment->received_dolar . '$' : '' }}
                                {{ $receivedPayment->received_pound != '' ? $receivedPayment->received_pound . '€' : '' }}
                            </td>
                            <td>{{ $receivedPayment->payment_method }}</td>
                            <td>{{ $receivedPayment->payment_date }}</td>
                            <td>{{ $receivedPayment->created_at }}</td>
                            <td class="text-center">
                                <form method="POST" action="odeme/{{ $receivedPayment->id }}">
                                    {{ method_field('DELETE') }}
                                    {{ csrf_field() }}
                                    <button type="submit" name="received" value="received" data-bs-toggle="tooltip"
                                        data-bs-placement="right" title="Sil">
                                        <i class="bi bi-x-lg"></i>
                                    </button>
                                </form>
                                @if ($receivedPayment->confirm == 0 && $visaFileReceivedConfirmGradesPermitted)
                                    <form method="POST" action="odeme/{{ $receivedPayment->id }}">
                                        {{ method_field('PUT') }}
                                        {{ csrf_field() }}
                                        <button type="submit" name="received" value="received" data-bs-toggle="tooltip"
                                            data-bs-placement="right" title="Onay">
                                            <i class="bi bi-check-lg"></i>
                                        </button>
                                    </form>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    <div class="card card-primary mb-3">
        <div class="card-header bg-primary text-white">
            Yapılan Ödemeler
            @if ($visaFileMadeGradesPermitted)
                {{-- ödeme kaydı yetkisi var mı --}}
                <a class="float-end text-white" data-bs-toggle="modal" data-bs-target="#madePayments" href="#">Ekle</a>
            @endif
        </div>
        <div class="card-body scroll">
            <table id="dataTableVize" class="table table-striped table-bordered display table-light table-sm "
                style="width:100%">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Başlıklar</th>
                        <th>İşlem Yapan</th>
                        <th>Toplam(TL)</th>
                        <th>Detaylar</th>
                        <th>Ödeme Şekli</th>
                        <th>Ödeme Tarihi</th>
                        <th>İşlem Tarihi</th>
                        <th>İşlemler</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($madePayments as $madePayment)
                        <tr>
                            <td>{{ $madePayment->id }}</td>
                            <td>{{ $madePayment->name }}</td>
                            <td>{{ $madePayment->user_name }}</td>
                            <td>{{ $madePayment->payment_total }}</td>
                            <td>
                                {{ $madePayment->made_tl != '' ? $madePayment->made_tl . 'TL' : '' }}
                                {{ $madePayment->made_euro != '' ? $madePayment->made_euro . '£' : '' }}
                                {{ $madePayment->made_dolar != '' ? $madePayment->made_dolar . '$' : '' }}
                                {{ $madePayment->made_pound != '' ? $madePayment->made_pound . '€' : '' }}
                            </td>
                            <td>{{ $madePayment->payment_method }}</td>
                            <td>{{ $madePayment->payment_date }}</td>
                            <td>{{ $madePayment->created_at }}</td>
                            <td class="text-center">
                                @if ($visaFileMadeGradesPermitted)
                                    <form method="POST" action="odeme/{{ $madePayment->id }}">
                                        {{ method_field('DELETE') }}
                                        {{ csrf_field() }}
                                        <button type="submit" name="made" value="made" data-bs-toggle="tooltip"
                                            data-bs-placement="right" title="Sil">
                                            <i class="bi bi-x-lg"></i>
                                        </button>
                                    </form>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    <div class="modal fade" id="receivedPayments" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
        aria-labelledby="receivedPaymentsLabel" style="display: none;" aria-hidden="true" aria-modal="true">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="receivedPaymentsLabel">Alınan Ödemeyi Kaydet</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form method="post" action="">
                    <div class="modal-body">
                        @csrf
                        <label class="form-label fw-bold"> Ödeme Türleri Başlıkları</label>
                        <div class="row mb-3">
                            <div class="col-md-6 ">
                                @foreach ($receivedPaymentTypes->slice(0, 5) as $receivedPaymentType)
                                    <div class="form-check">
                                        <input type="checkbox" class="form-check-input" name="alinan_odeme_tipleri[]"
                                            value="{{ $receivedPaymentType->name }}" @if (is_array(old('alinan_odeme_tipleri')) && in_array($receivedPaymentType->name, old('alinan_odeme_tipleri'))) checked @endif>
                                        {{ $receivedPaymentType->name }}
                                    </div>
                                @endforeach
                            </div>
                            <div class="col-md-6">
                                @foreach ($receivedPaymentTypes->slice(5, 5) as $receivedPaymentType)
                                    <div class="form-check">
                                        <input type="checkbox" class="form-check-input" name="alinan_odeme_tipleri[]"
                                            value="{{ $receivedPaymentType->name }}" @if (is_array(old('alinan_odeme_tipleri')) && in_array($receivedPaymentType->name, old('alinan_odeme_tipleri'))) checked @endif>
                                        {{ $receivedPaymentType->name }}
                                    </div>
                                @endforeach
                            </div>
                            <div class="col-md-6">
                                @foreach ($receivedPaymentTypes->slice(10, 5) as $receivedPaymentType)
                                    <div class="form-check">
                                        <input type="checkbox" class="form-check-input" name="alinan_odeme_tipleri[]"
                                            value="{{ $receivedPaymentType->name }}" @if (is_array(old('alinan_odeme_tipleri')) && in_array($receivedPaymentType->name, old('alinan_odeme_tipleri'))) checked @endif>
                                        {{ $receivedPaymentType->name }}
                                    </div>
                                @endforeach
                            </div>
                            <div class="col-md-12">
                                @error('alinan_odeme_tipleri')
                                    <div class="alert alert-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-lg-6 col-md-6 col-sm-12">
                                <label class="form-label"> Alınan Miktar (TL)</label>
                                <div class="row mb-3">
                                    <div class="col-md-8 col-sm-9 ">
                                        <input type="text" class="form-control" name="alinan_tl"
                                            value="{{ old('alinan_tl') }}" autocomplete="off"
                                            placeholder="Ödeme miktarı">
                                    </div>
                                    <div class="col-md-4 col-sm-3">
                                        <input type="text" class="form-control" name="alinan_tl_kurus"
                                            value="{{ old('alinan_tl_kurus') }}" autocomplete="off" value="00"
                                            placeholder="Kuruş">
                                    </div>
                                </div>
                                @error('alinan_tl')
                                    <div class="alert alert-danger">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-lg-6 col-md-6 col-sm-12">
                                <label class="form-label"> Alınan Miktar (Pound)</label>
                                <div class="row mb-3">
                                    <div class="col-md-8 col-sm-9 ">
                                        <input type="text" class="form-control" name="alinan_pound"
                                            value="{{ old('alinan_pound') }}" autocomplete="off"
                                            placeholder="Ödeme miktarı">
                                    </div>
                                    <div class="col-md-4 col-sm-3">
                                        <input type="text" class="form-control" name="alinan_pound_kurus"
                                            value="{{ old('alinan_pound_kurus') }}" autocomplete="off"
                                            placeholder="Penny">
                                    </div>
                                </div>
                                @error('alinan_pound')
                                    <div class="alert alert-danger">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-lg-6 col-md-6 col-sm-12">
                                <label class="form-label"> Alınan Miktar (Euro)</label>
                                <div class="row mb-3">
                                    <div class="col-md-8 col-sm-9 ">
                                        <input type="text" class="form-control" name="alinan_euro"
                                            value="{{ old('alinan_euro') }}" autocomplete="off"
                                            placeholder="Ödeme miktarı">
                                    </div>
                                    <div class="col-md-4 col-sm-3">
                                        <input type="text" class="form-control" name="alinan_euro_kurus"
                                            value="{{ old('alinan_euro_kurus') }}" autocomplete="off" placeholder="Sent">
                                    </div>
                                </div>
                                @error('alinan_euro')
                                    <div class="alert alert-danger">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-lg-6 col-md-6 col-sm-12">
                                <label class="form-label"> Alınan Miktar (Dolar)</label>
                                <div class="row mb-3">
                                    <div class="col-md-8 col-sm-9">
                                        <input type="text" class="form-control" name="alinan_dolar"
                                            value="{{ old('alinan_dolar') }}" autocomplete="off"
                                            placeholder="Ödeme miktarı">
                                    </div>
                                    <div class="col-md-4 col-sm-3">
                                        <input type="text" class="form-control" name="alinan_dolar_kurus"
                                            value="{{ old('alinan_dolar_kurus') }}" autocomplete="off"
                                            placeholder="Sent">
                                    </div>
                                </div>
                                @error('alinan_dolar')
                                    <div class="alert alert-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <label class="form-label">Alınan (TL) Toplam Miktar</label>
                        <div class="row mb-3">
                            <div class="col-md-8 col-sm-9">
                                <input type="text" class="form-control" name="alinan_toplam"
                                    value="{{ old('alinan_toplam') }}" autocomplete="off"
                                    placeholder="Toplam alınan ödeme">
                            </div>
                            <div class="col-md-4 col-sm-3">
                                <input type="text" class="form-control" name="alinan_toplam_kurus"
                                    value="{{ old('alinan_toplam_kurus') }}" autocomplete="off" placeholder="Kuruş">
                            </div>
                            <div class="col-md-12">
                                @error('alinan_toplam')
                                    <div class="alert alert-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Ödeme Şekli</label>
                            <select name="alinan_odeme_sekli" class=" form-control">
                                <option {{ old('alinan_odeme_sekli') == '' ? 'selected' : '' }} value="">Seçim yapınız
                                </option>
                                <option {{ old('alinan_odeme_sekli') == 'NAKİT' ? 'selected' : '' }} value="NAKİT">NAKİT
                                </option>
                                <option {{ old('alinan_odeme_sekli') == 'EFT' ? 'selected' : '' }} value="EFT">EFT
                                </option>
                                <option {{ old('alinan_odeme_sekli') == 'KREDİ KARTI' ? 'selected' : '' }}
                                    value="KREDİ KARTI">
                                    KREDİ KARTI</option>
                                <option {{ old('alinan_odeme_sekli') == 'MAİL ORDER' ? 'selected' : '' }}
                                    value="MAİL ORDER">
                                    MAİL ORDER</option>
                                <option {{ old('alinan_odeme_sekli') == 'KARGO NAKİT' ? 'selected' : '' }}
                                    value="KARGO NAKİT">
                                    KARGO NAKİT</option>
                                <option {{ old('alinan_odeme_sekli') == 'PTT' ? 'selected' : '' }} value="PTT">PTT
                                </option>
                                <option {{ old('alinan_odeme_sekli') == 'MONEY GRAM' ? 'selected' : '' }}
                                    value="MONEY GRAM">
                                    MONEY GRAM</option>
                                <option {{ old('alinan_odeme_sekli') == 'WESTERN UNİON' ? 'selected' : '' }}
                                    value="WESTERN UNİON">
                                    WESTERN UNİON</option>
                            </select>
                            @error('alinan_odeme_sekli')
                                <div class="alert alert-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Ödeme Tarihi</label>
                            <input type="text" class="form-control datepicker" name="alinan_odeme_tarihi"
                                value="{{ old('alinan_odeme_tarihi') == '' ? '' : old('alinan_odeme_tarihi') }}"
                                autocomplete="off" placeholder="Ödeme alınma tarihi" />
                            @error('alinan_odeme_tarihi')
                                <div class="alert alert-danger">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" name="received" value="received" class="btn btn-primary">Kaydet</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div class="modal fade" id="madePayments" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
        aria-labelledby="madePaymentsLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="madePaymentsLabel">Yapılan Ödemeyi Kaydet</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form method="post" action="">
                    <div class="modal-body">
                        @csrf
                        <label class="form-label fw-bold"> Ödeme Türleri Başlıkları</label>
                        <div class="row mb-3">
                            <div class="col-md-6 ">
                                @foreach ($madePaymentTypes->slice(0, 5) as $madePaymentType)
                                    <div class="form-check">
                                        <input type="checkbox" class="form-check-input" name="yapilan_odeme_tipleri[]"
                                            value="{{ $madePaymentType->name }}" @if (is_array(old('yapilan_odeme_tipleri')) && in_array($madePaymentType->name, old('yapilan_odeme_tipleri'))) checked @endif>
                                        {{ $madePaymentType->name }}
                                    </div>
                                @endforeach
                            </div>
                            <div class="col-md-6">
                                @foreach ($madePaymentTypes->slice(5, 5) as $madePaymentType)
                                    <div class="form-check">
                                        <input type="checkbox" class="form-check-input" name="yapilan_odeme_tipleri[]"
                                            value="{{ $madePaymentType->name }}" @if (is_array(old('yapilan_odeme_tipleri')) && in_array($madePaymentType->name, old('yapilan_odeme_tipleri'))) checked @endif>
                                        {{ $madePaymentType->name }}
                                    </div>
                                @endforeach
                            </div>
                            <div class="col-md-6">
                                @foreach ($madePaymentTypes->slice(10, 5) as $madePaymentType)
                                    <div class="form-check">
                                        <input type="checkbox" class="form-check-input" name="yapilan_odeme_tipleri[]"
                                            value="{{ $madePaymentType->name }}" @if (is_array(old('yapilan_odeme_tipleri')) && in_array($madePaymentType->name, old('yapilan_odeme_tipleri'))) checked @endif>
                                        {{ $madePaymentType->name }}
                                    </div>
                                @endforeach
                            </div>
                            <div class="col-md-12">
                                @error('yapilan_odeme_tipleri')
                                    <div class="alert alert-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-lg-6 col-md-6 col-sm-12">
                                <label class="form-label"> Yapılan Miktar (TL)</label>
                                <div class="row mb-3">
                                    <div class="col-md-8 col-sm-9 ">
                                        <input type="text" class="form-control" name="yapilan_tl"
                                            value="{{ old('yapilan_tl') }}" autocomplete="off"
                                            placeholder="Ödeme miktarı">
                                    </div>
                                    <div class="col-md-4 col-sm-3">
                                        <input type="text" class="form-control" name="yapilan_tl_kurus"
                                            value="{{ old('yapilan_tl_kurus') }}" autocomplete="off" value="00"
                                            placeholder="Kuruş">
                                    </div>
                                </div>
                                @error('yapilan_tl')
                                    <div class="alert alert-danger">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-lg-6 col-md-6 col-sm-12">
                                <label class="form-label"> Yapılan Miktar (Pound)</label>
                                <div class="row mb-3">
                                    <div class="col-md-8 col-sm-9 ">
                                        <input type="text" class="form-control" name="yapilan_pound"
                                            value="{{ old('yapilan_pound') }}" autocomplete="off"
                                            placeholder="Ödeme miktarı">
                                    </div>
                                    <div class="col-md-4 col-sm-3">
                                        <input type="text" class="form-control" name="yapilan_pound_kurus"
                                            value="{{ old('yapilan_pound_kurus') }}" autocomplete="off"
                                            placeholder="Penny">
                                    </div>
                                </div>
                                @error('yapilan_pound')
                                    <div class="alert alert-danger">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-lg-6 col-md-6 col-sm-12">
                                <label class="form-label"> Yapılan Miktar (Euro)</label>
                                <div class="row mb-3">
                                    <div class="col-md-8 col-sm-9 ">
                                        <input type="text" class="form-control" name="yapilan_euro"
                                            value="{{ old('yapilan_euro') }}" autocomplete="off"
                                            placeholder="Ödeme miktarı">
                                    </div>
                                    <div class="col-md-4 col-sm-3">
                                        <input type="text" class="form-control" name="yapilan_euro_kurus"
                                            value="{{ old('yapilan_euro_kurus') }}" autocomplete="off"
                                            placeholder="Sent">
                                    </div>
                                </div>
                                @error('yapilan_euro')
                                    <div class="alert alert-danger">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-lg-6 col-md-6 col-sm-12">
                                <label class="form-label"> Yapılan Miktar (Dolar)</label>
                                <div class="row mb-3">
                                    <div class="col-md-8 col-sm-9">
                                        <input type="text" class="form-control" name="yapilan_dolar"
                                            value="{{ old('yapilan_dolar') }}" autocomplete="off"
                                            placeholder="Ödeme miktarı">
                                    </div>
                                    <div class="col-md-4 col-sm-3">
                                        <input type="text" class="form-control" name="yapilan_dolar_kurus"
                                            value="{{ old('yapilan_dolar_kurus') }}" autocomplete="off"
                                            placeholder="Sent">
                                    </div>
                                </div>
                                @error('yapilan_dolar')
                                    <div class="alert alert-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <label class="form-label">Yapılan (TL) Toplam Miktar</label>
                        <div class="row mb-3">
                            <div class="col-md-8 col-sm-9">
                                <input type="text" class="form-control" name="yapilan_toplam"
                                    value="{{ old('yapilan_toplam') }}" autocomplete="off"
                                    placeholder="Toplam yapılan ödeme">
                            </div>
                            <div class="col-md-4 col-sm-3">
                                <input type="text" class="form-control" name="yapilan_toplam_kurus"
                                    value="{{ old('yapilan_toplam_kurus') }}" autocomplete="off" placeholder="Kuruş">
                            </div>
                            <div class="col-md-12">
                                @error('yapilan_toplam')
                                    <div class="alert alert-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Ödeme Şekli</label>
                            <select name="yapilan_odeme_sekli" class=" form-control">
                                <option {{ old('yapilan_odeme_sekli') == '' ? 'selected' : '' }} value="">Seçim yapınız
                                </option>
                                <option {{ old('yapilan_odeme_sekli') == 'NAKİT' ? 'selected' : '' }} value="NAKİT">NAKİT
                                </option>
                                <option {{ old('yapilan_odeme_sekli') == 'EFT' ? 'selected' : '' }} value="EFT">EFT
                                </option>
                                <option {{ old('yapilan_odeme_sekli') == 'KREDİ KARTI' ? 'selected' : '' }}
                                    value="KREDİ KARTI">
                                    KREDİ KARTI</option>
                                <option {{ old('yapilan_odeme_sekli') == 'MAİL ORDER' ? 'selected' : '' }}
                                    value="MAİL ORDER">
                                    MAİL ORDER</option>
                                <option {{ old('yapilan_odeme_sekli') == 'KARGO NAKİT' ? 'selected' : '' }}
                                    value="KARGO NAKİT">
                                    KARGO NAKİT</option>
                                <option {{ old('yapilan_odeme_sekli') == 'PTT' ? 'selected' : '' }} value="PTT">PTT
                                </option>
                                <option {{ old('yapilan_odeme_sekli') == 'MONEY GRAM' ? 'selected' : '' }}
                                    value="MONEY GRAM">
                                    MONEY GRAM</option>
                                <option {{ old('yapilan_odeme_sekli') == 'WESTERN UNİON' ? 'selected' : '' }}
                                    value="WESTERN UNİON">WESTERN UNİON</option>
                            </select>
                            @error('yapilan_odeme_sekli')
                                <div class="alert alert-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Ödeme Tarihi</label>
                            <input type="text" class="form-control datepicker1" name="yapilan_odeme_tarihi"
                                value="{{ old('yapilan_odeme_tarihi') == '' ? '' : old('yapilan_odeme_tarihi') }}"
                                autocomplete="off" placeholder="Ödeme yapılma tarihi" />
                            @error('yapilan_odeme_tarihi')
                                <div class="alert alert-danger">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" name="made" value="made" class="btn btn-primary">Kaydet</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

@endsection

@section('js')
    <script type="text/javascript">
        $(window).on('load', function() {
            @if ($errors->has('alinan_odeme_tipleri') || $errors->has('alinan_toplam') || $errors->has('alinan_odeme_sekli') || $errors->has('alinan_odeme_tarihi') || $errors->has('alinan_tl') || $errors->has('alinan_euro') || $errors->has('alinan_pound') || $errors->has('alinan_dolar'))
                $('#receivedPayments').modal('show');
            @elseif ($errors->has('yapilan_odeme_tipleri') || $errors->has('yapilan_toplam')
                || $errors->has('yapilan_odeme_sekli') || $errors->has('yapilan_odeme_tarihi') || $errors->has('yapilan_tl') ||
                $errors->has('yapilan_euro') ||$errors->has('yapilan_pound') || $errors->has('yapilan_dolar'))
                $('#madePayments').modal('show');
            @endif
        });
    </script>
@endsection
