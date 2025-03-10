<div id="carousel-images" class="carousel slide carousel-fade" data-bs-ride="carousel">
    <div class="carousel-indicators">
        @forelse ($carousel_images as $carousel_image)
            <button type="button" data-bs-target="#carousel-images" data-bs-slide-to="{{$loop->index}}" class="{{ $loop->index == 0 ? 'active' : ''}}" aria-current="true"></button>
        @empty
            <button type="button" data-bs-target="#carousel-images" data-bs-slide-to="0" class="active" aria-current="true"></button>
        @endforelse
    </div>
    <div class="carousel-inner bg-dark">
        @forelse ($carousel_images as $carousel_image)
            <div class="carousel-item {{ $loop->index == 0 ? 'active' : ''}}" data-bs-interval="3000">
                <img src="{{ asset($carousel_image->image) }}" alt="carousel image" class="d-block w-100" height="500">
                <div class="carousel-caption">
                    <span class="fs-3 fw-bold">{{ $carousel_image->text }}</span>
                </div>
            </div>
        @empty
            <div class="carousel-item active" data-bs-interval="3000">
                <img src="{{ asset('storage/large_no_image_available.jpg') }}" alt="image not found" class="d-block w-100" height="500">
            </div>
        @endforelse
    </div>
    <button class="carousel-control-prev" type="button" data-bs-target="#carousel-images" data-bs-slide="prev">
        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
        <span class="visually-hidden">{{ __('Previus') }}</span>
    </button>
    <button class="carousel-control-next" type="button" data-bs-target="#carousel-images" data-bs-slide="next">
        <span class="carousel-control-next-icon" aria-hidden="true"></span>
        <span class="visually-hidden">{{ __('Next') }}</span>
    </button>
</div>