@extends('sablon.yonetim')

@section('title')
    Web Anasayfa
@endsection

@section('content')

    <nav aria-label="breadcrumb">
        <ol id="breadcrumb" class="breadcrumb p-2">
            <li class="breadcrumb-item"><a href="/yonetim">Yönetim İşlemleri</a></li>
            <li class="breadcrumb-item"><a href="/yonetim/web">Web İşlemleri</a></li>
            <li class="breadcrumb-item active">Paneller</li>
        </ol>
    </nav>

    <div class="card mb-3">
        <div class="card-header bg-danger text-white">Paneller</div>
        <div class="card-body">

            @if (in_array(4, $userAccesses))
                @if ($panelsTimeAccess == 1)
                    @foreach ($webGroups as $webGroup)
                        <div class="row">
                            <h5 for="" class="fw-bold"> {{ $webGroup->name }} Panelleri</h5>
                            @if ($webPanels->where('group_id', '', $webGroup->id)->count() == 0)
                                <div class="col-12 mb-3">
                                    <div class="card">
                                        <div class="card-body text-danger fw-bold">Panel yetkileri bulunamadı! Yöneticiniz
                                            ile görüşünüz.</div>
                                    </div>
                                </div>
                            @else
                                @foreach ($webPanels->where('group_id', '', $webGroup->id) as $webPanel)
                                    <div class="col-lg-4 col-md-6 col-sm-6 mb-3">
                                        <div class="card">
                                            <div class="card-body">
                                                <h6 class="card-title fw-bold">{{ $webPanel->name }}</h6>
                                                <form action="{{ $webPanel->url }}" method="POST">
                                                    <input value="{{ base64_encode(session('userName')) }}" type="hidden"
                                                        name="u">
                                                    <input value="{{ base64_encode($webPanel->name) }}" type="hidden"
                                                        name="w">
                                                    <input value="{{ base64_encode(session('userId')) }}" type="hidden"
                                                        name="i">
                                                    <input value="{{ base64_encode($webPanel->access) }}" type="hidden"
                                                        name="t_e">
                                                    <input value="{{ base64_encode(session('userTypeId')) }}"
                                                        type="hidden" name="t">
                                                    <input @php date_default_timezone_set('Europe/London'); @endphp
                                                        value="{{ 'R_' . md5(env('WEB_PANEL_S_CODE_ONE')) . '::' . md5(date(env('WEB_PANEL_S_CODE_TWO'))) . '_A' }}"
                                                        @php date_default_timezone_set('Europe/Istanbul'); @endphp type="hidden" name="s">
                                                    <input type="hidden" name="d" value="tr" />
                                                    <button type="submit"
                                                        class="w-100 mt-2 btn btn-secondary text-white float-end">Panele
                                                        git</button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                    @if ($loop->last)
                                        <hr>
                                    @endif
                                @endforeach
                            @endif
                        </div>
                    @endforeach
                @elseif ($panelsTimeAccess == 0)
                    <div class="alert alert-warning">
                        Panel yetkileri süresi aşımı oldu. Yöneticiniz ile görüşünüz.
                    </div>
                @elseif ($panelsTimeAccess == 2)
                    <div class="alert alert-danger">
                        Panel yetkileri kaydı yapılmadı! Yöneticiniz ile görüşünüz.
                    </div>
                @endif
            @else
                <div class="alert alert-danger">
                    Kullanıcı erişimleri verilmedi! Yöneticiniz ile görüşünüz.
                </div>
            @endif
        </div>
    </div>
@endsection
