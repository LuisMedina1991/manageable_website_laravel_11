<div class="p-5 {{ $third_section->backgroundColor->class }}" id="{{ $third_section->identifier }}">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-8 col-xl-7">

                @if (session('success'))
                    <div class="alert alert-success alert-dismissible fade show text-center" role="alert">
                        <strong>{{ session('success') }}</strong>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif

                @if (session('error'))
                    <div class="alert alert-danger alert-dismissible fade show text-center" role="alert">
                        <strong>{{ session('error') }}</strong>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif
                
                <div class="card shadow text-center">
                    <div class="card-header">
                        <span class="fs-1 fw-bold">{{ $third_section->thirdSectionContactForm->title }}</span>
                    </div>
                    <div class="card-body text-uppercase">
                        <form action="{{ route('template.send_mail') }}" method="POST" id="contact_form">
                            @csrf
                            <div class="form-floating mb-3">
                                <input class="form-control" id="name" name="remitent_name" type="text" placeholder="{{ $third_section->thirdSectionContactForm->name_label }}"/>
                                <label for="name">{{ $third_section->thirdSectionContactForm->name_label }}</label>
                                <span class="text-danger validation-errors" id="remitent_name"></span>
                            </div>
                            <div class="form-floating mb-3">
                                <input class="form-control" id="email" name="remitent_email" type="text" placeholder="{{ $third_section->thirdSectionContactForm->email_label }}"/>
                                <label for="email">{{ $third_section->thirdSectionContactForm->email_label }}</label>
                                <span class="text-danger validation-errors" id="remitent_email"></span>
                            </div>
                            <div class="form-floating mb-3">
                                <input class="form-control" id="phone" name="remitent_phone" type="text" placeholder="{{ $third_section->thirdSectionContactForm->phone_label }}"/>
                                <label for="phone">{{ $third_section->thirdSectionContactForm->phone_label }}</label>
                                <span class="text-danger validation-errors" id="remitent_phone"></span>
                            </div>
                            <div class="form-floating mb-3">
                                <textarea class="form-control" id="message" name="remitent_message" style="resize: none; height: 150px" placeholder="{{ $third_section->thirdSectionContactForm->message_label }}"></textarea>
                                <label for="message">{{ $third_section->thirdSectionContactForm->message_label }}</label>
                                <span class="text-danger validation-errors" id="remitent_message"></span>
                            </div>
                            <div class="mb-3">
                                <button type="submit" id="submit_button" class="btn w-100 text-white fs-5 fw-semibold {{ $third_section->backgroundColor->class }}">
                                    {{ __('Send Message') }}
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>