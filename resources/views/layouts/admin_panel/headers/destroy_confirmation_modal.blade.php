<button class="btn custom-button" data-bs-toggle="modal" data-bs-target="#delete_confirmation_modal_{{$loop->index}}" title="{{ __('Delete Record') }}">
    <i class="fa-solid fa-trash"></i>
</button>
<div class="modal fade" id="delete_confirmation_modal_{{$loop->index}}" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="delete_confirmation_modal_{{$loop->index}}" aria-hidden="true">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <div class="modal-header justify-content-center">
                <span class="modal-title text-uppercase">
                    <b>{{ __('Registration deletion confirmation') }}</b>
                </span>
            </div>
            <form action="{{ route('admin_panel.headers.destroy',$header) }}" method="POST">
                @csrf
                @method('delete')
                <div class="modal-body">
                    <div class="row">
                        <div class="col-6">
                            <button type="submit" class="btn btn-outline-success text-uppercase">{{ __('Delete') }}</button>
                        </div>
                        <div class="col-6">
                            <button type="button" class="btn btn-outline-danger text-uppercase" data-bs-dismiss="modal">{{ __('Cancel') }}</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>