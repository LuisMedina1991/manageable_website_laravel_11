<x-admin-app-layout>

    @section('title', $page_title)
    
    @if (session('info'))
        <div class="alert alert-dark alert-dismissible fade show mx-3" role="alert">
            <strong>{{ session('info') }}</strong>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif
    
    @if (session('error'))
        <div class="alert alert-danger alert-dismissible fade show mx-3" role="alert">
            <strong>{{ session('error') }}</strong>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="widget">
        <div class="widget-heading">
            <span class="widget-heading-text">
                <b>{{ $page_title }}</b>
            </span>
        </div>
        <div class="table-responsive">
            <table class="table table-striped table-bordered align-middle">
                <thead>
                    <tr>
                        <th class="custom-table-header">{{ __('Position') }}</th>
                        <th class="custom-table-header">{{ __('Name') }}</th>
                        <th class="custom-table-header">url</th>
                        <th class="custom-table-header">{{ __('Options') }}</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($footer_social_media_links as $footer_social_media_link)
                    <tr>
                        <td class="text-center">
                            @if($footer_social_media_link->is_selected)
                                <h6>{{ $footer_social_media_link->position }}</h6>
                            @else
                                <h6>{{ __('Not Assigned') }}</h6>
                            @endif
                        </td>
                        <td class="text-center">
                            <h6>{{ $footer_social_media_link->name }}</h6>
                        </td>
                        <td class="text-center">
                            <a href="{{ $footer_social_media_link->url }}" class="nav-link" target="_blank" rel="noopener noreferrer">
                                {{ $footer_social_media_link->url }}
                            </a>
                        </td>
                        <td class="text-center">
                            <a href="{{ route('admin_panel.footer_social_media_links.edit', $footer_social_media_link) }}" class="btn custom-anchor" title="{{ __('Edit Record') }}">
                                <i class="fa-solid fa-pen-to-square"></i>
                            </a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            {{ $footer_social_media_links->links() }}
        </div>
    </div>
    
</x-admin-app-layout>