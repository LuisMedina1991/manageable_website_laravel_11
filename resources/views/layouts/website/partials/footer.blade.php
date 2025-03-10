<footer class="bg-body-tertiary">
    <div class="container text-center">
        <span class="fs-4 fw-bold">{{ __('Our social networks') }}</span>
        <ul class="list-unstyled list-inline fs-1">
            @forelse ($footer_social_media_links as $footer_social_media_link)
                <li class="list-inline-item">
                    <a target="_blank" class="text-dark" href="{{ $footer_social_media_link->url }}" title="{{ $footer_social_media_link->name }}">
                        <i class="{{ $footer_social_media_link->icon }}"></i>
                    </a>
                </li>
            @empty
                <li class="list-inline-item">
                    <a class="text-dark" href="#" title="{{ __('Section not available') }}">
                        <i class="fa-solid fa-triangle-exclamation"></i>
                    </a>
                </li>
            @endforelse
        </ul>
    </div>
</footer>