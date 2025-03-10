<header class="topbar">
    <button type="button" class="btn" id="sidebar_toggle_button" title="{{ __('Shrink') }}">
        <i class="fa-solid fa-chevron-left" id="sidebar_toggle_button_icon"></i>
    </button>
    <form method="POST" action="{{ route('logout') }}">
        @csrf
        <button type="submit" class="btn" id="topbar_logout_button" title="{{ __('Log out') }}">
            <i class="fa-solid fa-lock" id="topbar_logout_icon"></i>
        </button>
    </form>
</header>