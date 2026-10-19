<nav class="side-bar">
    <div class="side-bar-logo">
        <a href="javascript:void(0)"><img src="{{ asset( get_option('general')['logo'] ?? 'assets/images/logo/logo.png') }}" alt="Logo"></a>
        <button class="close-btn"><i class="fal fa-times"></i></button>
    </div>
    <div class="side-bar-manu">
        <ul>
            @canany(['dashboard-read'])
                <li class="{{ Request::routeIs('author.dashboard.index') ? 'active' : ''}}">
                    <a href="{{ route('author.dashboard.index') }}" class="active">
                        <span class="sidebar-icon">
                            <svg width="30" height="30" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><rect x="2" y="2" width="9" height="6" rx="2" fill="white"/><rect x="2" y="11" width="9" height="11" rx="2" fill="white"/><rect x="13" y="2" width="9" height="11" rx="2" fill="white"/><rect x="13" y="16" width="9" height="6" rx="2" fill="white"/></svg>
                        </span>
                        {{-- {{ __('Dashboard') }} --}}
                        @lang('dashboard')
                    </a>
                </li>
            @endcanany

            @canany(['business-read'])
                <li class="{{ Request::routeIs('author.business.index', 'author.business.create', 'author.business.edit') ? 'active' : '' }}">
                    <a class="{{ Request::routeIs('author.business.index') ? 'active' : '' }}" href="{{ route('author.business.index') }}"><span class="sidebar-icon"><img src="{{ asset('assets/images/icons/user.svg') }}" alt="user.svg"></span>
                        {{__('Business List')}} </a>
                </li>
            @endcanany

            @canany(['business-categories-read'])
                <li class="{{ Request::routeIs('author.business-categories.index', 'author.business-categories.create', 'author.business-categories.edit') ? 'active' : ''}}">
                    <a href="{{ route('author.business-categories.index') }}" class="active">
                    <span class="sidebar-icon">
                        <svg width="30" height="30" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><rect x="2" y="2" width="9" height="6" rx="2" fill="white"/><rect x="2" y="11" width="9" height="11" rx="2" fill="white"/><rect x="13" y="2" width="9" height="11" rx="2" fill="white"/><rect x="13" y="16" width="9" height="6" rx="2" fill="white"/></svg>
                    </span>
                        {{ __('Business Category') }}
                    </a>
                </li>
            @endcanany

            @canany(['plans-read'])
                <li class="{{ Request::routeIs('author.plans.index', 'author.plans.create', 'author.plans.edit') ? 'active' : ''}}">
                    <a href="{{ route('author.plans.index') }}" class="active">
                <span class="sidebar-icon">
                    <svg width="30" height="30" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><rect x="2" y="2" width="9" height="6" rx="2" fill="white"/><rect x="2" y="11" width="9" height="11" rx="2" fill="white"/><rect x="13" y="2" width="9" height="11" rx="2" fill="white"/><rect x="13" y="16" width="9" height="6" rx="2" fill="white"/></svg>
                </span>
                        {{ __('Subscription Plans') }}
                    </a>
                </li>
            @endcanany

            @canany(['payment-types-read'])
                <li class="dropdown {{ Request::routeIs('author.payment-types.index', 'author.payment-types.index') ? 'active' : '' }}">
                    <a href="#"><span class="sidebar-icon"><img src="{{ asset('assets/images/icons/user.svg') }}" alt="user.svg"></span>
                        {{__('Payment Settings')}} </a>
                    <ul>
                        <li><a class="{{ Request::routeIs('author.payment-types.index') ? 'active' : '' }}" href="{{ route('author.payment-types.index') }}">{{__('Payment Type List')}}</a></li>
                    </ul>
                </li>
            @endcanany

            @canany(['faqs-read', 'tutorials-read'])
                <li class="dropdown {{ Request::routeIs('author.faqs.index', 'author.faqs.create', 'author.faqs.edit', 'author.tutorials.index', 'author.tutorials.create', 'author.tutorials.edit') ? 'active' : '' }}">
                    <a href="#"><span class="sidebar-icon"><img src="{{ asset('assets/images/icons/user.svg') }}" alt="user.svg"></span>
                        {{__('Support & Helpdesk')}} </a>
                    <ul>
                        <li><a class="{{ Request::routeIs('author.faqs.index', 'author.faqs.create', 'author.faqs.edit') ? 'active' : '' }}" href="{{ route('author.faqs.index') }}">{{__('Manage FAQs')}}</a></li>
                        <li><a class="{{ Request::routeIs('author.tutorials.index', 'author.tutorials.create', 'author.tutorials.edit') ? 'active' : '' }}" href="{{ route('author.tutorials.index') }}">{{__('Manage Tutorials')}}</a></li>
                    </ul>
                </li>
            @endcanany

            @canany(['terms-read'])
                <li class="{{ Request::routeIs('author.terms.index') ? 'active' : '' }}">
                    <a class="{{ Request::routeIs('author.terms.index') ? 'active' : '' }}" href="{{ route('author.terms.index') }}"><span class="sidebar-icon"><img src="{{ asset('assets/images/icons/user.svg') }}" alt="user.svg"></span>
                        {{__('Terms & Conditions')}}
                    </a>
                </li>
            @endcanany

            @canany(['about-us-read'])
                <li class="{{ Request::routeIs('author.about.index') ? 'active' : '' }}">
                    <a class="{{ Request::routeIs('author.about.index') ? 'active' : '' }}" href="{{ route('author.about.index') }}"><span class="sidebar-icon"><img src="{{ asset('assets/images/icons/user.svg') }}" alt="user.svg"></span>
                        {{__('About Us')}}
                    </a>
                </li>
            @endcanany

            @canany(['roles-read', 'permissions-read'])
                <li class="dropdown {{ Request::routeIs('author.roles.index', 'author.roles.create', 'author.roles.edit', 'author.permissions.index') ? 'active' : '' }}">
                    <a href="#">
                        <span class="sidebar-icon">
                            <svg width="45" height="45" viewBox="0 0 48 48" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M20 10H6C4.89543 10 4 10.8954 4 12V38C4 39.1046 4.89543 40 6 40H42C43.1046 40 44 39.1046 44 38V35.5" stroke="#333" stroke-width="1" stroke-linecap="round" stroke-linejoin="round"/><path d="M10 23H18" stroke="#333" stroke-width="1" stroke-linecap="round"/><path d="M10 31H34" stroke="#333" stroke-width="1" stroke-linecap="round"/><circle cx="34" cy="16" r="6" fill="none" stroke="#333" stroke-width="1" stroke-linecap="round" stroke-linejoin="round"/><path d="M44.0001 28.4187C42.0469 24.6023 38 22 34 22C30 22 28.0071 23.1329 25.9503 25" stroke="#333" stroke-width="1" stroke-linecap="round" stroke-linejoin="round"/></svg>
                        </span>
                        {{__('Roles & Permissions')}}
                    </a>
                    <ul>
                        @can('roles-read')
                            <li>
                                <a class="{{ Request::routeIs('author.roles.index', 'author.roles.create', 'author.roles.edit') ? 'active' : '' }}" href="{{ route('author.roles.index') }}">
                                    {{__('Roles')}}
                                </a>
                            </li>
                        @endcan

                        @can('permissions-read')
                            <li>
                                <a class="{{ Request::routeIs('author.permissions.index') ? 'active' : '' }}" href="{{ route('author.permissions.index') }}">
                                    {{ __('Permissions') }}
                                </a>
                            </li>
                        @endcan
                    </ul>
                </li>
            @endcanany

            @canany(['messages-read'])
            <li class="dropdown {{ Request::routeIs('author.messages.index', 'author.messages.create', 'author.messages.edit') ? 'active' : '' }}">
                <a href="#">
                    <span class="sidebar-icon">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><!--!Font Awesome Free 6.5.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2024 Fonticons, Inc.--><path d="M512 240c0 114.9-114.6 208-256 208c-37.1 0-72.3-6.4-104.1-17.9c-11.9 8.7-31.3 20.6-54.3 30.6C73.6 471.1 44.7 480 16 480c-6.5 0-12.3-3.9-14.8-9.9c-2.5-6-1.1-12.8 3.4-17.4l0 0 0 0 0 0 0 0 .3-.3c.3-.3 .7-.7 1.3-1.4c1.1-1.2 2.8-3.1 4.9-5.7c4.1-5 9.6-12.4 15.2-21.6c10-16.6 19.5-38.4 21.4-62.9C17.7 326.8 0 285.1 0 240C0 125.1 114.6 32 256 32s256 93.1 256 208z"/></svg>
                    </span>

                    {{__('Messages')}} </a>
                <ul>
                    @can('messages-read')
                    <li><a class="{{ Request::routeIs('author.messages.index') ? 'active' : '' }}" href="{{ route('author.messages.index') }}">{{__('Manage Messages')}}</a></li>
                    @endcan
                </ul>
            </li>
           @endcanany

            @canany(['settings-read', 'notifications-read', 'currencies-read', 'features-read',
            'blogs-read', 'interfaces-read', 'designs-read', 'languages-read', 'testimonials-read',
            'terms-read'])
            <li
                class="dropdown {{ Request::routeIs('author.website-settings.index', 'author.faqs.create', 'author.faqs.destroy', 'author.faqs.edit', 'author.testimonials.index', 'author.testimonials.create', 'author.testimonials.edit', 'author.features.index', 'author.features.create', 'author.features.edit', 'author.blogs.index', 'author.blogs.create', 'author.blogs.edit', 'author.blogs.filter.comment', 'author.newsletters.index', 'author.interfaces.index', 'author.interfaces.create', 'author.interfaces.edit', 'author.designs.index', 'author.designs.create', 'author.designs.edit', 'author.languages.index', 'author.languages.create', 'author.languages.edit', 'author.testimonials.index', 'author.testimonials.create', 'author.testimonials.edit', 'author.terms.index', 'author.privacy-policy.index','author.currencies.index', 'author.currencies.create', 'author.currencies.edit') ? 'active' : '' }}">
                <a href="#">
                    <span class="sidebar-icon">
                        <svg xmlns="http://www.w3.org/2000/svg" height="16" width="20"
                            viewBox="0 0 640 512"><!--!Font Awesome Free 6.5.1 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2023 Fonticons, Inc.-->
                            <path d="M512.1 191l-8.2 14.3c-3 5.3-9.4 7.5-15.1 5.4-11.8-4.4-22.6-10.7-32.1-18.6-4.6-3.8-5.8-10.5-2.8-15.7l8.2-14.3c-6.9-8-12.3-17.3-15.9-27.4h-16.5c-6 0-11.2-4.3-12.2-10.3-2-12-2.1-24.6 0-37.1 1-6 6.2-10.4 12.2-10.4h16.5c3.6-10.1 9-19.4 15.9-27.4l-8.2-14.3c-3-5.2-1.9-11.9 2.8-15.7 9.5-7.9 20.4-14.2 32.1-18.6 5.7-2.1 12.1 .1 15.1 5.4l8.2 14.3c10.5-1.9 21.2-1.9 31.7 0L552 6.3c3-5.3 9.4-7.5 15.1-5.4 11.8 4.4 22.6 10.7 32.1 18.6 4.6 3.8 5.8 10.5 2.8 15.7l-8.2 14.3c6.9 8 12.3 17.3 15.9 27.4h16.5c6 0 11.2 4.3 12.2 10.3 2 12 2.1 24.6 0 37.1-1 6-6.2 10.4-12.2 10.4h-16.5c-3.6 10.1-9 19.4-15.9 27.4l8.2 14.3c3 5.2 1.9 11.9-2.8 15.7-9.5 7.9-20.4 14.2-32.1 18.6-5.7 2.1-12.1-.1-15.1-5.4l-8.2-14.3c-10.4 1.9-21.2 1.9-31.7 0zm-10.5-58.8c38.5 29.6 82.4-14.3 52.8-52.8-38.5-29.7-82.4 14.3-52.8 52.8zM386.3 286.1l33.7 16.8c10.1 5.8 14.5 18.1 10.5 29.1-8.9 24.2-26.4 46.4-42.6 65.8-7.4 8.9-20.2 11.1-30.3 5.3l-29.1-16.8c-16 13.7-34.6 24.6-54.9 31.7v33.6c0 11.6-8.3 21.6-19.7 23.6-24.6 4.2-50.4 4.4-75.9 0-11.5-2-20-11.9-20-23.6V418c-20.3-7.2-38.9-18-54.9-31.7L74 403c-10 5.8-22.9 3.6-30.3-5.3-16.2-19.4-33.3-41.6-42.2-65.7-4-10.9 .4-23.2 10.5-29.1l33.3-16.8c-3.9-20.9-3.9-42.4 0-63.4L12 205.8c-10.1-5.8-14.6-18.1-10.5-29 8.9-24.2 26-46.4 42.2-65.8 7.4-8.9 20.2-11.1 30.3-5.3l29.1 16.8c16-13.7 34.6-24.6 54.9-31.7V57.1c0-11.5 8.2-21.5 19.6-23.5 24.6-4.2 50.5-4.4 76-.1 11.5 2 20 11.9 20 23.6v33.6c20.3 7.2 38.9 18 54.9 31.7l29.1-16.8c10-5.8 22.9-3.6 30.3 5.3 16.2 19.4 33.2 41.6 42.1 65.8 4 10.9 .1 23.2-10 29.1l-33.7 16.8c3.9 21 3.9 42.5 0 63.5zm-117.6 21.1c59.2-77-28.7-164.9-105.7-105.7-59.2 77 28.7 164.9 105.7 105.7zm243.4 182.7l-8.2 14.3c-3 5.3-9.4 7.5-15.1 5.4-11.8-4.4-22.6-10.7-32.1-18.6-4.6-3.8-5.8-10.5-2.8-15.7l8.2-14.3c-6.9-8-12.3-17.3-15.9-27.4h-16.5c-6 0-11.2-4.3-12.2-10.3-2-12-2.1-24.6 0-37.1 1-6 6.2-10.4 12.2-10.4h16.5c3.6-10.1 9-19.4 15.9-27.4l-8.2-14.3c-3-5.2-1.9-11.9 2.8-15.7 9.5-7.9 20.4-14.2 32.1-18.6 5.7-2.1 12.1 .1 15.1 5.4l8.2 14.3c10.5-1.9 21.2-1.9 31.7 0l8.2-14.3c3-5.3 9.4-7.5 15.1-5.4 11.8 4.4 22.6 10.7 32.1 18.6 4.6 3.8 5.8 10.5 2.8 15.7l-8.2 14.3c6.9 8 12.3 17.3 15.9 27.4h16.5c6 0 11.2 4.3 12.2 10.3 2 12 2.1 24.6 0 37.1-1 6-6.2 10.4-12.2 10.4h-16.5c-3.6 10.1-9 19.4-15.9 27.4l8.2 14.3c3 5.2 1.9 11.9-2.8 15.7-9.5 7.9-20.4 14.2-32.1 18.6-5.7 2.1-12.1-.1-15.1-5.4l-8.2-14.3c-10.4 1.9-21.2 1.9-31.7 0zM501.6 431c38.5 29.6 82.4-14.3 52.8-52.8-38.5-29.6-82.4 14.3-52.8 52.8z" />
                        </svg>
                    </span>
                    {{ __('CMS Manage') }}
                </a>
                <ul>
                    @can('settings-read')
                        <li>
                            <a class="{{ Request::routeIs('author.website-settings.index') ? 'active' : '' }}"
                                href="{{ route('author.website-settings.index') }}">{{ __('Manage Pages') }}</a>
                        </li>
                    @endcan

                    <li>
                        <a class="{{ Request::routeIs('author.terms.index') ? 'active' : '' }}" href="{{ route('author.terms.index') }}">{{ __('Terms & Conditions') }}</a>
                    </li>

                    <li>
                        <a class="{{ Request::routeIs('author.privacy-policy.index') ? 'active' : '' }}"
                            href="{{ route('author.privacy-policy.index') }}">{{ __('Privacy & Policy') }}</a>
                    </li>

                    @can('testimonials-read')
                        <li>
                            <a class="{{ Request::routeIs('author.testimonials.index', 'author.testimonials.create', 'author.testimonials.edit') ? 'active' : '' }}"
                                href="{{ route('author.testimonials.index') }}">{{ __('Testimonials') }}</a>
                        </li>
                    @endcan

                    @can('features-read')
                        <li>
                            <a class="{{ Request::routeIs('author.features.index', 'author.features.create', 'author.features.edit') ? 'active' : '' }}"
                                href="{{ route('author.features.index') }}">{{ __('Features') }}</a>
                        </li>
                    @endcan
                    @can('interfaces-read')
                        <li>
                            <a class="{{ Request::routeIs('author.interfaces.index', 'author.interfaces.create', 'author.interfaces.edit') ? 'active' : '' }}"
                                href="{{ route('author.interfaces.index') }}">{{ __('Interface') }}</a>
                        </li>
                    @endcan
                    @can('designs-read')
                        <li>
                            <a class="{{ Request::routeIs('author.designs.index', 'author.designs.create', 'author.designs.edit') ? 'active' : '' }}"
                                href="{{ route('author.designs.index') }}">{{ __('Author Design') }}</a>
                        </li>
                    @endcan

                    @can('blogs-read')
                        <li>
                            <a class="{{ Request::routeIs('author.blogs.index', 'author.blogs.create', 'author.blogs.edit', 'author.blogs.filter.comment') ? 'active' : '' }}"
                                href="{{ route('author.blogs.index') }}">{{ __('Manage Blogs') }}</a>
                        </li>
                    @endcan
                    @can('currencies-read')
                        <li><a class="{{ Request::routeIs('author.currencies.index', 'author.currencies.create', 'author.currencies.edit') ? 'active' : '' }}" href="{{ route('author.currencies.index') }}">{{ __('Currency') }}</a></li>
                    @endcan
                    @can('countries-read')
                        <li><a class="{{ Request::routeIs('author.countries.index', 'author.countries.create', 'author.countries.edit') ? 'active' : '' }}" href="{{ route('author.countries.index') }}">{{ __('Country') }}</a></li>
                    @endcan
                </ul>
            </li>
        @endcanany

            @canany(['languages-read','adnetworks-read', 'api-keys-read', 'text-generates-read', 'image-generates-read', 'policies-read', 'terms-read', 'gateways-read', 'settings-read', 'notifications-read'])
                <li class="dropdown {{ Request::routeIs('author.api-keys.index', 'author.api-keys.create', 'author.api-keys.edit', 'author.adnetworks.index', 'author.text-generates.index', 'author.image-generates.index', 'author.policies.index', 'author.gateways.index', 'author.settings.index', 'author.notifications.index', 'author.system-settings.index', 'author.languages.index') ? 'active' : ''}}">
                    <a href="#">
                    <span class="sidebar-icon">
                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                                xmlns="http://www.w3.org/2000/svg"><path
                                d="M13.2172 0C13.9735 0 14.6582 0.42 15.0363 1.04C15.2203 1.34 15.3429 1.71 15.3122 2.1C15.2918 2.4 15.3838 2.7 15.5473 2.98C16.0685 3.83 17.2233 4.15 18.1226 3.67C19.1344 3.09 20.4118 3.44 20.9943 4.43L21.679 5.61C22.2718 6.6 21.9447 7.87 20.9228 8.44C20.0541 8.95 19.7475 10.08 20.2687 10.94C20.4322 11.21 20.6162 11.44 20.9023 11.58C21.26 11.77 21.536 12.07 21.7301 12.37C22.1083 12.99 22.0776 13.75 21.7097 14.42L20.9943 15.62C20.6162 16.26 19.911 16.66 19.1855 16.66C18.8278 16.66 18.4292 16.56 18.1022 16.36C17.8365 16.19 17.5299 16.13 17.2029 16.13C16.1911 16.13 15.3429 16.96 15.3122 17.95C15.3122 19.1 14.372 20 13.1968 20H11.8069C10.6215 20 9.68125 19.1 9.68125 17.95C9.66081 16.96 8.81259 16.13 7.80085 16.13C7.46361 16.13 7.15702 16.19 6.90153 16.36C6.5745 16.56 6.16572 16.66 5.81825 16.66C5.08245 16.66 4.37729 16.26 3.99917 15.62L3.29402 14.42C2.9159 13.77 2.89546 12.99 3.27358 12.37C3.43709 12.07 3.74368 11.77 4.09115 11.58C4.37729 11.44 4.56125 11.21 4.73498 10.94C5.24596 10.08 4.93937 8.95 4.07071 8.44C3.05897 7.87 2.73194 6.6 3.31446 5.61L3.99917 4.43C4.59191 3.44 5.85913 3.09 6.88109 3.67C7.77019 4.15 8.925 3.83 9.4462 2.98C9.60972 2.7 9.70169 2.4 9.68125 2.1C9.66081 1.71 9.77323 1.34 9.9674 1.04C10.3455 0.42 11.0302 0.02 11.7763 0H13.2172ZM12.5121 7.18C10.9076 7.18 9.60972 8.44 9.60972 10.01C9.60972 11.58 10.9076 12.83 12.5121 12.83C14.1165 12.83 15.3838 11.58 15.3838 10.01C15.3838 8.44 14.1165 7.18 12.5121 7.18Z"
                                fill="white"/></svg>
                    </span>
                        {{ __('Settings') }}
                    </a>
                    <ul>
                        @can('notifications-read')
                            <li>
                                <a class="{{ Request::routeIs('author.notifications.index') ? 'active' : '' }}"
                                    href="{{ route('author.notifications.index') }}">
                                    {{ __('Notifications') }}
                                </a>
                            </li>
                        @endcan

                        @can('settings-read')
                            <li>
                                <a class="{{ Request::routeIs('author.system-settings.index') ? 'active' : '' }}" href="{{ route('author.system-settings.index') }}">{{__('System Settings')}}</a>
                            </li>
                            <li>
                                <a class="{{ Request::routeIs('author.settings.index') ? 'active' : '' }}" href="{{ route('author.settings.index') }}">{{__('General Settings')}}</a>
                            </li>
                            @can('languages-read')
                                <li>
                                    <a class="{{ Request::routeIs('author.languages.index') ? 'active' : '' }}" href="{{ route('author.languages.index') }}">{{__('Language Settings')}}</a>
                                </li>
                            @endcan
                        @endcan
                    </ul>
                </li>
            @endcanany
        </ul>
    </div>
</nav>
