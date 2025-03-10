<x-admin-app-layout>

    @section('title', __('Edit'). ' ' .$page_title)

    <div class="widget">
        <div class="widget-heading">
            <span class="widget-heading-text">
                <b>{{ __('Edit'). ' ' .$page_title }}</b>
            </span>
        </div>
        <form action="{{ route('admin_panel.second_sections.update',$second_section) }}" method="POST" id="second_sections_form">
            @csrf
            @method('put')
            <div class="row g-3">
                <div class="col-sm-6 col-lg-4">
                    <label><b>{{ __('Name') }}*</b></label>
                    <input type="text" name="name" class="form-control" placeholder="{{$second_section->name}}" value="{{ $second_section->name }}">
                    <span class="text-danger validation-errors" id="name"></span>
                </div>
                <div class="col-sm-6 col-lg-4">
                    <label><b>{{ __('Background Color') }}*</b></label>
                    <select class="form-select" name="background_color_id">
                        <option value="select">{{ __('Select an option') }}</option>
                        @foreach ($background_colors as $background_color)
                            <option value="{{ $background_color->id }}" class="{{ $background_color->class }}" @selected($second_section->background_color_id == $background_color->id)>
                                {{ $background_color->name }}
                            </option>
                        @endforeach
                    </select>
                    <span class="text-danger validation-errors" id="background_color_id"></span>
                </div>
                <div class="col-sm-6 col-lg-4">
                    <label><b>{{ __('Text Color') }}*</b></label>
                    <select class="form-select" name="text_color_id">
                        <option value="select">{{ __('Select an option') }}</option>
                        @foreach ($text_colors as $text_color)
                            <option value="{{ $text_color->id }}" class="{{ $text_color->class }}" @selected($second_section->text_color_id == $text_color->id)>
                                {{ $text_color->name }}
                            </option>
                        @endforeach
                    </select>
                    <span class="text-danger validation-errors" id="text_color_id"></span>
                </div>
                <div class="col-sm-6 col-lg-4">
                    <label><b>{{ __('Edit Content') }}*</b></label>
                    <select class="form-select" name="second_section_blocks_options" id="second_section_blocks_select">
                        <option value="select">{{ __('Select an option') }}</option>
                        <option value="1">{{ __('No') }}</option>
                        <option value="0">{{ __('Yes') }}</option>
                    </select>
                    <span class="text-danger validation-errors" id="second_section_blocks_options"></span>
                </div>
                <div class="col-sm-6 col-lg-4">
                    <label><b>{{ __('Assign to Web') }}*</b></label>
                    <select class="form-select" name="is_selected">
                        <option value="select">{{ __('Select an option') }}</option>
                        <option value="0" @selected($second_section->is_selected == '0')>{{ __('No') }}</option>
                        <option value="1" @selected($second_section->is_selected == '1')>{{ __('Yes') }}</option>
                    </select>
                    <span class="text-danger validation-errors" id="is_selected"></span>
                </div>
                <div class="col-12 d-none" id="second_section_blocks_form">
                    <div class="card">
                        <div class="card-header text-center">
                            <span><b>{{ __('Section Blocks') }}</b></span>
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
                                            <th class="text-center align-middle">{{ __('Text') }}*</th>
                                            <th class="text-center align-middle">{{ __('Image for Registration') }}*</th>
                                            <th class="text-center align-middle">{{ __('Image Preview') }}</th>
                                        </tr>
                                    </thead>
                                    <tbody id="second_section_blocks_tbody">
                                        @foreach ($second_section->secondSectionBlocks as $index => $second_section_block)
                                            <tr id="{{$index}}">
                                                <td class="text-center" style="min-width: 200px">
                                                    <textarea name="second_section_blocks[{{$index}}][text]" class="form-control" rows="3" placeholder="{{$second_section_block->text}}" style="resize: none">{{$second_section_block->text}}</textarea>
                                                    <span class="text-danger validation-errors" id="second_section_blocks.{{$index}}.text"></span>
                                                </td>
                                                <td class="text-center" style="min-width: 300px">
                                                    <input type="file" id="file_input_{{$index}}" name="second_section_blocks[{{$index}}][image]" class="form-control file-inputs" accept="image/x-png,image/jpeg">
                                                    <span class="text-danger validation-errors" id="second_section_blocks.{{$index}}.image"></span>
                                                </td>
                                                <td class="text-center" style="min-width: 150px">
                                                    <div id="file_input_{{$index}}_preview_container">
                                                        @if($second_section_block->image)
                                                            <img id="preloaded_file_input_{{$index}}_preview" src="{{ asset($second_section_block->image) }}" class="rounded preloaded-images" width="150" height="150" alt="preloaded image preview">
                                                        @else
                                                            <img id="preloaded_file_input_{{$index}}_preview" src="{{ asset('storage/large_no_image_available.jpg') }}" class="rounded preloaded-images" width="150" height="150" alt="image not found">
                                                        @endif
                                                    </div>
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
                <a href="{{ route('admin_panel.second_sections.index') }}" id="abort_button" class="btn custom-anchor text-uppercase">{{ __('Cancel') }}</a>
            </div>
        </form>
    </div>

</x-admin-app-layout>