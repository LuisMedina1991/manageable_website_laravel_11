<div class="text-center p-5 fs-3 fw-bold {{ $second_section->backgroundColor->class }} {{ $second_section->textColor->class }}" id="{{ $second_section->identifier }}">
    <div class="container">
        <div class="row justify-content-center g-2 g-md-5">
            @foreach ($second_section->secondSectionBlocks as $second_section_block)
                <div class="col-lg-6 d-md-flex">
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