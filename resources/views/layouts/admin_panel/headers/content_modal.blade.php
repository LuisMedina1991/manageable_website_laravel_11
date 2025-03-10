<button class="btn custom-button" data-bs-toggle="modal" data-bs-target="#content_modal_{{$loop->index}}" title="{{ __('Show Content') }}">
    <i class="fa-regular fa-eye"></i>
</button>

<div class="modal fade" id="content_modal_{{$loop->index}}" tabindex="-1" aria-labelledby="content_modal_{{$loop->index}}" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content {{$header->backgroundColor->class}}">
            <div class="modal-body">
                <header class="text-center">
                    <a target="_blank" href="https://api.whatsapp.com/send?phone={{$header->link_phone}}" rel="noopener noreferrer"
                        class="nav-link fs-1 fw-bold {{$header->textColor->class}}">
                        <i class="fa-brands fa-whatsapp"></i>
                        <span>{{ $header->link_text }}</span>
                    </a>
                </header>
            </div>
        </div>
    </div>
</div>