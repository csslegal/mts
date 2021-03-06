<div class="card card-primary mb-3">
    <div class="card-header bg-danger text-white  fw-bold">Cari Dosya Detayları
        @if (session('userTypeId') == 1)
            <a data-bs-toggle="modal" onclick="asama();" data-bs-target="#exampleModal" class="float-end fw-bold text-white"
                href="#">Dosya Aşama İşlemleri</a>
        @endif
    </div>

    <div class="card-body scroll">
        <div class="row">
            <div class="col-lg-4">
                <span class=" fw-bold">Cari Dosya Detayı</span>
                <ul>
                    <li>
                        <span class="fw-bold">Referans Numarası:</span>
                        <span>{{ $visaFileDetail->id }}</span>
                    </li>
                    <li>
                        <span class="fw-bold">Vize Süresi:</span>
                        <span>{{ $visaFileDetail->visa_validity_name }}</span>
                    </li>
                    <li>
                        <span class="fw-bold">Dosya Aciliyeti:</span>
                        <span>{{ $visaFileDetail->status == 0 ? 'Normal' : 'Acil' }}</span>
                    </li>
                    <li>
                        <span class="fw-bold">Vize Tipi:</span>
                        <span>
                            {{ $visaFileDetail->visa_type_name }} /
                            {{ $visaFileDetail->visa_sub_type_name }}
                        </span>
                    </li>
                </ul>
            </div>
            <div class="col-lg-4">
                <span class=" fw-bold">Randevu Bilgisi</span>
                <ul>
                    <li>
                        <span class="fw-bold">GWF Numarası:</span>
                        <span>{{ $visaFileDetail->visa_appointments_gwf == '' ? 'Sonuç bulunamadı' : $visaFileDetail->visa_appointments_gwf }}</span>
                    </li>
                    <li>
                        <span class="fw-bold">Tarih:</span>
                        <span>{{ $visaFileDetail->visa_appointments_date == '' ? 'Sonuç bulunamadı' : $visaFileDetail->visa_appointments_date }}</span>
                    </li>
                    <li>
                        <span class="fw-bold">Saat:</span>
                        <span>{{ $visaFileDetail->visa_appointments_time == '' ? 'Sonuç bulunamadı' : $visaFileDetail->visa_appointments_time }}</span>
                    </li>
                    <li>
                        <span class="fw-bold">İşlem Tarihi</span>
                        <span>{{ $visaFileDetail->visa_appointments_created_at == '' ? 'Sonuç bulunamadı' : $visaFileDetail->visa_appointments_created_at }}</span>
                    </li>
                </ul>
            </div>
            <div class="col-lg-4">
                <span class=" fw-bold">İlgili Personel</span>
                <ul>
                    <li>
                        <span class="fw-bold">Danışman:</span>
                        <span>{{ $visaFileDetail->advisor_name == '' ? 'Sonuç bulunamadı' : $visaFileDetail->advisor_name }}</span>
                    </li>
                    <li>
                        <span class="fw-bold">Uzman:</span>
                        <span>{{ $visaFileDetail->expert_name == '' ? 'Sonuç bulunamadı' : $visaFileDetail->expert_name }}</span>
                    </li>
                    <li>
                        <span class="fw-bold">Tercüman:</span>
                        <span>{{ $visaFileDetail->translator_name == '' ? 'Sonuç bulunamadı' : $visaFileDetail->translator_name }}</span>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</div>
