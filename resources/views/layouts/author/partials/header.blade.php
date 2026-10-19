{{-- <style>
    .dropdown-menu {
        max-height: 250px; /* Adjust height as needed */
        overflow-y: auto;
        width: 200px;
    }
    .dropdown-item {
        display: flex;
        align-items: center;
        gap: 10px;
    }
    .flag-icon {
        width: 20px;
        height: 14px;
    }
</style> --}}
<header class="main-header-section">
    <div class="header-wrapper">
        <div class="header-left">
            <div class="sidebar-opner"><i class="fal fa-bars" aria-hidden="true"></i></div>
        </div>
        <div class="header-middle"></div>
        <div class="header-right">
            @if (auth()->user()->role == 'superadmin')
            <div class="notifications dropdown">
                <a href="#" class="dropdown-toggleer mt-1 me-3" data-bs-toggle="dropdown">
                    <i><img src="{{ asset('assets/images/icons/bel.svg') }}" alt=""></i>
                    <span class="bg-red">{{ auth()->user()->unreadNotifications ->count() }}</span>
                </a>
                <div class="dropdown-menu">
                    <div class="notification-header">
                        <p>You Have <strong>{{ auth()->user()->unreadNotifications->count() }}</strong> new Notifications</p>
                        <a href="{{ route('author.notifications.mtReadAll') }}" class="text-red">Mark all Read</a>
                    </div>
                    <ul>
                        @foreach (auth()->user()->unreadNotifications  as $notification)
                        <li>
                            <a href="{{ route('author.notifications.mtView', $notification->id) }}">
                                <strong>{{ __($notification->data['message'] ?? '') }}</strong>
                                <span>{{ $notification->created_at->diffForHumans() }}</span>
                            </a>
                        </li>
                        @endforeach
                    </ul>
                    <div class="notification-footer">
                        <a class="text-red" href="{{ route('author.notifications.index') }}">View all notifications</a>
                    </div>
                </div>
            </div>
            @endif

            <div class="language-change">
                <div class="dropdown">
                    @php
                        /* $languages = [
                            'ar' => ['name' => 'Arabic', 'flag' => 'sa'],
                            'bn' => ['name' => 'Bengali', 'flag' => 'bd'],
                            'cn' => ['name' => 'Chinese', 'flag' => 'cn'],
                            'en' => ['name' => 'English', 'flag' => 'us'],
                            'fr' => ['name' => 'French', 'flag' => 'fr'],
                            'de' => ['name' => 'German', 'flag' => 'de'],
                            'hi' => ['name' => 'Hindi', 'flag' => 'in'],
                            'es' => ['name' => 'Spanish', 'flag' => 'es'],
                            'jp' => ['name' => 'Japanese', 'flag' => 'jp'],
                            'ro' => ['name' => 'Romanian', 'flag' => 'ro'],
                            'vn' => ['name' => 'Vietnamese', 'flag' => 'vn'],
                            'it' => ['name' => 'Italian', 'flag' => 'it'],
                            'th' => ['name' => 'Thai', 'flag' => 'th'],
                        ];
                    */
                    // $currentLocale = session('locale', 'en');
                        //$selectedLang = $languages[$currentLocale] ?? $languages['en'];

                        $currentLocale = session('locale', 'en');
                        $selectedLang = $glanguages->firstWhere('alias', $currentLocale) ?? $glanguages->firstWhere('alias', 'en');

                    @endphp

                    <div class="dropdown">
                        <button class="btn btn-light dropdown-toggle d-flex align-items-center" type="button" data-bs-toggle="dropdown" id="selectedLanguageBtn">
                            <img id="selectedFlag" src="{{ asset('flags/'.$selectedLang->flag??'https://flagcdn.com/w40/'.$selectedLang->alias.'png') }}" width="20" height="14" class="me-2">
                            <span id="selectedText">{{ $selectedLang['name'] }}</span>
                        </button>

                        <ul class="dropdown-menu p-0 overflow-auto" style="max-height: 250px;">
                            @foreach($glanguages as $code => $lang)
                                <li>
                                    <a class="dropdown-item d-flex align-items-center language-option" href="{{ route('author.locale', $lang->alias) }}">
                                        <img src="{{ asset('flags/'.$lang->flag??'https://flagcdn.com/w40/'.$lang->alias.'png') }}" width="20" height="14" class="me-2">
                                        {{ $lang['name'] }}
                                    </a>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>

            {{-- <div class="dropdown">
                <button class="btn btn-light dropdown-toggle d-flex align-items-center" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                    <img src="https://flagcdn.com/w40/us.png" width="20" height="14" class="me-2"> English
                </button>
                <ul class="dropdown-menu p-0 overflow-auto" style="max-height: 250px;">
                    <li><a class="dropdown-item d-flex align-items-center" href="#"><img src="https://flagcdn.com/w40/sa.png" width="20" height="14" class="me-2"> Arabic</a></li>
                    <li><a class="dropdown-item d-flex align-items-center" href="#"><img src="https://flagcdn.com/w40/bd.png" width="20" height="14" class="me-2"> Bengali</a></li>
                    <li><a class="dropdown-item d-flex align-items-center" href="#"><img src="https://flagcdn.com/w40/cn.png" width="20" height="14" class="me-2"> Chinese</a></li>
                    <li><a class="dropdown-item d-flex align-items-center" href="{{ route('author.locale', ['locale' => 'en']) }}"><img src="https://flagcdn.com/w40/us.png" width="20" height="14" class="me-2"> English</a></li>
                    <li><a class="dropdown-item d-flex align-items-center" href="{{ route('author.locale', ['locale' => 'fr']) }}"><img src="https://flagcdn.com/w40/fr.png" width="20" height="14" class="me-2"> French</a></li>
                    <li><a class="dropdown-item d-flex align-items-center" href="#"><img src="https://flagcdn.com/w40/de.png" width="20" height="14" class="me-2"> German</a></li>
                    <li><a class="dropdown-item d-flex align-items-center" href="#"><img src="https://flagcdn.com/w40/in.png" width="20" height="14" class="me-2"> Hindi</a></li>
                    <li><a class="dropdown-item d-flex align-items-center" href="#"><img src="https://flagcdn.com/w40/es.png" width="20" height="14" class="me-2"> Spanish</a></li>
                    <li><a class="dropdown-item d-flex align-items-center" href="#"><img src="https://flagcdn.com/w40/jp.png" width="20" height="14" class="me-2"> Japanese</a></li>
                    <li><a class="dropdown-item d-flex align-items-center" href="#"><img src="https://flagcdn.com/w40/ro.png" width="20" height="14" class="me-2"> Romanian</a></li>
                    <li><a class="dropdown-item d-flex align-items-center" href="#"><img src="https://flagcdn.com/w40/vn.png" width="20" height="14" class="me-2"> Vietnamese</a></li>
                    <li><a class="dropdown-item d-flex align-items-center" href="#"><img src="https://flagcdn.com/w40/it.png" width="20" height="14" class="me-2"> Italian</a></li>
                    <li><a class="dropdown-item d-flex align-items-center" href="#"><img src="https://flagcdn.com/w40/th.png" width="20" height="14" class="me-2"> Thai</a></li>
                </ul>
            </div> --}}


             {{-- <div class="language-change">
                <div class="dropdown">
                    <button class="btn btn-light dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                        <img src="https://maannews.acnoo.com/flags/us.svg" alt="" class="flag-icon me-2">
                        English
                    </button>
                    <ul class="dropdown-menu dropdown-menu-scrollable shadow" style="">
                                                    <li>
                                <a class="dropdown-item" href="{{ route('author.locale', ['locale' => 'en']) }}">
                                    <img src="https://maannews.acnoo.com/flags/us.svg" alt="" class="flag-icon me-2">
                                    English
                                </a>
                            </li>
                                                    <li>
                                <a class="dropdown-item" href="https://maannews.acnoo.com/admin/dashboard?lang=ar">
                                    <img src="https://maannews.acnoo.com/flags/sa.svg" alt="" class="flag-icon me-2">
                                    Arabic
                                </a>
                            </li>
                                                    <li>
                                <a class="dropdown-item" href="https://maannews.acnoo.com/admin/dashboard?lang=bn">
                                    <img src="https://maannews.acnoo.com/flags/bd.svg" alt="" class="flag-icon me-2">
                                    Bengali
                                </a>
                            </li>
                                                    <li>
                                <a class="dropdown-item" href="https://maannews.acnoo.com/admin/dashboard?lang=zh">
                                    <img src="https://maannews.acnoo.com/flags/cn.svg" alt="" class="flag-icon me-2">
                                    Chinese
                                </a>
                            </li>
                                                    <li>
                                <a class="dropdown-item" href="{{ route('author.locale', ['locale' => 'fr']) }}">
                                    <img src="https://maannews.acnoo.com/flags/fr.svg" alt="" class="flag-icon me-2">
                                    French
                                </a>
                            </li>
                                                    <li>
                                <a class="dropdown-item" href="https://maannews.acnoo.com/admin/dashboard?lang=de">
                                    <img src="https://maannews.acnoo.com/flags/de.svg" alt="" class="flag-icon me-2">
                                    German
                                </a>
                            </li>
                                                    <li>
                                <a class="dropdown-item" href="https://maannews.acnoo.com/admin/dashboard?lang=hi">
                                    <img src="https://maannews.acnoo.com/flags/in.svg" alt="" class="flag-icon me-2">
                                    Hindi
                                </a>
                            </li>
                                                    <li>
                                <a class="dropdown-item" href="https://maannews.acnoo.com/admin/dashboard?lang=es">
                                    <img src="https://maannews.acnoo.com/flags/es.svg" alt="" class="flag-icon me-2">
                                    Spanish
                                </a>
                            </li>
                                                    <li>
                                <a class="dropdown-item" href="https://maannews.acnoo.com/admin/dashboard?lang=ja">
                                    <img src="https://maannews.acnoo.com/flags/jp.svg" alt="" class="flag-icon me-2">
                                    Japanese
                                </a>
                            </li>
                                                    <li>
                                <a class="dropdown-item" href="https://maannews.acnoo.com/admin/dashboard?lang=rum">
                                    <img src="https://maannews.acnoo.com/flags/ro.svg" alt="" class="flag-icon me-2">
                                    Romanian
                                </a>
                            </li>
                                                    <li>
                                <a class="dropdown-item" href="https://maannews.acnoo.com/admin/dashboard?lang=vi">
                                    <img src="https://maannews.acnoo.com/flags/vn.svg" alt="" class="flag-icon me-2">
                                    Vietnamese
                                </a>
                            </li>
                                                    <li>
                                <a class="dropdown-item" href="https://maannews.acnoo.com/admin/dashboard?lang=it">
                                    <img src="https://maannews.acnoo.com/flags/it.svg" alt="" class="flag-icon me-2">
                                    Italian
                                </a>
                            </li>
                                                    <li>
                                <a class="dropdown-item" href="https://maannews.acnoo.com/admin/dashboard?lang=th">
                                    <img src="https://maannews.acnoo.com/flags/th.svg" alt="" class="flag-icon me-2">
                                    Thai
                                </a>
                            </li>
                                                    <li>
                                <a class="dropdown-item" href="https://maannews.acnoo.com/admin/dashboard?lang=bs">
                                    <img src="https://maannews.acnoo.com/flags/ba.svg" alt="" class="flag-icon me-2">
                                    Bosnian
                                </a>
                            </li>
                                                    <li>
                                <a class="dropdown-item" href="https://maannews.acnoo.com/admin/dashboard?lang=nl">
                                    <img src="https://maannews.acnoo.com/flags/nl.svg" alt="" class="flag-icon me-2">
                                    Dutch
                                </a>
                            </li>
                                                    <li>
                                <a class="dropdown-item" href="https://maannews.acnoo.com/admin/dashboard?lang=pt">
                                    <img src="https://maannews.acnoo.com/flags/pt.svg" alt="" class="flag-icon me-2">
                                    Portuguese
                                </a>
                            </li>
                                                    <li>
                                <a class="dropdown-item" href="https://maannews.acnoo.com/admin/dashboard?lang=pl">
                                    <img src="https://maannews.acnoo.com/flags/pl.svg" alt="" class="flag-icon me-2">
                                    Polish
                                </a>
                            </li>
                                                    <li>
                                <a class="dropdown-item" href="https://maannews.acnoo.com/admin/dashboard?lang=he">
                                    <img src="https://maannews.acnoo.com/flags/il.svg" alt="" class="flag-icon me-2">
                                    Hebrew
                                </a>
                            </li>
                                                    <li>
                                <a class="dropdown-item" href="https://maannews.acnoo.com/admin/dashboard?lang=hu">
                                    <img src="https://maannews.acnoo.com/flags/hu.svg" alt="" class="flag-icon me-2">
                                    Hungarian
                                </a>
                            </li>
                                                    <li>
                                <a class="dropdown-item" href="https://maannews.acnoo.com/admin/dashboard?lang=fi">
                                    <img src="https://maannews.acnoo.com/flags/fi.svg" alt="" class="flag-icon me-2">
                                    Finnish
                                </a>
                            </li>
                                                    <li>
                                <a class="dropdown-item" href="https://maannews.acnoo.com/admin/dashboard?lang=el">
                                    <img src="https://maannews.acnoo.com/flags/gr.svg" alt="" class="flag-icon me-2">
                                    Greek
                                </a>
                            </li>
                                                    <li>
                                <a class="dropdown-item" href="https://maannews.acnoo.com/admin/dashboard?lang=ko">
                                    <img src="https://maannews.acnoo.com/flags/kr.svg" alt="" class="flag-icon me-2">
                                    Korean
                                </a>
                            </li>
                                                    <li>
                                <a class="dropdown-item" href="https://maannews.acnoo.com/admin/dashboard?lang=ms">
                                    <img src="https://maannews.acnoo.com/flags/my.svg" alt="" class="flag-icon me-2">
                                    Malay
                                </a>
                            </li>
                                                    <li>
                                <a class="dropdown-item" href="https://maannews.acnoo.com/admin/dashboard?lang=id">
                                    <img src="https://maannews.acnoo.com/flags/id.svg" alt="" class="flag-icon me-2">
                                    Indonesian
                                </a>
                            </li>
                                                    <li>
                                <a class="dropdown-item" href="https://maannews.acnoo.com/admin/dashboard?lang=fa">
                                    <img src="https://maannews.acnoo.com/flags/ir.svg" alt="" class="flag-icon me-2">
                                    Persian
                                </a>
                            </li>
                                                    <li>
                                <a class="dropdown-item" href="https://maannews.acnoo.com/admin/dashboard?lang=tr">
                                    <img src="https://maannews.acnoo.com/flags/tr.svg" alt="" class="flag-icon me-2">
                                    Turkish
                                </a>
                            </li>
                                                    <li>
                                <a class="dropdown-item" href="https://maannews.acnoo.com/admin/dashboard?lang=sr">
                                    <img src="https://maannews.acnoo.com/flags/rs.svg" alt="" class="flag-icon me-2">
                                    Serbian
                                </a>
                            </li>
                                                    <li>
                                <a class="dropdown-item" href="https://maannews.acnoo.com/admin/dashboard?lang=km">
                                    <img src="https://maannews.acnoo.com/flags/khm.svg" alt="" class="flag-icon me-2">
                                    Khmer
                                </a>
                            </li>
                                                    <li>
                                <a class="dropdown-item" href="https://maannews.acnoo.com/admin/dashboard?lang=uk">
                                    <img src="https://maannews.acnoo.com/flags/ua.svg" alt="" class="flag-icon me-2">
                                    Ukrainian
                                </a>
                            </li>
                                                    <li>
                                <a class="dropdown-item" href="https://maannews.acnoo.com/admin/dashboard?lang=lo">
                                    <img src="https://maannews.acnoo.com/flags/la.svg" alt="" class="flag-icon me-2">
                                    Lao
                                </a>
                            </li>
                                                    <li>
                                <a class="dropdown-item" href="https://maannews.acnoo.com/admin/dashboard?lang=ru">
                                    <img src="https://maannews.acnoo.com/flags/ru.svg" alt="" class="flag-icon me-2">
                                    Russian
                                </a>
                            </li>
                                                    <li>
                                <a class="dropdown-item" href="https://maannews.acnoo.com/admin/dashboard?lang=cs">
                                    <img src="https://maannews.acnoo.com/flags/cz.svg" alt="" class="flag-icon me-2">
                                    Czech
                                </a>
                            </li>
                                                    <li>
                                <a class="dropdown-item" href="https://maannews.acnoo.com/admin/dashboard?lang=kn">
                                    <img src="https://maannews.acnoo.com/flags/ka.svg" alt="" class="flag-icon me-2">
                                    Kannada
                                </a>
                            </li>
                                                    <li>
                                <a class="dropdown-item" href="https://maannews.acnoo.com/admin/dashboard?lang=mr">
                                    <img src="https://maannews.acnoo.com/flags/mh.svg" alt="" class="flag-icon me-2">
                                    Marathi
                                </a>
                            </li>
                                                    <li>
                                <a class="dropdown-item" href="https://maannews.acnoo.com/admin/dashboard?lang=sv">
                                    <img src="https://maannews.acnoo.com/flags/se.svg" alt="" class="flag-icon me-2">
                                    Swedish
                                </a>
                            </li>
                                                    <li>
                                <a class="dropdown-item" href="https://maannews.acnoo.com/admin/dashboard?lang=da">
                                    <img src="https://maannews.acnoo.com/flags/dk.svg" alt="" class="flag-icon me-2">
                                    Danish
                                </a>
                            </li>
                                                    <li>
                                <a class="dropdown-item" href="https://maannews.acnoo.com/admin/dashboard?lang=ur">
                                    <img src="https://maannews.acnoo.com/flags/pk.svg" alt="" class="flag-icon me-2">
                                    Urdu
                                </a>
                            </li>
                                                    <li>
                                <a class="dropdown-item" href="https://maannews.acnoo.com/admin/dashboard?lang=sq">
                                    <img src="https://maannews.acnoo.com/flags/al.svg" alt="" class="flag-icon me-2">
                                    Albanian
                                </a>
                            </li>
                                                    <li>
                                <a class="dropdown-item" href="https://maannews.acnoo.com/admin/dashboard?lang=sk">
                                    <img src="https://maannews.acnoo.com/flags/sk.svg" alt="" class="flag-icon me-2">
                                    Slovak
                                </a>
                            </li>
                                                    <li>
                                <a class="dropdown-item" href="https://maannews.acnoo.com/admin/dashboard?lang=bur">
                                    <img src="https://maannews.acnoo.com/flags/mm.svg" alt="" class="flag-icon me-2">
                                    Burmese
                                </a>
                            </li>
                                                    <li>
                                <a class="dropdown-item" href="https://maannews.acnoo.com/admin/dashboard?lang=ti">
                                    <img src="https://maannews.acnoo.com/flags/er.svg" alt="" class="flag-icon me-2">
                                    Tigrinya
                                </a>
                            </li>
                                                    <li>
                                <a class="dropdown-item" href="https://maannews.acnoo.com/admin/dashboard?lang=kz">
                                    <img src="https://maannews.acnoo.com/flags/kz.svg" alt="" class="flag-icon me-2">
                                    Kazakh
                                </a>
                            </li>
                                                    <li>
                                <a class="dropdown-item" href="https://maannews.acnoo.com/admin/dashboard?lang=az">
                                    <img src="https://maannews.acnoo.com/flags/az.svg" alt="" class="flag-icon me-2">
                                    Azerbaijani
                                </a>
                            </li>
                                                    <li>
                                <a class="dropdown-item" href="https://maannews.acnoo.com/admin/dashboard?lang=zh-cn">
                                    <img src="https://maannews.acnoo.com/flags/zh-cn.svg" alt="" class="flag-icon me-2">
                                    Chinese (CN)
                                </a>
                            </li>
                                                    <li>
                                <a class="dropdown-item" href="https://maannews.acnoo.com/admin/dashboard?lang=zh-tw">
                                    <img src="https://maannews.acnoo.com/flags/zh-tw.svg" alt="" class="flag-icon me-2">
                                    Chinese (TW)
                                </a>
                            </li>
                                                    <li>
                                <a class="dropdown-item" href="https://maannews.acnoo.com/admin/dashboard?lang=pt-br">
                                    <img src="https://maannews.acnoo.com/flags/pt-br.svg" alt="" class="flag-icon me-2">
                                    Portuguese (BR)
                                </a>
                            </li>
                                                    <li>
                                <a class="dropdown-item" href="https://maannews.acnoo.com/admin/dashboard?lang=tz">
                                    <img src="https://maannews.acnoo.com/flags/tz.svg" alt="" class="flag-icon me-2">
                                    Swahili
                                </a>
                            </li>
                                                    <li>
                                <a class="dropdown-item" href="https://maannews.acnoo.com/admin/dashboard?lang=ps">
                                    <img src="https://maannews.acnoo.com/flags/af.svg" alt="" class="flag-icon me-2">
                                    Pashto
                                </a>
                            </li>
                                                    <li>
                                <a class="dropdown-item" href="https://maannews.acnoo.com/admin/dashboard?lang=prs">
                                    <img src="https://maannews.acnoo.com/flags/afdari.svg" alt="" class="flag-icon me-2">
                                    Dari
                                </a>
                            </li>
                                                    <li>
                                <a class="dropdown-item" href="https://maannews.acnoo.com/admin/dashboard?lang=ca">
                                    <img src="https://maannews.acnoo.com/flags/ad.svg" alt="" class="flag-icon me-2">
                                    Andorra
                                </a>
                            </li>
                                                    <li>
                                <a class="dropdown-item" href="https://maannews.acnoo.com/admin/dashboard?lang=bt">
                                    <img src="https://maannews.acnoo.com/flags/dz.svg" alt="" class="flag-icon me-2">
                                    Dzongkha
                                </a>
                            </li>
                                                    <li>
                                <a class="dropdown-item" href="https://maannews.acnoo.com/admin/dashboard?lang=drcfr">
                                    <img src="https://maannews.acnoo.com/flags/drc.svg" alt="" class="flag-icon me-2">
                                    Congo (DRC)
                                </a>
                            </li>
                                                    <li>
                                <a class="dropdown-item" href="https://maannews.acnoo.com/admin/dashboard?lang=cgfr">
                                    <img src="https://maannews.acnoo.com/flags/cg.svg" alt="" class="flag-icon me-2">
                                    Congo (Republic)
                                </a>
                            </li>
                                                    <li>
                                <a class="dropdown-item" href="https://maannews.acnoo.com/admin/dashboard?lang=escr">
                                    <img src="https://maannews.acnoo.com/flags/cr.svg" alt="" class="flag-icon me-2">
                                    Costa Rica (Spanish)
                                </a>
                            </li>
                                                    <li>
                                <a class="dropdown-item" href="https://maannews.acnoo.com/admin/dashboard?lang=enbw">
                                    <img src="https://maannews.acnoo.com/flags/bw.svg" alt="" class="flag-icon me-2">
                                    Botswana (English)
                                </a>
                            </li>
                                                    <li>
                                <a class="dropdown-item" href="https://maannews.acnoo.com/admin/dashboard?lang=bws">
                                    <img src="https://maannews.acnoo.com/flags/bws.svg" alt="" class="flag-icon me-2">
                                    Botswana (Setswana)
                                </a>
                            </li>
                                                    <li>
                                <a class="dropdown-item" href="https://maannews.acnoo.com/admin/dashboard?lang=deat">
                                    <img src="https://maannews.acnoo.com/flags/at.svg" alt="" class="flag-icon me-2">
                                    Austria(German)
                                </a>
                            </li>
                                                    <li>
                                <a class="dropdown-item" href="https://maannews.acnoo.com/admin/dashboard?lang=enbs">
                                    <img src="https://maannews.acnoo.com/flags/bs.svg" alt="" class="flag-icon me-2">
                                    Bahamas(English)
                                </a>
                            </li>
                                                    <li>
                                <a class="dropdown-item" href="https://maannews.acnoo.com/admin/dashboard?lang=arbh">
                                    <img src="https://maannews.acnoo.com/flags/bh.svg" alt="" class="flag-icon me-2">
                                    Bahrain(Arabic)
                                </a>
                            </li>
                                                    <li>
                                <a class="dropdown-item" href="https://maannews.acnoo.com/admin/dashboard?lang=pt-ao">
                                    <img src="https://maannews.acnoo.com/flags/ao.svg" alt="" class="flag-icon me-2">
                                    Angola(Portuguese)
                                </a>
                            </li>
                                                    <li>
                                <a class="dropdown-item" href="https://maannews.acnoo.com/admin/dashboard?lang=es-ar">
                                    <img src="https://maannews.acnoo.com/flags/ar.svg" alt="" class="flag-icon me-2">
                                    Argentina(Spanish)
                                </a>
                            </li>
                                                    <li>
                                <a class="dropdown-item" href="https://maannews.acnoo.com/admin/dashboard?lang=hy">
                                    <img src="https://maannews.acnoo.com/flags/am.svg" alt="" class="flag-icon me-2">
                                    Armenian
                                </a>
                            </li>
                                                    <li>
                                <a class="dropdown-item" href="https://maannews.acnoo.com/admin/dashboard?lang=au-en">
                                    <img src="https://maannews.acnoo.com/flags/au.svg" alt="" class="flag-icon me-2">
                                    Australia
                                </a>
                            </li>
                                                    <li>
                                <a class="dropdown-item" href="https://maannews.acnoo.com/admin/dashboard?lang=bb-en">
                                    <img src="https://maannews.acnoo.com/flags/bb.svg" alt="" class="flag-icon me-2">
                                    Barbados(English)
                                </a>
                            </li>
                                                    <li>
                                <a class="dropdown-item" href="https://maannews.acnoo.com/admin/dashboard?lang=be">
                                    <img src="https://maannews.acnoo.com/flags/by.svg" alt="" class="flag-icon me-2">
                                    Belarusian
                                </a>
                            </li>
                                                    <li>
                                <a class="dropdown-item" href="https://maannews.acnoo.com/admin/dashboard?lang=nl-be">
                                    <img src="https://maannews.acnoo.com/flags/be.svg" alt="" class="flag-icon me-2">
                                    Belgium(Dutch)
                                </a>
                            </li>
                                                    <li>
                                <a class="dropdown-item" href="https://maannews.acnoo.com/admin/dashboard?lang=bz-en">
                                    <img src="https://maannews.acnoo.com/flags/bz.svg" alt="" class="flag-icon me-2">
                                    Belize(English)
                                </a>
                            </li>
                                                    <li>
                                <a class="dropdown-item" href="https://maannews.acnoo.com/admin/dashboard?lang=bj-fr">
                                    <img src="https://maannews.acnoo.com/flags/bj.svg" alt="" class="flag-icon me-2">
                                    Benin(French)
                                </a>
                            </li>
                                                    <li>
                                <a class="dropdown-item" href="https://maannews.acnoo.com/admin/dashboard?lang=bo-es">
                                    <img src="https://maannews.acnoo.com/flags/bo.svg" alt="" class="flag-icon me-2">
                                    Bolivia(Spanish)
                                </a>
                            </li>
                                                    <li>
                                <a class="dropdown-item" href="https://maannews.acnoo.com/admin/dashboard?lang=bn-ms">
                                    <img src="https://maannews.acnoo.com/flags/bn.svg" alt="" class="flag-icon me-2">
                                    Brunei(Malay)
                                </a>
                            </li>
                                                    <li>
                                <a class="dropdown-item" href="https://maannews.acnoo.com/admin/dashboard?lang=bg">
                                    <img src="https://maannews.acnoo.com/flags/bg.svg" alt="" class="flag-icon me-2">
                                    Bulgarian
                                </a>
                            </li>
                                                    <li>
                                <a class="dropdown-item" href="https://maannews.acnoo.com/admin/dashboard?lang=bf-fr">
                                    <img src="https://maannews.acnoo.com/flags/bf.svg" alt="" class="flag-icon me-2">
                                    Burkina Faso(French)
                                </a>
                            </li>
                                                    <li>
                                <a class="dropdown-item" href="https://maannews.acnoo.com/admin/dashboard?lang=cm-fr">
                                    <img src="https://maannews.acnoo.com/flags/cm.svg" alt="" class="flag-icon me-2">
                                    Cameroon(French)
                                </a>
                            </li>
                                                    <li>
                                <a class="dropdown-item" href="https://maannews.acnoo.com/admin/dashboard?lang=ca-en">
                                    <img src="https://maannews.acnoo.com/flags/ca.svg" alt="" class="flag-icon me-2">
                                    Canada(English)
                                </a>
                            </li>
                                                    <li>
                                <a class="dropdown-item" href="https://maannews.acnoo.com/admin/dashboard?lang=cl-es">
                                    <img src="https://maannews.acnoo.com/flags/cl.svg" alt="" class="flag-icon me-2">
                                    Chile(Spanish)
                                </a>
                            </li>
                                                    <li>
                                <a class="dropdown-item" href="https://maannews.acnoo.com/admin/dashboard?lang=co-es">
                                    <img src="https://maannews.acnoo.com/flags/co.svg" alt="" class="flag-icon me-2">
                                    Colombia(Spanish)
                                </a>
                            </li>
                                                    <li>
                                <a class="dropdown-item" href="https://maannews.acnoo.com/admin/dashboard?lang=km-ar">
                                    <img src="https://maannews.acnoo.com/flags/km.svg" alt="" class="flag-icon me-2">
                                    Comoros(Arabic)
                                </a>
                            </li>
                                                    <li>
                                <a class="dropdown-item" href="https://maannews.acnoo.com/admin/dashboard?lang=hr">
                                    <img src="https://maannews.acnoo.com/flags/hr.svg" alt="" class="flag-icon me-2">
                                    Croatian
                                </a>
                            </li>
                                                    <li>
                                <a class="dropdown-item" href="https://maannews.acnoo.com/admin/dashboard?lang=cu-es">
                                    <img src="https://maannews.acnoo.com/flags/cu.svg" alt="" class="flag-icon me-2">
                                    Cuba(Spanish)
                                </a>
                            </li>
                                                    <li>
                                <a class="dropdown-item" href="https://maannews.acnoo.com/admin/dashboard?lang=cy-el">
                                    <img src="https://maannews.acnoo.com/flags/cy.svg" alt="" class="flag-icon me-2">
                                    Cyprus(Greek)
                                </a>
                            </li>
                                                    <li>
                                <a class="dropdown-item" href="https://maannews.acnoo.com/admin/dashboard?lang=dj-fr">
                                    <img src="https://maannews.acnoo.com/flags/dj.svg" alt="" class="flag-icon me-2">
                                    Djibouti(French)
                                </a>
                            </li>
                                                    <li>
                                <a class="dropdown-item" href="https://maannews.acnoo.com/admin/dashboard?lang=dm-en">
                                    <img src="https://maannews.acnoo.com/flags/dm.svg" alt="" class="flag-icon me-2">
                                    Dominica(English)
                                </a>
                            </li>
                                                    <li>
                                <a class="dropdown-item" href="https://maannews.acnoo.com/admin/dashboard?lang=tet">
                                    <img src="https://maannews.acnoo.com/flags/tl.svg" alt="" class="flag-icon me-2">
                                    Tetum
                                </a>
                            </li>
                                                    <li>
                                <a class="dropdown-item" href="https://maannews.acnoo.com/admin/dashboard?lang=ec-es">
                                    <img src="https://maannews.acnoo.com/flags/ec.svg" alt="" class="flag-icon me-2">
                                    Ecuador(Spanish)
                                </a>
                            </li>
                                                    <li>
                                <a class="dropdown-item" href="https://maannews.acnoo.com/admin/dashboard?lang=eg-ar">
                                    <img src="https://maannews.acnoo.com/flags/eg.svg" alt="" class="flag-icon me-2">
                                    Egypt(Arabic)
                                </a>
                            </li>
                                                    <li>
                                <a class="dropdown-item" href="https://maannews.acnoo.com/admin/dashboard?lang=sv-es">
                                    <img src="https://maannews.acnoo.com/flags/sv.svg" alt="" class="flag-icon me-2">
                                    El Salvador(Spanish)
                                </a>
                            </li>
                                                    <li>
                                <a class="dropdown-item" href="https://maannews.acnoo.com/admin/dashboard?lang=gq-es">
                                    <img src="https://maannews.acnoo.com/flags/gq.svg" alt="" class="flag-icon me-2">
                                    Equatorial Guinea(Spanish)
                                </a>
                            </li>
                                                    <li>
                                <a class="dropdown-item" href="https://maannews.acnoo.com/admin/dashboard?lang=et">
                                    <img src="https://maannews.acnoo.com/flags/ee.svg" alt="" class="flag-icon me-2">
                                    Estonian
                                </a>
                            </li>
                                                    <li>
                                <a class="dropdown-item" href="https://maannews.acnoo.com/admin/dashboard?lang=ss">
                                    <img src="https://maannews.acnoo.com/flags/sz.svg" alt="" class="flag-icon me-2">
                                    Swati
                                </a>
                            </li>
                                                    <li>
                                <a class="dropdown-item" href="https://maannews.acnoo.com/admin/dashboard?lang=am">
                                    <img src="https://maannews.acnoo.com/flags/et.svg" alt="" class="flag-icon me-2">
                                    Amharic
                                </a>
                            </li>
                                                    <li>
                                <a class="dropdown-item" href="https://maannews.acnoo.com/admin/dashboard?lang=fj-en">
                                    <img src="https://maannews.acnoo.com/flags/fj.svg" alt="" class="flag-icon me-2">
                                    Fiji
                                </a>
                            </li>
                                                    <li>
                                <a class="dropdown-item" href="https://maannews.acnoo.com/admin/dashboard?lang=ga-fr">
                                    <img src="https://maannews.acnoo.com/flags/ga.svg" alt="" class="flag-icon me-2">
                                    Gabon(French)
                                </a>
                            </li>
                                                    <li>
                                <a class="dropdown-item" href="https://maannews.acnoo.com/admin/dashboard?lang=gm-en">
                                    <img src="https://maannews.acnoo.com/flags/gm.svg" alt="" class="flag-icon me-2">
                                    Gambia(English)
                                </a>
                            </li>
                                                    <li>
                                <a class="dropdown-item" href="https://maannews.acnoo.com/admin/dashboard?lang=ka">
                                    <img src="https://maannews.acnoo.com/flags/ge.svg" alt="" class="flag-icon me-2">
                                    Georgian
                                </a>
                            </li>
                                                    <li>
                                <a class="dropdown-item" href="https://maannews.acnoo.com/admin/dashboard?lang=gh-en">
                                    <img src="https://maannews.acnoo.com/flags/gh.svg" alt="" class="flag-icon me-2">
                                    Ghana(English)
                                </a>
                            </li>
                                                    <li>
                                <a class="dropdown-item" href="https://maannews.acnoo.com/admin/dashboard?lang=gd-en">
                                    <img src="https://maannews.acnoo.com/flags/gd.svg" alt="" class="flag-icon me-2">
                                    Grenada(English)
                                </a>
                            </li>
                                                    <li>
                                <a class="dropdown-item" href="https://maannews.acnoo.com/admin/dashboard?lang=gt-en">
                                    <img src="https://maannews.acnoo.com/flags/gt.svg" alt="" class="flag-icon me-2">
                                    Guatemala(English)
                                </a>
                            </li>
                                                    <li>
                                <a class="dropdown-item" href="https://maannews.acnoo.com/admin/dashboard?lang=gn-fr">
                                    <img src="https://maannews.acnoo.com/flags/gn.svg" alt="" class="flag-icon me-2">
                                    Guinea(French)
                                </a>
                            </li>
                                                    <li>
                                <a class="dropdown-item" href="https://maannews.acnoo.com/admin/dashboard?lang=gy-en">
                                    <img src="https://maannews.acnoo.com/flags/gy.svg" alt="" class="flag-icon me-2">
                                    Guyana(English)
                                </a>
                            </li>
                                                    <li>
                                <a class="dropdown-item" href="https://maannews.acnoo.com/admin/dashboard?lang=ht-fr">
                                    <img src="https://maannews.acnoo.com/flags/ht.svg" alt="" class="flag-icon me-2">
                                    Haiti(French)
                                </a>
                            </li>
                                                    <li>
                                <a class="dropdown-item" href="https://maannews.acnoo.com/admin/dashboard?lang=hn-es">
                                    <img src="https://maannews.acnoo.com/flags/hn.svg" alt="" class="flag-icon me-2">
                                    Honduras(Spanish)
                                </a>
                            </li>
                                                    <li>
                                <a class="dropdown-item" href="https://maannews.acnoo.com/admin/dashboard?lang=is">
                                    <img src="https://maannews.acnoo.com/flags/is.svg" alt="" class="flag-icon me-2">
                                    Icelandic
                                </a>
                            </li>
                                                    <li>
                                <a class="dropdown-item" href="https://maannews.acnoo.com/admin/dashboard?lang=ga">
                                    <img src="https://maannews.acnoo.com/flags/ie.svg" alt="" class="flag-icon me-2">
                                    Irish
                                </a>
                            </li>
                                                    <li>
                                <a class="dropdown-item" href="https://maannews.acnoo.com/admin/dashboard?lang=uz">
                                    <img src="https://maannews.acnoo.com/flags/uz.svg" alt="" class="flag-icon me-2">
                                    Uzbek
                                </a>
                            </li>
                                                    <li>
                                <a class="dropdown-item" href="https://maannews.acnoo.com/admin/dashboard?lang=zh-tw-man">
                                    <img src="https://maannews.acnoo.com/flags/tw.svg" alt="" class="flag-icon me-2">
                                    Mandarin
                                </a>
                            </li>
                                                    <li>
                                <a class="dropdown-item" href="https://maannews.acnoo.com/admin/dashboard?lang=tg">
                                    <img src="https://maannews.acnoo.com/flags/tj.svg" alt="" class="flag-icon me-2">
                                    Tajik
                                </a>
                            </li>
                                                    <li>
                                <a class="dropdown-item" href="https://maannews.acnoo.com/admin/dashboard?lang=sm">
                                    <img src="https://maannews.acnoo.com/flags/ws.svg" alt="" class="flag-icon me-2">
                                    Samoan
                                </a>
                            </li>
                                                    <li>
                                <a class="dropdown-item" href="https://maannews.acnoo.com/admin/dashboard?lang=fil">
                                    <img src="https://maannews.acnoo.com/flags/ph.svg" alt="" class="flag-icon me-2">
                                    Filipino
                                </a>
                            </li>
                                            </ul>
                </div>
            </div>  --}}

            <div class="profile-info dropdown">
                <a href="#"  data-bs-toggle="dropdown">
                    <img src="{{ asset(Auth::user()->image ?? 'assets/images/profile/avatar.svg') }}" alt="Profile">
                </a>
                <ul class="dropdown-menu">
                    {{-- <li> <a href="{{ url('reset') }}"> <i class="far fa-undo"></i> {{ __('Restart') }}</a></li> --}}
                    <li> <a href="{{ url('cache-clear') }}"> <i class="far fa-undo"></i> {{ __('Clear cache') }}</a></li>
                    <li> <a href="{{ route('author.profiles.index') }}"> <i class="fal fa-user"></i> {{__('My Profile')}}</a></li>
                    <li> <a href="javascript:void(0)" onclick="document.getElementById('logoutForm').submit();">  <i class="far fa-sign-out"></i> {{__('Logout')}} </a> </li>
                    <form action="{{ route('logout') }}" method="post" id="logoutForm">
                        @csrf
                    </form>
                </ul>
            </div>
        </div>
    </div>
</header>
<script>
   /*  document.addEventListener("DOMContentLoaded", function () {
        const selectedText = document.getElementById("selectedText");
        const selectedFlag = document.getElementById("selectedFlag");

        function updateLanguage(langElement) {
            const flag = langElement.querySelector("img").src;
            const langName = langElement.textContent.trim();

            selectedText.textContent = langName;
            selectedFlag.src = flag;

            localStorage.setItem("selectedLanguage", langName);
            localStorage.setItem("selectedFlag", flag);
        }

        document.querySelectorAll(".language-option").forEach(item => {
            item.addEventListener("click", function (e) {
                e.preventDefault();
                updateLanguage(this);
            });
        });

        // Load saved language on page load
        const savedLang = localStorage.getItem("selectedLanguage");
        const savedFlag = localStorage.getItem("selectedFlag");

        if (savedLang && savedFlag) {
            selectedText.textContent = savedLang;
            selectedFlag.src = savedFlag;
        }
    }); */
</script>

