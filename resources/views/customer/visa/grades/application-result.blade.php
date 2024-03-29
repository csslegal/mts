@extends('sablon.genel')

@section('title')
    Sonuç Bekleyen Dosyalar
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
            <li class="breadcrumb-item active">Sonuç Bekleyen Dosyalar</li>
        </ol>
    </nav>

    <div class="card card-danger mb-3">
        <div class="card-header bg-danger text-white">Sonuç Bekleyen Dosya İşlemleri</div>
        <div class="card-body scroll">
            <form action="" method="POST" id="formSonuc">
                @csrf
                <div class="mb-3">
                    <label class="form-label">Başvuru Sonucu</label>
                    <select name="sonuc" onchange="durum()" id="sonuc" class="form-control ">
                        <option selected value="1">Olumlu</option>
                        <option value="0">Olumsuz</option>
                        <option value="2">İade</option>
                    </select>
                    @error('sonuc')
                        <div class="alert alert-danger">{{ $message }}</div>
                    @enderror
                </div>
                <div class="mb-3" id="vbat">
                    <label class="form-label">Vize Başlangıç Tarihi</label>
                    <input type="text" class="form-control" id="date1" autocomplete="off"
                        name="vize_baslangic_tarihi"
                        value="{{ old('vize_baslangic_tarihi') ? old('vize_baslangic_tarihi') : '' }}" />
                    @error('vize_baslangic_tarihi')
                        <div class="alert alert-danger">{{ $message }}</div>
                    @enderror
                </div>
                <div class="mb-3" id="vbit">
                    <label class="form-label">Vize Bitiş Tarihi</label>
                    <input type="text" class="form-control" id="date2" autocomplete="off" name="vize_bitis_tarihi"
                        value="{{ old('vize_bitis_tarihi') ? old('vize_bitis_tarihi') : '' }}" />
                    @error('vize_bitis_tarihi')
                        <div class="alert alert-danger">{{ $message }}</div>
                    @enderror
                </div>
                <div class="mb-3" id="vta">
                    <label class="form-label">Vize Teslim Alınma Tarihi</label>
                    <input type="text" class="form-control" autocomplete="off" name="vize_teslim_alinma_tarihi"
                        id="date3" value="{{ old('vize_teslim_alinma_tarihi') ? old('vize_teslim_alinma_tarihi') : '' }}" />
                    @error('vize_teslim_alinma_tarihi')
                        <div class="alert alert-danger">{{ $message }}</div>
                    @enderror
                </div>
                <div class="mb-3" id="rs">
                    <label class="form-label">Ret Sebebi</label>
                    <input type="text" class="form-control" id="red_sebebi" autocomplete="off" name="red_sebebi"
                        value="{{ old('red_sebebi') ? old('red_sebebi') : '' }}" />
                    @error('red_sebebi')
                        <div class="alert alert-danger">{{ $message }}</div>
                    @enderror
                </div>
                <div class="mb-3" id="rt">
                    <label class="form-label">Ret Tarihi</label>
                    <input type="text" class="form-control" id="date4" autocomplete="off"
                        name="red_tarihi" value="{{ old('red_tarihi') ? old('red_tarihi') : '' }}" />
                    @error('red_tarihi')
                        <div class="alert alert-danger">{{ $message }}</div>
                    @enderror
                </div>
                <div class="mb-3" id="rat">
                    <label class="form-label">Ret Teslim Alınma Tarihi</label>
                    <input type="text" class="form-control" id="date5" autocomplete="off"
                        name="red_teslim_alinma_tarihi"
                        value="{{ old('red_teslim_alinma_tarihi') ? old('red_teslim_alinma_tarihi') : '' }}" />
                    @error('red_teslim_alinma_tarihi')
                        <div class="alert alert-danger">{{ $message }}</div>
                    @enderror
                </div>
                <button type="submit" class="w-100 mt-2 btn btn-secondary text-white confirm"
                    data-content="Devam edilsin mi?">Aşamayı Tamamla</button>
            </form>
        </div>
    </div>
@endsection

@section('js')
    <script>
        $(document).ready(function() {
            if ($("#sonuc").val() == 1) {
                $("#rs,#rt,#rat").css("display", "none");
                $("vbat,#vbit,#vta").css("display", "block");
            } else if ($("#sonuc").val() == 0) {
                $("#rs,#rt,#rat").css("display", "block");
                $("vbat,#vbit,#vta").css("display", "none");
            } else {
                $("vbat,#vbit,#vta").css("display", "none");
                $("#rs,#rt,#rat").css("display", "none");
            }
        });

        function durum() {
            if ($("#sonuc").val() == 1) {

                $("#rs,#rt,#rat").css("display", "none");
                $("#vbat,#vbit,#vta").css("display", "block");

                document.getElementById('date4').value = '';
                document.getElementById('date5').value = '';
                document.getElementById('red_sebebi').value = '';
            } else if ($("#sonuc").val() == 0) {

                $("#rs,#rt,#rat").css("display", "block");
                $("#vbat,#vbit,#vta").css("display", "none");

                document.getElementById('date1').value = '';
                document.getElementById('date2').value = '';
                document.getElementById('date3').value = '';
            } else {

                $("#rs,#rt,#rat").css("display", "none");
                $("#vbat,#vbit,#vta").css("display", "none");

                document.getElementById('date4').value = '';
                document.getElementById('date5').value = '';
                document.getElementById('red_sebebi').value = '';

                document.getElementById('date1').value = '';
                document.getElementById('date2').value = '';
                document.getElementById('date3').value = '';
            }
        }
    </script>
@endsection
