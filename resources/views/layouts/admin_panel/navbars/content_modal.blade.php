<button class="btn custom-button" data-bs-toggle="modal" data-bs-target="#content_modal_{{$loop->index}}" title="{{ __('Show Content') }}">
    <i class="fa-regular fa-eye"></i>
</button>

<div class="modal fade" id="content_modal_{{$loop->index}}" tabindex="-1" aria-labelledby="content_modal_{{$loop->index}}" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content {{ $navbar->backgroundColor->class }}">
            <div class="modal-body">
                <nav class="navbar navbar-expand-xl">
                    <div class="container-fluid">
                        <div class="navbar-brand">
                            @if($navbar->navbarBrand->image)
                                <img src="{{ asset($navbar->navbarBrand->image) }}" class="rounded" alt="brand image" width="80" height="80">
                            @else
                                <img src="{{ asset('storage/no_image_available.png') }}" class="rounded" alt="image not found" width="80" height="80">
                            @endif
                            <span class="d-none d-sm-inline fs-1 fw-bold {{ $navbar->textColor->class }}">
                                {{ $navbar->navbarBrand->text }}
                            </span>
                        </div>
                        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#main-menu-content_{{$loop->index}}" aria-controls="main-menu-content_{{$loop->index}}" aria-expanded="false" aria-label="Toggle navigation">
                            <span class="navbar-toggler-icon"></span>
                        </button>
                        <div class="collapse navbar-collapse" id="main-menu-content_{{$loop->index}}">
                            <ul class="navbar-nav ms-auto">
                                @foreach ($navbar->navbarLinks as $navbar_link)
                                    <li class="nav-item text-start">
                                        <span class="nav-link fs-2 fw-semibold {{ $navbar->textColor->class }}" href="#{{$navbar_link->href}}">
                                            {{ $navbar_link->text }}
                                        </span>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </nav>
            </div>
        </div>
    </div>
</div>