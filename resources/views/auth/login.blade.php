@inject('agent', 'Jenssegers\Agent\Agent')

@if ($agent->isMobile())
    @include('auth.mobile.login')
@else
    @include('auth.desktop.login')
@endif
