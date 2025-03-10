<x-admin-app-layout>

    @section('title', __('Edit'). ' ' .$page_title)

    <div class="widget">
        <div class="widget-heading">
            <span class="widget-heading-text">
                <b>{{  __('Edit'). ' ' .$page_title }}</b>
            </span>
        </div>
        <form action="{{ route('admin_panel.first_sections.update',$first_section) }}" method="POST" id="first_sections_form">
            @csrf
            @method('put')
            <div class="row g-3">
                <div class="col-sm-6 col-lg-4">
                    <label><b>{{ __('Name') }}*</b></label>
                    <input type="text" name="name" class="form-control" placeholder="{{$first_section->name}}" value="{{ $first_section->name }}">
                    <span class="text-danger validation-errors" id="name"></span>
                </div>
                <div class="col-sm-6 col-lg-4">
                    <label><b>{{ __('Title') }}*</b></label>
                    <input type="text" name="title" class="form-control" placeholder="{{$first_section->title}}" value="{{ $first_section->title }}">
                    <span class="text-danger validation-errors" id="title"></span>
                </div>
                <div class="col-sm-6 col-lg-4">
                    <label><b>{{ __('Text Color') }}*</b></label>
                    <select class="form-select" name="text_color_id">
                        <option value="select">{{ __('Select an option') }}</option>
                        @foreach ($text_colors as $text_color)
                            <option value="{{ $text_color->id }}" class="{{ $text_color->class }}" @selected($first_section->text_color_id == $text_color->id)>
                                {{ $text_color->name }}
                            </option>
                        @endforeach
                    </select>
                    <span class="text-danger validation-errors" id="text_color_id"></span>
                </div>
                <div class="col-sm-6 col-lg-4">
                    <label><b>{{ __('Edit Content') }}*</b></label>
                    <select class="form-select" name="first_section_frames_options" id="first_section_frames_select">
                        <option value="select">{{ __('Select an option') }}</option>
                        <option value="1">{{ __('No') }}</option>
                        <option value="0">{{ __('Yes') }}</option>
                    </select>
                    <span class="text-danger validation-errors" id="first_section_frames_options"></span>
                </div>
                <div class="col-sm-6 col-lg-4">
                    <label><b>{{ __('Assign to Web') }}*</b></label>
                    <select class="form-select" name="is_selected">
                        <option value="select">{{ __('Select an option') }}</option>
                        <option value="0" @selected($first_section->is_selected == '0')>{{ __('No') }}</option>
                        <option value="1" @selected($first_section->is_selected == '1')>{{ __('Yes') }}</option>
                    </select>
                    <span class="text-danger validation-errors" id="is_selected"></span>
                </div>
                <div class="col-12 d-none" id="first_section_frames_form">
                    <div class="card">
                        <div class="card-header text-center">
                            <span><b>{{ __('Section Frames') }}</b></span>
                            <div class="d-md-inline d-sm-block">
                                <button class="btn custom-button" title="{{ __('Add Row') }}" id="add_row"><i class="fa-solid fa-square-plus"></i></button>
                                <button class="btn custom-button" title="{{ __('Remove Row') }}" id="remove_row"><i class="fa-solid fa-square-minus"></i></button>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-striped table-bordered align-middle">
                                    <thead>
                                        <tr>
                                            <th class="text-center align-middle">{{ __('Subtitle') }}*</th>
                                            <th class="text-center align-middle" width="60%">{{ __('Content') }}*</th>
                                        </tr>
                                    </thead>
                                    <tbody id="first_section_frames_tbody">
                                        @foreach ($first_section->firstSectionFrames as $index => $first_section_frame)
                                            <tr id="{{$index}}">
                                                <td class="text-center" style="min-width: 200px">
                                                    <input type="text" name="first_section_frames[{{$index}}][subtitle]" class="form-control" placeholder="{{$first_section_frame->subtitle}}" value="{{ $first_section_frame->subtitle }}">
                                                    <span class="text-danger validation-errors" id="first_section_frames.{{$index}}.subtitle"></span>
                                                </td>
                                                <td class="text-center" style="min-width: 300px">
                                                    <textarea name="first_section_frames[{{$index}}][text]" class="form-control" rows="3" style="resize: none" placeholder="{{$first_section_frame->text}}">{{ $first_section_frame->text }}</textarea>
                                                    <span class="text-danger validation-errors" id="first_section_frames.{{$index}}.text"></span>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="mt-4 d-grid gap-2 d-sm-flex justify-content-sm-center">
                <button type="submit" id="submit_button" class="btn custom-button text-uppercase">{{ __('Update') }}</button>
                <a href="{{ route('admin_panel.first_sections.index') }}" id="abort_button" class="btn custom-anchor text-uppercase">{{ __('Cancel') }}</a>
            </div>
        </form>
    </div>

</x-admin-app-layout>