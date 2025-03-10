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
            <a href="{{ route('admin_panel.users.create') }}" class="btn custom-anchor" title="{{ __('Add Record') }}">{{ __('Add') }}</a>
        </div>
        <div class="table-responsive">
            <table class="table table-striped table-bordered align-middle">
                <thead>
                    <tr>
                        <th class="custom-table-header">{{ __('Role') }}</th>
                        <th class="custom-table-header">{{ __('Name') }}</th>
                        <th class="custom-table-header">{{ __('Email') }}</th>
                        <th class="custom-table-header">{{ __('Options') }}</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($users as $user)
                        <tr>
                            <td class="text-center">
                                @if($user->is_admin)
                                    <h6>{{ __('Administrator') }}</h6>
                                @else
                                    <h6>{{ __('Editor') }}</h6>
                                @endif
                            </td>
                            <td class="text-center">
                                <h6>{{ $user->name }}</h6>
                            </td>
                            <td class="text-center">
                                <h6>{{ $user->email }}</h6>
                            </td>
                            <td class="text-center">
                                <a href="{{ route('admin_panel.users.edit',$user) }}" class="btn custom-anchor" title="{{ __('Edit Record') }}">
                                    <i class="fa-solid fa-pen-to-square"></i>
                                </a>
                                @include('layouts.admin_panel.users.destroy_confirmation_modal')
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            {{ $users->links() }}
        </div>
    </div>

</x-admin-app-layout>