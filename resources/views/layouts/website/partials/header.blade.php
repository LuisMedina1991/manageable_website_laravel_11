<header id="{{$header->identifier}}" class="text-center p-3 {{$header->backgroundColor->class}}">
    <a target="_blank" href="https://api.whatsapp.com/send?phone={{$header->link_phone}}" class="nav-link fs-1 fw-bold {{$header->textColor->class}}">
        <i class="fa-brands fa-whatsapp"></i>
        <span>{{ $header->link_text }}</span>
    </a>
</header>