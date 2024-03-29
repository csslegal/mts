@extends('sablon.yonetim')

@section('content')
    <nav aria-label="breadcrumb">
        <ol id="breadcrumb" class="breadcrumb p-2">
            <li class="breadcrumb-item"><a href="/yonetim">Yönetim İşlemleri</a></li>
            <li class="breadcrumb-item"><a href="/yonetim/vize">Vize İşlemleri</a></li>
            <li class="breadcrumb-item active" aria-current="page">Grafikler</li>
        </ol>
    </nav>

    <div class="row">
        <div class="col-12">
            <h2>Kota Grafikleri</h2>
        </div>
        <div class="col-xxl-3 col-lg-6 col-md-6">
            <div class="card mb-1">
                <div class="card-body">
                    <div style="width: 100%"><canvas id="myChartQuotaDay"></canvas></div>
                </div>
            </div>
        </div>
        <div class="col-xxl-3 col-lg-6 col-md-6"">
            <div class="card mb-1">
                <div class="card-body">
                    <div style="width: 100%"><canvas id="myChartQuotaWeek"></canvas></div>
                </div>
            </div>
        </div>
        <div class="col-xxl-3 col-lg-6 col-md-6"">
            <div class="card mb-1">
                <div class="card-body">
                    <div style="width: 100%"><canvas id="myChartQuotaMount"></canvas></div>
                </div>
            </div>
        </div>
        <div class="col-xxl-3 col-lg-6 col-md-6"">
            <div class="card mb-1">
                <div class="card-body">
                    <div style="width: 100%"><canvas id="myChartQuotaYear"></canvas></div>
                </div>
            </div>
        </div>
    </div>

    <div class="row mb-3 mt-3">
        <div class="col-12">
            <div class="card mb-1">
                <div class="card-body">
                    <div style="width: 100%;height:300px;" ><canvas id="myChart"></canvas></div>
                </div>
            </div>
        </div>
    </div>

    <div class="row mb-3 mt-3">
        <div class="col-12">
            <h2> Analiz Grafikleri
                <div class="float-end">
                    <form action="" method="GET">
                        <div class="input-group input-group-sm">
                            <span class="input-group-text bg-danger text-white">Tarih Filtresi:</span>
                            <select class="form-control" name="filter" id="">
                                <option value="dosya" @if (request()->get('filter') == 'dosya') selected @endif>Dosya Açma</option>
                                <option value="log" @if (request()->get('filter') == 'log') selected @endif>Son İşlem</option>
                            </select>
                            <span class="input-group-text bg-danger text-white">Dosya Tipi:</span>
                            <select class="form-control" name="status" id="">
                                <option value="cari" @if (request()->get('status') == 'cari') selected @endif>Cari</option>
                                <option value="arsiv" @if (request()->get('status') == 'arsiv') selected @endif>Arşiv</option>
                                <option value="all" @if (request()->get('status') == 'all') selected @endif>Tümü</option>
                            </select>
                            <span class="input-group-text bg-danger text-white">Tarih Aralığı:</span>
                            <input type="text" name="dates"
                                value="{{ request('dates') ? request('dates') : date('Y-m-01') . '--' . date('Y-m-28') }}"
                                autocomplete="off" id="dates1" class="form-control">
                            <button type="submit" class="btn btn-secondary">Uygula</button>
                        </div>
                    </form>
                </div>
            </h2>

        </div>
        <div class="col-xxl-4 col-xl-4 col-lg-4">
            <div class="card mb-1">
                <div class="card-body">
                    <div style="width: 100%;height:300px;"><canvas id="myChart1"></canvas></div>
                </div>
            </div>
        </div>
        <div class="col-xxl-3 col-xl-3 col-lg-3">
            <div class="card mb-1">
                <div class="card-body">
                    <div style="width: 100%;height:300px;"><canvas id="myChart2"></canvas></div>
                </div>
            </div>
        </div>
        <div class="col-xxl-5 col-xl-5 col-lg-5">
            <div class="card mb-1">
                <div class="card-body">
                    <div style="width: 100%;height:300px;"><canvas id="myChart6"></canvas></div>
                </div>
            </div>
        </div>
    </div>

    <div class="row mb-3 mt-3">
        <div class="col-12">
            <h2> Personel Grafikleri
                <div class="float-end">
                    <form action="" method="GET">
                        <div class="input-group input-group-sm">
                            <span class="input-group-text bg-danger text-white">Tarih Filtresi:</span>
                            <select class="form-control" name="filter" id="">
                                <option value="dosya" @if (request()->get('filter') == 'dosya') selected @endif>Dosya Açma</option>
                                <option value="log" @if (request()->get('filter') == 'log') selected @endif>Son İşlem</option>
                            </select>
                            <span class="input-group-text bg-danger text-white">Dosya Tipi:</span>
                            <select class="form-control" name="status" id="">
                                <option value="cari" @if (request()->get('status') == 'cari') selected @endif>Cari</option>
                                <option value="arsiv" @if (request()->get('status') == 'arsiv') selected @endif>Arşiv</option>
                                <option value="all" @if (request()->get('status') == 'all') selected @endif>Tümü</option>
                            </select>
                            <span class="input-group-text bg-danger text-white">Tarih Aralığı:</span>
                            <input type="text" name="dates"
                                value="{{ request('dates') ? request('dates') : date('Y-m-01') . '--' . date('Y-m-28') }}"
                                autocomplete="off" id="dates2" class="form-control">
                            <button type="submit" class="btn btn-secondary">Uygula</button>
                        </div>
                    </form>
                </div>
            </h2>
        </div>
        <div class="col-xxl-6 col-xl-6 col-lg-6">
            <div class="card mb-1">
                <div class="card-body">
                    <div style="width: 100%"><canvas id="myChart3"></canvas></div>
                </div>
            </div>
        </div>
        <div class="col-xxl-6 col-xl-6 col-lg-6">
            <div class="card mb-1">
                <div class="card-body">
                    <div style="width: 100%"><canvas id="myChart4"></canvas></div>
                </div>
            </div>
        </div>
        <div class="col-xxl-6 col-xl-6 col-lg-6">
            <div class="card mb-1">
                <div class="card-body">
                    <div style="width: 100%"><canvas id="myChart5"></canvas></div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('css')
@endsection

@section('js')
    <script src="{{ asset('js/chart.js/chart.min.js') }}"></script>
    <script>
        var loadTime = 100;
        var plusLoadTime = 300;
        //günlük haftalık aylık ve yıllık acılan dosya sayıları
        setTimeout(function() {
            ajax_chart("polarArea", "myChartQuotaDay", "", "/yonetim/ajax/quota-day")
        }, loadTime += plusLoadTime);
        setTimeout(function() {
            ajax_chart("polarArea", "myChartQuotaWeek", "", "/yonetim/ajax/quota-week")
        }, loadTime += plusLoadTime);
        setTimeout(function() {
            ajax_chart("polarArea", "myChartQuotaMount", "", "/yonetim/ajax/quota-mount")
        }, loadTime += plusLoadTime);
        setTimeout(function() {
            ajax_chart("polarArea", "myChartQuotaYear", "", "/yonetim/ajax/quota-year")
        }, loadTime += plusLoadTime);
        //açılan ve tamamlanan dosya sayıları
        setTimeout(function() {
            ajax_chart("bar", "myChart", "Dosya sayısı",
                "/yonetim/ajax/open-made-analist?filter={{ request('filter') }}&status={{ request('status') }}&dates={{ request('dates') }}"
            )
        }, loadTime += plusLoadTime);
        //aşamalara göre dosya sayısı
        setTimeout(function() {
            ajax_chart("bar", "myChart1", "Dosya sayısı",
                "/yonetim/ajax/grades-count?filter={{ request('filter') }}&status={{ request('status') }}&dates={{ request('dates') }}"
            )
        }, loadTime += plusLoadTime);
        //ofislere gore dosya sayısı
        setTimeout(function() {
            ajax_chart("bar", "myChart2", "Dosya sayısı",
                "/yonetim/ajax/application-office-count?filter={{ request('filter') }}&status={{ request('status') }}&dates={{ request('dates') }}"
            )
        }, loadTime += plusLoadTime);
        //vize turune göre dosya sayısı
        setTimeout(function() {
            ajax_chart("bubble", "myChart6", "Dosya sayısı",
                "/yonetim/ajax/visa-types-analist?filter={{ request('filter') }}&status={{ request('status') }}&dates={{ request('dates') }}"
            )
        }, loadTime += plusLoadTime);
        //danışman analızleri
        setTimeout(function() {
            ajax_chart("bubble", "myChart3", "Dosya sayısı",
                "/yonetim/ajax/advisor-analist?filter={{ request('filter') }}&status={{ request('status') }}&dates={{ request('dates') }}"
            )
        }, loadTime += plusLoadTime);
        //uzman analızleri
        setTimeout(function() {
            ajax_chart("bubble", "myChart4", "Dosya sayısı",
                "/yonetim/ajax/expert-analist?filter={{ request('filter') }}&status={{ request('status') }}&dates={{ request('dates') }}"
            )
        }, loadTime += plusLoadTime);
        //tercuman analizleri
        setTimeout(function() {
            ajax_chart("bubble", "myChart5", "Dosya sayısı",
                "/yonetim/ajax/translator-analist?filter={{ request('filter') }}&status={{ request('status') }}&dates={{ request('dates') }}"
            )
        }, loadTime += plusLoadTime)

        function ajax_chart(types, id, labell, url, data) {
            var data = data || {};
            var ctx = document.getElementById(id).getContext("2d");

            if (types == "bar" || types == "polarArea") {

                if (id == "myChart") {

                    var chart = new Chart(ctx, {
                        type: types,
                        data: {
                            labels: [],
                            datasets: []
                        },
                        options: {
                            responsive: true,
                            maintainAspectRatio: false,
                            plugins: {
                                legend: {
                                    display: false,
                                    position: 'top',
                                },
                                title: {
                                    display: true,
                                    text: ''
                                }
                            },
                        },
                    });
                } else {
                    var chart = new Chart(ctx, {
                        type: types,
                        data: {
                            labels: [],
                            datasets: [{
                                label: labell,
                                backgroundColor: [],
                                borderColor: [],
                                data: [],

                                borderWidth: 1,
                                borderRadius: 20,
                                borderSkipped: false
                            }]
                        },
                        options: {
                            responsive: true,
                            maintainAspectRatio: false,
                            plugins: {
                                legend: {
                                    position: 'top',
                                    display: false,
                                },
                                title: {
                                    display: true,
                                    text: ''
                                }
                            }
                        },
                    });
                }
            } else if (types == "bubble") {
                if (id != "myChart5") {
                    var chart = new Chart(ctx, {
                        type: types,
                        data: {
                            datasets: []
                        },
                        options: {
                            plugins: {
                                tooltip: {
                                    callbacks: {
                                        label: function(context) {
                                            return [
                                                context.dataset.label + ' Analizler',
                                                'Vize sayısı: ' + context.parsed.x,
                                                'Red sayısı: ' + context.parsed.y,
                                                'Başarı oranı: %' + Math.round(
                                                    context.parsed.x / (context.parsed.x + context
                                                        .parsed
                                                        .y) *
                                                    100
                                                ),
                                            ];
                                        }
                                    }
                                },
                                legend: {
                                    display: false,
                                    position: 'top',
                                },
                                title: {
                                    display: true,
                                    text: ''
                                }
                            },
                            scales: {
                                y: {
                                    type: 'linear',
                                    grace: '5%'
                                },
                                x: {
                                    type: 'linear',
                                    grace: '5%'
                                }
                            }
                        }
                    });
                } else {
                    var chart = new Chart(ctx, {
                        type: types,
                        data: {
                            datasets: []
                        },
                        options: {
                            plugins: {
                                tooltip: {
                                    callbacks: {
                                        label: function(context) {
                                            return [
                                                context.dataset.label + ' Tercüme Bilgisi',
                                                'Sayfa sayısı: ' + context.raw.x,
                                                'Kelime sayısı: ' + context.raw.y,
                                            ];
                                        }
                                    }
                                },
                                legend: {
                                    display: false,
                                    position: 'top',
                                },
                                title: {
                                    display: true,
                                    text: ''
                                }
                            },
                            scales: {
                                y: {
                                    type: 'linear',
                                    grace: '5%'
                                },
                                x: {
                                    type: 'linear',
                                    grace: '5%'
                                }
                            }
                        }
                    });
                }
            }
            $.getJSON(url, data).done(function(response) {
                chart.options.plugins.title.text = response.title;
                if (types == "bar" || types == "polarArea") {
                    if (id == "myChart") {
                        chart.data.labels = response.labels;
                        chart.data.datasets = response.datasets;
                    } else {
                        chart.data.labels = response.labels;
                        chart.data.datasets[0].data = response.data.quantity;
                        chart.data.datasets[0].borderColor = response.borderColor;
                        chart.data.datasets[0].backgroundColor = response.backgroundColor;
                    }
                } else if (types == "bubble") {
                    chart.data.datasets = response.datasets;
                }
                chart.update(); // finally update our chart
            });
        }
    </script>
@endsection
