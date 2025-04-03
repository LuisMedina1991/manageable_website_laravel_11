<button class="btn custom-button" data-bs-toggle="modal" data-bs-target="#content_modal_{{$loop->index}}" title="{{ __('Show Content') }}">
    <i class="fa-regular fa-eye"></i>
</button>

<div class="modal fade" id="content_modal_{{$loop->index}}" tabindex="-1" aria-labelledby="content_modal_{{$loop->index}}" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-body">
                <div class="text-center fs-3 fw-bold {{$first_section->textColor->class}}">
                    <div class="container">
                        <span class="text-uppercase">{{$first_section->title}}</span>
                        @foreach($first_section->firstSectionFrames as $first_section_frame)
                            <div class="row pt-3 g-0">
                                <div class="card border-4 border-dark rounded-5">
                                    <div class="card-header border-bottom border-4 border-dark">{{ $first_section_frame->subtitle }}</div>
                                    <div class="card-body">
                                            <span class="card-text">{{ $first_section_frame->text }}</span>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>