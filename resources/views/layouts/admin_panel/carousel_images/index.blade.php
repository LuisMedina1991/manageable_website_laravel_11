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
            <a href="{{ route('admin_panel.carousel_images.create') }}" class="btn custom-anchor" title="{{ __('Add Record') }}">{{ __('Add') }}</a>
        </div>
        <div class="table-responsive">
            <table class="table table-striped table-bordered align-middle">
                <thead>
                    <tr>
                        <th class="custom-table-header" width="15%">{{ __('Position') }}</th>
                        <th class="custom-table-header" width="25%">{{ __('Name') }}</th>
                        <th class="custom-table-header" width="30%">{{ __('Image View') }}</th>
                        <th class="custom-table-header" width="30%">{{ __('Options') }}</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($carousel_images as $carousel_image)
                    <tr>
                        <td class="text-center">
                            @if($carousel_image->is_selected)
                                <h6>{{ $carousel_image->position }}</h6>
                            @else
                                <h6>{{ __('Not Assigned') }}</h6>
                            @endif
                        </td>
                        <td class="text-center">
                            <h6>{{ $carousel_image->name }}</h6>
                        </td>
                        <td class="text-center">
                            <div class="card shadow">
                                @if($carousel_image->image)
                                    <img src="{{ asset($carousel_image->image) }}" alt="carousel image" class="card-img" style="min-width: 300px" height="150">
                                    <div class="card-img-overlay">
                                        <h6 class="text-white">
                                            {{ $carousel_image->text }}
                                        </h6>
                                    </div>
                                @else
                                    <img src="{{ asset('storage/large_no_image_available.jpg') }}" alt="image not found" class="card-img" style="min-width: 300px" height="150">
                                @endif
                            </div>
                        </td>
                        <td class="text-center">
                            <a href="{{ route('admin_panel.carousel_images.edit',$carousel_image) }}" class="btn custom-anchor" title="{{ __('Edit Record') }}">
                                <i class="fa-solid fa-pen-to-square"></i>
                            </a>
                            @include('layouts.admin_panel.carousel_images.destroy_confirmation_modal')
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            {{ $carousel_images->links() }}
        </div>
    </div>
    
</x-admin-app-layout>