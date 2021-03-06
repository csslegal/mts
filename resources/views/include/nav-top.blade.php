<nav id="navbar" class="navbar navbar-expand-lg navbar-dark bg-dark mb-3">
    <div class="container-fluid">
        <a class="navbar-brand" href="#">Müşteri Takip Sistemi</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent"
            aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                <li class="nav-item">
                    <a href="/"
                        class="nav-link {{ request()->is('kullanici') || request()->is('yonetim') ? 'active' : '' }}">
                        <i class="bi bi-house-fill"></i>&nbspAna Sayfa
                    </a>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle {{ request()->is('yonetim/profil') || request()->is('kullanici/profil') || request()->is('kullanici/duyuru') ? 'active' : '' }}"
                        href="#" id="navbarScrollingDropdown" role="button" data-bs-toggle="dropdown"
                        aria-expanded="false">
                        @if (session('userTypeId') == 1)
                            <i class="bi bi-person-fill"></i>&nbspYönetim İşlemleri
                        @else
                            <i class="bi bi-person-fill"></i>&nbspKullanıcı İşlemleri
                        @endif
                    </a>
                    <ul class="dropdown-menu" aria-labelledby="navbarScrollingDropdown">
                        @if (session('userTypeId') == 1)
                            <li>
                                <a class="dropdown-item  {{ request()->is('yonetim/profil') ? 'active' : '' }}"
                                    href="/yonetim/profil">
                                    <i class="bi bi-person-fill"></i>&nbspProfilim
                                </a>
                            </li>
                        @else
                            <li>
                                <a class="dropdown-item  {{ request()->is('kullanici/profil') ? 'active' : '' }}"
                                    href="/kullanici/profil">
                                    <i class="bi bi-person-fill"></i>&nbspProfilim
                                </a>
                            </li>
                            <li>
                                <a class="dropdown-item  {{ request()->is('kullanici/duyuru') ? 'active' : '' }}"
                                    href="/kullanici/duyuru">
                                    <i class="bi bi-stack"></i>&nbspDuyurular
                                </a>
                            </li>
                        @endif
                    </ul>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle {{ request()->is('musteri/sorgula') || request()->is('musteri/create') ? 'active' : '' }}"
                        href="#" id="navbarScrollingDropdown" role="button" data-bs-toggle="dropdown"
                        aria-expanded="false"><i class="bi bi-people-fill"></i>&nbspMüşteri
                        İşlemleri</a>
                    <ul class="dropdown-menu " aria-labelledby="navbarScrollingDropdown">
                        <li>
                            <a class="dropdown-item {{ request()->is('musteri/sorgula') ? 'active' : '' }}"
                                href="/musteri/sorgula"><i class="bi bi-search"></i>&nbspMüşteri Sorgula</a>
                        </li>
                        <li>
                            <a class="dropdown-item {{ request()->is('musteri/create') ? 'active' : '' }}"
                                href="/musteri/create"><i class="bi bi-person-plus-fill"></i>&nbspMüşteri Kayıt</a>
                        </li>
                    </ul>
                </li>

                <li class="nav-item">
                    <a href="/cikis" class="nav-link">
                        <i class="bi bi-door-closed-fill"></i>&nbspÇıkış
                    </a>
                </li>
            </ul>
            <ul class="navbar-nav">
                <li class="nav-item fw-bold">
                    <a href="#" class="nav-link active">
                        @if (session('userTypeId') == 1)
                            Süresiz Oturum
                        @else
                            <span>
                                Çıkışa
                                {{ floor((session('session') - time()) / 60) }}:{{ floor((session('session') - time()) % 60) }}
                            </span>
                        @endif
                    </a>
                </li>
            </ul>
        </div>
    </div>
</nav>
