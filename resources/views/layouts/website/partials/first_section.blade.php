<div class="text-center p-4 fs-3 fw-bold {{$first_section->textColor->class}}" id="{{$first_section->identifier}}">
    <div class="container">
        <span class="text-uppercase">{{ $first_section->title }}</span>
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