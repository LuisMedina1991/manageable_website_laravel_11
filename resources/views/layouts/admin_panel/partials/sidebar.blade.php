<div class="sidebar" id="admin_panel_sidebar">
    <a href="{{ route('admin_panel.index') }}" class="sidebar-brand">
        <i class="fa-solid fa-layer-group sidebar-brand-icon"></i>
        <span class="sidebar-brand-text">{{ __('Admin Panel') }}</span>
    </a>
    <hr class="sidebar-divider">
    <div class="sidebar-list">
        <div class="sidebar-item">
            <a href="{{ route('admin_panel.headers.index') }}" class="sidebar-link">
                <i class="fa-solid fa-window-maximize sidebar-link-icon"></i>
                <span class="sidebar-link-text">{{ __('Header') }}</span>
            </a>
            <span class="tool-tip">{{ __('Header') }}</span>
        </div>
        <div class="sidebar-item">
            <a href="{{ route('admin_panel.navbars.index') }}" class="sidebar-link">
                <i class="fa-solid fa-folder-tree sidebar-link-icon"></i>
                <span class="sidebar-link-text">{{ __('Navigation Bar') }}</span>
            </a>
            <span class="tool-tip">{{ __('Navigation Bar') }}</span>
        </div>
        <div class="sidebar-item">
            <a href="{{ route('admin_panel.carousel_images.index') }}" class="sidebar-link">
                <i class="fa-solid fa-images sidebar-link-icon"></i>
                <span class="sidebar-link-text">{{ __('Slidable Image') }}</span>
            </a>
            <span class="tool-tip">{{ __('Slidable Image') }}</span>
        </div>
        <div class="sidebar-item">
            <a href="{{ route('admin_panel.first_sections.index') }}" class="sidebar-link">
                <i class="fa-solid fa-chart-bar sidebar-link-icon"></i>
                <span class="sidebar-link-text">{{ __('First Section') }}</span>
            </a>
            <span class="tool-tip">{{ __('First Section') }}</span>
        </div>
        <div class="sidebar-item">
            <a href="{{ route('admin_panel.second_sections.index') }}" class="sidebar-link">
                <i class="fa-solid fa-object-group sidebar-link-icon"></i>
                <span class="sidebar-link-text">{{ __('Second Section') }}</span>
            </a>
            <span class="tool-tip">{{ __('Second Section') }}</span>
        </div>
        <div class="sidebar-item">
            <a href="{{ route('admin_panel.third_sections.index') }}" class="sidebar-link">
                <i class="fa-solid fa-rectangle-list sidebar-link-icon"></i>
                <span class="sidebar-link-text">{{ __('Third Section') }}</span>
            </a>
            <span class="tool-tip">{{ __('Third Section') }}</span>
        </div>
        <div class="sidebar-item">
            <a href="{{ route('admin_panel.footer_social_media_links.index') }}" class="sidebar-link">
                <i class="fa-solid fa-icons sidebar-link-icon"></i>
                <span class="sidebar-link-text">{{ __('Social Networks') }}</span>
            </a>
            <span class="tool-tip">{{ __('Social Networks') }}</span>
        </div>
        @can('users_resources')
            <div class="sidebar-item">
                <a href="{{ route('admin_panel.users.index') }}" class="sidebar-link">
                    <i class="fa-solid fa-user-shield sidebar-link-icon"></i>
                    <span class="sidebar-link-text">{{ __('Users') }}</span>
                </a>
                <span class="tool-tip">{{ __('Users') }}</span>
            </div>
        @endcan
    </div>
</div>