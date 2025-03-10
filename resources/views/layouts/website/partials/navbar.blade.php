<nav id="{{ $navbar->identifier }}" class="navbar navbar-expand-xl p-3 {{ $navbar->backgroundColor->class }}">
    <div class="container-fluid">
        <a class="navbar-brand" href="{{ route('template.index') }}">
            @if($navbar->navbarBrand->image)
                <img src="{{ asset($navbar->navbarBrand->image) }}" class="rounded" alt="logo" width="80" height="80">
            @else
                <img src="{{ asset('storage/no_image_available.png') }}" class="rounded" alt="logo not found" width="80" height="80">
            @endif
            <span class="d-none d-sm-inline fs-1 fw-bold {{ $navbar->textColor->class }}">
                {{ $navbar->navbarBrand->text }}
            </span>
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#main-menu-content" aria-controls="main-menu-content" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="main-menu-content">
            <ul class="navbar-nav ms-auto">
                @foreach ($navbar->navbarLinks as $navbar_link)
                    <li class="nav-item">
                        <a class="nav-link fs-2 fw-semibold {{ $navbar->textColor->class }}" href="#{{$navbar_link->href}}">
                            {{ $navbar_link->text }}
                        </a>
                    </li>
                @endforeach
            </ul>
        </div>
    </div>
</nav>