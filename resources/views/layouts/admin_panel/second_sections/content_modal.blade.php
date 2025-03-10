<button class="btn custom-button" data-bs-toggle="modal" data-bs-target="#content_modal_{{$loop->index}}" title="{{ __('Show Content') }}">
    <i class="fa-regular fa-eye"></i>
</button>

<div class="modal fade" id="content_modal_{{$loop->index}}" tabindex="-1" aria-labelledby="content_modal_{{$loop->index}}" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content {{ $second_section->backgroundColor->class }}">
            <div class="modal-body p-5">
                <div class="text-center fs-3 fw-bold {{ $second_section->textColor->class }}">
                    <div class="container">
                        <div class="row justify-content-center g-2 g-lg-5">
                            @foreach ($second_section->secondSectionBlocks as $second_section_block)
                                <div class="col-lg-6 d-xl-flex">
                                    @if($second_section_block->image)
                                        <img src="{{ asset($second_section_block->image) }}" class="rounded" alt="second section block image" width="200" height="200">
                                    @else
                                        <img src="{{ asset('storage/large_no_image_available.jpg') }}" class="rounded" alt="image not found" width="200" height="200">
                                    @endif
                                    <div class="ms-2 align-content-center">
                                        <span>{{ $second_section_block->text }}</span>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>