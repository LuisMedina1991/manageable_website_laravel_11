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
            <a href="{{ route('admin_panel.navbars.create') }}" class="btn custom-anchor" title="{{ __('Add Record') }}">{{ __('Add') }}</a>
        </div>
        <div class="table-responsive">
            <table class="table table-striped table-bordered align-middle">
                <thead>
                    <tr>
                        <th class="custom-table-header">{{ __('Assign') }}</th>
                        <th class="custom-table-header">{{ __('Name') }}</th>
                        <th class="custom-table-header">{{ __('Section Content') }}</th>
                        <th class="custom-table-header">{{ __('Options') }}</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($navbars as $navbar)
                        <tr>
                            <td class="text-center">
                                <form action="{{ route('admin_panel.navbars.assign',$navbar) }}" method="POST">
                                    @csrf
                                    @method('put')
                                    <button type="submit" class="btn custom-button {{ $navbar->is_selected ? 'disabled' : ''}}" title="{{ __('Assign to Web') }}">
                                        @if($navbar->is_selected)
                                            {{ __('Assigned') }}
                                        @else
                                            {{ __('Assign') }}
                                        @endif
                                    </button>
                                </form>
                            </td>
                            <td class="text-center">
                                <h6>{{ $navbar->name }}</h6>
                            </td>
                            <td class="text-center">
                                @include('layouts.admin_panel.navbars.content_modal')
                            </td>
                            <td class="text-center">
                                <a href="{{ route('admin_panel.navbars.edit',$navbar) }}" class="btn custom-anchor" title="{{ __('Edit Record') }}">
                                    <i class="fa-solid fa-pen-to-square"></i>
                                </a>
                                @include('layouts.admin_panel.navbars.destroy_confirmation_modal')
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            {{ $navbars->links() }}
        </div>
    </div>
    
</x-admin-app-layout>