<button class="btn custom-button" data-bs-toggle="modal" data-bs-target="#content_modal_{{$loop->index}}" title="{{ __('Show Content') }}">
    <i class="fa-regular fa-eye"></i>
</button>

<div class="modal fade" id="content_modal_{{$loop->index}}" tabindex="-1" aria-labelledby="content_modal_{{$loop->index}}" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content {{ $third_section->backgroundColor->class }}">
            <div class="modal-body p-5">
                <div class="container">
                    <div class="row justify-content-center">
                        <div class="col-lg-8 col-xl-7">
                            <div class="card shadow text-center">
                                <div class="card-header">
                                    <span class="fs-1 fw-bold">{{ $third_section->thirdSectionContactForm->title }}</span>
                                </div>
                                <div class="card-body text-uppercase">
                                    <form>
                                        <div class="form-floating mb-3">
                                            <input readonly class="form-control" id="name" type="text" placeholder="{{ $third_section->thirdSectionContactForm->name_label }}"/>
                                            <label for="name">{{ $third_section->thirdSectionContactForm->name_label }}</label>
                                        </div>
                                        <div class="form-floating mb-3">
                                            <input readonly class="form-control" id="email" type="email" placeholder="{{ $third_section->thirdSectionContactForm->email_label }}"/>
                                            <label for="email">{{ $third_section->thirdSectionContactForm->email_label }}</label>
                                        </div>
                                        <div class="form-floating mb-3">
                                            <input readonly class="form-control" id="phone" type="text" placeholder="{{ $third_section->thirdSectionContactForm->phone_label }}"/>
                                            <label for="phone">{{ $third_section->thirdSectionContactForm->phone_label }}</label>
                                        </div>
                                        <div class="form-floating mb-3">
                                            <textarea readonly class="form-control" id="message" style="resize: none; height: 150px" placeholder="{{ $third_section->thirdSectionContactForm->message_label }}"></textarea>
                                            <label for="message">{{ $third_section->thirdSectionContactForm->message_label }}</label>
                                        </div>
                                        <div class="mb-3">
                                            <button type="button" class="btn w-100 text-white fs-5 fw-semibold {{ $third_section->backgroundColor->class }}">{{ __('Send Message') }}</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>