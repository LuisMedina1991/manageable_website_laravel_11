<div class="text-center p-4 fs-3 fw-bold {{$first_section->textColor->class}}" id="{{$first_section->identifier}}">
    <div class="container">
        <span class="text-uppercase">{{ $first_section->title }}</span>
        <div class="row pt-3 g-3">
            @foreach($first_section->firstSectionFrames as $first_section_frame)
                <div class="col-12 border border-3 border-dark">
                    <span class="d-block border-bottom border-3 border-dark">{{ $first_section_frame->subtitle }}</span>
                    <span>{{ $first_section_frame->text }}</span>
                </div>
            @endforeach
        </div>
    </div>
</div>