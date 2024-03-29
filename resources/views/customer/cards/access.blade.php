<div class="row">
    @if (in_array(1, $userAccesses))
        <div class="col-12">
            <div class="card mb-3">
                <div class="card-body">
                    <h5 class="card-title">Vize İşlemleri</h5>
                    <ul>
                        <li>
                            @if (!is_null($visaFileGradesDescLog))
                                Müşteri
                                <span class="fw-bold text-danger">
                                    {{ $visaFileGradesDescLog->visa_file_id }}
                                </span>
                                numaralı cari dosyası bulundu.
                            @else
                                Müşteri cari dosyası bulunamadı.
                            @endif
                        </li>
                        <li>
                            <span class="fw-bold">Son İşlem ve Tarihi:</span>
                            <span>
                                @if (!is_null($visaFileGradesDescLog))
                                    {{ $visaFileGradesDescLog->subject }},
                                    {{ $visaFileGradesDescLog->user_name }}
                                    tarafından
                                    {{ $visaFileGradesDescLog->created_at }}
                                    tarihinde yapıldı.
                                @else
                                    Kayıt bulunamadı.
                                @endif
                            </span>
                        </li>
                    </ul>
                    <a href="/musteri/{{ $baseCustomerDetails->id }}/vize" class="w-100 mt-2 btn btn-secondary">İşleme Yap</a>
                </div>
            </div>
        </div>
    @endif
    @if (in_array(2, $userAccesses))
        <div class="col-12">
            <div class="card border-dark mb-3">
                <div class="card-body">
                    <h5 class="card-title">Harici Tercüme İşlemleri</h5>
                    <ul>
                        <li>Cari dosyası var</li>
                        <li>
                            <span class="fw-bold">
                                Son İşlem ve Tarihi:
                            </span>
                            Başvuru ödeme alınması bekleniyor tamamlandı <br>{{ date('Y-m-d H:i:s') }}
                        </li>
                    </ul>
                    <a href="/musteri/{{ $baseCustomerDetails->id }}/harici" class="w-100 mt-2 btn btn-secondary">İşleme Yap</a>
                </div>
            </div>
        </div>
    @endif
    @if (in_array(3, $userAccesses))
        <div class="col-12">
            <div class="card border-dark mb-3">
                <div class="card-body">
                    <h5 class="card-title">Dil Okulu İşlemleri</h5>
                    <ul>
                        <li>Cari dosyası var</li>
                        <li>
                            <span class="fw-bold">Son İşlem ve Tarihi:</span>
                            Başvuru ödeme alınması bekleniyor tamamlandı <br>{{ date('Y-m-d H:i:s') }}
                        </li>
                    </ul>
                    <a href="/musteri/{{ $baseCustomerDetails->id }}/dilokulu" class="w-100 mt-2 btn btn-secondary">İşleme Yap</a>
                </div>
            </div>
        </div>
    @endif
</div>
