window.onload = beginScript();

function beginScript() {

    function getTranslation(key, replacements = {}) {

        let translation = window._translations[key] || key;

        for (var placeholder in replacements) {

            translation = translation.replace(`:${placeholder}`, replacements[placeholder]);

        }

        return translation;

    }

    const sidebar = document.querySelector('#admin_panel_sidebar');

    const sidebarToggleButton = document.querySelector('#sidebar_toggle_button');

    const sidebarToggleButtonIcon = document.querySelector('#sidebar_toggle_button_icon');

    function changeSidebarToggleButtonIcon() {

        if (sidebar.classList.contains('close')) {

            sidebarToggleButtonIcon.classList.replace('fa-chevron-left','fa-chevron-right');
            sidebarToggleButton.setAttribute('title', getTranslation('Expand'));

        } else {

            sidebarToggleButtonIcon.classList.replace('fa-chevron-right','fa-chevron-left');
            sidebarToggleButton.setAttribute('title', getTranslation('Shrink'));

        }

    }

    if (sidebarToggleButton) {

        sidebarToggleButton.addEventListener('click', function(){

            sidebar.classList.toggle('close')
            changeSidebarToggleButtonIcon()
        })

    }

    function fileSizeValidation(input) {

        let limit = 2048;

        let size = input.files[0].size/1024;

        let validationError = input.nextElementSibling;

        if (size > limit) {

            validationError.textContent =  getTranslation('Maximum size 2mb');

            return false;

        } else {

            return true;
        }
    }

    function fileTypeValidation(input) {

        let acceptedTypes = ['image/png','image/jpg','image/jpeg'];

        if (acceptedTypes.includes(input.files[0].type)) {

            return true;

        } else {

            return false;

        }
    }

    async function handlePostPutSubmission(form,validationErrors) {

        let submitButton = document.querySelector('#submit_button');
        let abortButton = document.querySelector('#abort_button');
        if (submitButton) {
            submitButton.classList.toggle('disabled');
        }
        if (abortButton) {
            abortButton.classList.toggle('disabled');
        }
        let url = form.action;
        let formData = new FormData(form);
        let abortController = new AbortController();
        let fetchOptions = {
            method: form.method,
            headers: {
                'Accept':'application/json'
            },
            body: formData,
            signal: abortController.signal
        };
        let timer = setTimeout(() => {
            abortController.abort();
        },5000);

        try {

            let response = await fetch(url,fetchOptions);
            clearTimeout(timer);

            if ( (!response.ok) && (response.status == 422) ) {

                if (submitButton) {
                    submitButton.classList.toggle('disabled');
                }
        
                if (abortButton) {
                    abortButton.classList.toggle('disabled');
                }

                let result = await response.json();

                validationErrors.forEach (span => {
    
                    let validationErrorId = span.id;
    
                    if (result.errors[validationErrorId]) {
    
                        span.textContent = result.errors[validationErrorId][0];
    
                    }
                    
                });
    
            } else {

                if (abortButton) {

                    window.location.replace(abortButton.href);

                } else {

                    window.location.reload(true);

                }
            }

        } catch (error) {

            if (abortButton) {

                window.location.replace(abortButton.href);
                
            } else {

                window.location.reload(true);
            }
        }
    }

    const headersForm = document.querySelector('#headers_form');

    if (headersForm) {

        headersForm.addEventListener('submit', function(event) {

            event.preventDefault();

            let validationErrors = document.querySelectorAll('.validation-errors');
            
            validationErrors.forEach(span => {
                span.textContent = '';
            });

            handlePostPutSubmission(headersForm,validationErrors);

        });

    }

    const navbarsForm = document.querySelector('#navbars_form');

    if (navbarsForm) {

        let preloadedImagePreview = document.querySelector('#preloaded_image_preview');

        let fileInput = document.querySelector('#file_input');

        navbarsForm.addEventListener('submit', function(event) {

            event.preventDefault();

            let validationErrors = document.querySelectorAll('.validation-errors');
            
            validationErrors.forEach(span => {
                span.textContent = '';
            });

            let fileSizeValidator = true;

            if ( (fileInput.files[0]) && (!fileSizeValidation(fileInput)) ) {

                fileSizeValidator = false;
                return;

            }

            if (fileSizeValidator) {

                handlePostPutSubmission(navbarsForm,validationErrors);

            }

        });

        let navbarBrandSelect = document.querySelector('#navbar_brand_select');

        navbarBrandSelect.addEventListener('change', function(){

            let navbarBrandSelectValue = navbarBrandSelect.value;

            let navbarBrandForm = document.querySelector('#navbar_brand_form');

            let navbarBrandFormContent = document.querySelector('#navbar_brand_form_content');

            if (navbarBrandSelectValue == 0) {

                navbarBrandForm.classList.remove('d-none')

                navbarBrandFormContent.classList.add('show')

                fileInput.addEventListener('change', function() {

                    let validationError = document.getElementById(fileInput.name);

                    validationError.textContent = '';

                    let imagePreviewContainer = document.querySelector('#image_preview_container');

                    if (imagePreviewContainer.hasChildNodes) {

                        imagePreviewContainer.innerHTML = '';
                    }

                    if ( (fileInput.files[0]) && (fileSizeValidation(fileInput)) && (fileTypeValidation(fileInput)) ) {

                        let newImagePreview = document.createElement('img');

                        newImagePreview.src = URL.createObjectURL(fileInput.files[0]);
                        newImagePreview.setAttribute('class','rounded');
                        newImagePreview.setAttribute('width','150');
                        newImagePreview.setAttribute('height','150');
                        newImagePreview.setAttribute('alt','image preview');
                        imagePreviewContainer.prepend(newImagePreview);

                    } else if (preloadedImagePreview) {

                        imagePreviewContainer.prepend(preloadedImagePreview);

                    }
    
                });

            } else {
                
                navbarBrandForm.classList.add('d-none')
                navbarBrandFormContent.classList.remove('show')
    
            }

        });

        let navbarLinksSelect = document.querySelector('#navbar_links_select');

        navbarLinksSelect.addEventListener('change', function(){
    
            let navbarLinksSelectValue = navbarLinksSelect.value;
            let navbarLinksForm = document.querySelector('#navbar_links_form');
            let navbarLinksFormContent = document.querySelector('#navbar_links_form_content');

            if (navbarLinksSelectValue == 0){

                navbarLinksForm.classList.remove('d-none')
                navbarLinksFormContent.classList.add('show')

            } else {

                navbarLinksForm.classList.add('d-none')
                navbarLinksFormContent.classList.remove('show')

            }

        });

    }

    const carouselImagesForm = document.querySelector('#carousel_images_form');

    if (carouselImagesForm) {

        let preloadedImagePreview = document.querySelector('#preloaded_image_preview');
        let fileInput = document.querySelector('#file_input');

        carouselImagesForm.addEventListener('submit', function(event) {

            event.preventDefault();

            let validationErrors = document.querySelectorAll('.validation-errors');

            validationErrors.forEach(span => {
                span.textContent = '';
            });

            let fileSizeValidator = true;

            if ( (fileInput.files[0]) && (!fileSizeValidation(fileInput)) ) {

                fileSizeValidator = false;
                return;

            }

            if (fileSizeValidator) {

                handlePostPutSubmission(carouselImagesForm,validationErrors);

            }

        });

        let assignRecordSelect = document.querySelector('#assign_record_select');

        let assignPositionSelect = document.querySelector('#assign_position_select');

        let assignPositionSelectDefaultValue = assignPositionSelect.value;

        assignRecordSelect.addEventListener('change', function(){

            let assignRecordSelectValue = assignRecordSelect.value;

            let positionsContainer = document.querySelector('#positions_container');

            if (assignRecordSelectValue == 1){

                positionsContainer.classList.remove('d-none')

            } else {

                assignPositionSelect.value = assignPositionSelectDefaultValue;

                positionsContainer.classList.add('d-none')

            }

        });

        fileInput.addEventListener('change', function() {

            let validationError = document.getElementById(fileInput.name);
            validationError.textContent = '';
            let imagePreviewContainer = document.querySelector('#image_preview_container');

            if (imagePreviewContainer.hasChildNodes) {

                imagePreviewContainer.innerHTML = '';

            }

            if ( (fileInput.files[0]) && (fileSizeValidation(fileInput)) && (fileTypeValidation(fileInput)) ) {

                let newImagePreview = document.createElement('img');
                newImagePreview.src = URL.createObjectURL(fileInput.files[0]);
                newImagePreview.setAttribute('class','rounded');
                newImagePreview.setAttribute('width','300');
                newImagePreview.setAttribute('height','150');
                newImagePreview.setAttribute('alt','image preview');
                imagePreviewContainer.prepend(newImagePreview);

            } else if (preloadedImagePreview) {

                imagePreviewContainer.prepend(preloadedImagePreview);

            }

        });

    }


    const firstSectionsForm = document.querySelector('#first_sections_form');

    if (firstSectionsForm) {

        firstSectionsForm.addEventListener('submit', function(event) {

            event.preventDefault();

            let validationErrors = document.querySelectorAll('.validation-errors');
            
            validationErrors.forEach(span => {
                span.textContent = '';
            });

            handlePostPutSubmission(firstSectionsForm,validationErrors);

        });

        let firstSectionFramesSelect = document.querySelector('#first_section_frames_select');

        firstSectionFramesSelect.addEventListener('change', function(){

            let firstSectionFramesSelectValue = firstSectionFramesSelect.value;
            let firstSectionFramesForm = document.querySelector('#first_section_frames_form');

            if (firstSectionFramesSelectValue == 0) {
                
                firstSectionFramesForm.classList.remove('d-none')

            } else {
                
                firstSectionFramesForm.classList.add('d-none')

            }

        });

        let firstSectionFramesTbody = document.querySelector('#first_section_frames_tbody');

        let addRow = document.querySelector('#add_row');

        addRow.addEventListener('click', function(event){

            event.preventDefault();

            let lastRow = firstSectionFramesTbody.lastElementChild;

            let lastRowIndex = lastRow.id;

            if (lastRowIndex < 3) {

                let newRow = document.createElement('tr');

                lastRowIndex ++;

                newRow.setAttribute('id',lastRowIndex);

                newRow.innerHTML = lastRow.innerHTML;

                newRow.children[0].children[0].setAttribute('name',`first_section_frames[${lastRowIndex}][subtitle]`);

                newRow.children[0].children[0].setAttribute('placeholder', getTranslation('Text for subtitle...'));

                newRow.children[0].children[0].removeAttribute('value');

                newRow.children[0].children[1].setAttribute('id',`first_section_frames.${lastRowIndex}.subtitle`);

                newRow.children[0].children[1].textContent = '';

                newRow.children[1].children[0].setAttribute('name',`first_section_frames[${lastRowIndex}][text]`);

                newRow.children[1].children[0].setAttribute('placeholder', getTranslation('Text for content...'));

                newRow.children[1].children[0].textContent = '';

                newRow.children[1].children[1].setAttribute('id',`first_section_frames.${lastRowIndex}.text`);

                newRow.children[1].children[1].textContent = '';

                firstSectionFramesTbody.append(newRow);

            }

        });

        let removeRow = document.querySelector('#remove_row');

        removeRow.addEventListener('click', function(event){

            event.preventDefault();

            let lastRow = firstSectionFramesTbody.lastElementChild;
            let lastRowIndex = lastRow.id;

            if (lastRowIndex > 0) {

                lastRow.remove();

            }

        });

    }

    const secondSectionsForm = document.querySelector('#second_sections_form');

    if (secondSectionsForm) {

        let preloadedImages = document.querySelectorAll('.preloaded-images');

        secondSectionsForm.addEventListener('submit', function(event) {

            event.preventDefault();

            let validationErrors = document.querySelectorAll('.validation-errors');
            
            validationErrors.forEach(span => {
                span.textContent = '';
            });

            let sizeValidator = true;

            let fileInputs = document.querySelectorAll('.file-inputs');

            fileInputs.forEach(fileInput => {

                if ( (fileInput.files[0]) && (!fileSizeValidation(fileInput)) ) {

                    sizeValidator = false;
                    return;

                }

            });

            if (sizeValidator) {

                handlePostPutSubmission(secondSectionsForm,validationErrors);

            }

        });

        let secondSectionBlocksSelect = document.querySelector('#second_section_blocks_select');

        secondSectionBlocksSelect.addEventListener('change', function(){

            let secondSectionBlocksSelectValue = secondSectionBlocksSelect.value;
            let secondSectionBlocksForm = document.querySelector('#second_section_blocks_form');

            if (secondSectionBlocksSelectValue == 0) {
                
                secondSectionBlocksForm.classList.remove('d-none')

            } else {
                
                secondSectionBlocksForm.classList.add('d-none')

            }

        });

        reloadImagePreview();

        function reloadImagePreview() {

            let fileInputs = document.querySelectorAll('.file-inputs');

            fileInputs.forEach(fileInput => {

                fileInput.addEventListener('change', function(){

                    let validationError = fileInput.nextElementSibling;

                    validationError.textContent = '';

                    let imagePreviewContainer = document.querySelector('#' + fileInput.id + '_preview_container');
                    
                    if (imagePreviewContainer.hasChildNodes) {

                        imagePreviewContainer.innerHTML = '';
        
                    }

                    if ( (fileInput.files[0]) && (fileSizeValidation(fileInput)) && (fileTypeValidation(fileInput)) ) {

                        let newImagePreview = document.createElement('img');
                        newImagePreview.src = URL.createObjectURL(fileInput.files[0]);
                        newImagePreview.setAttribute('class','rounded');
                        newImagePreview.setAttribute('width','150');
                        newImagePreview.setAttribute('height','150');
                        newImagePreview.setAttribute('alt','image preview');
                        imagePreviewContainer.prepend(newImagePreview);

                    } else if (preloadedImages.length > 0) {

                        preloadedImages.forEach(preloadedImage => {

                            let targetId = 'preloaded_' + fileInput.id + '_preview';

                            if (preloadedImage.id == targetId) {

                                imagePreviewContainer.prepend(preloadedImage);

                            }
    
                        });
    
                    }
        
                });

            });

        }

        let secondSectionBlocksTbody = document.querySelector('#second_section_blocks_tbody');
        let addRow = document.querySelector('#add_row');

        addRow.addEventListener('click', function(event){

            event.preventDefault();

            let lastRow = secondSectionBlocksTbody.lastElementChild;
            let lastRowIndex = lastRow.id;

            if (lastRowIndex < 3) {

                let newRow = document.createElement('tr');
                lastRowIndex ++;
                newRow.setAttribute('id',lastRowIndex);
                newRow.innerHTML = lastRow.innerHTML;
                newRow.children[0].children[0].setAttribute('name',`second_section_blocks[${lastRowIndex}][text]`);
                newRow.children[0].children[0].setAttribute('placeholder', getTranslation('Text for content...'));
                newRow.children[0].children[0].textContent = '';
                newRow.children[0].children[1].setAttribute('id',`second_section_blocks.${lastRowIndex}.text`);
                newRow.children[0].children[1].textContent = '';
                newRow.children[1].children[0].setAttribute('id',`file_input_${lastRowIndex}`);
                newRow.children[1].children[0].setAttribute('name',`second_section_blocks[${lastRowIndex}][image]`);
                newRow.children[1].children[1].setAttribute('id',`second_section_blocks.${lastRowIndex}.image`);
                newRow.children[1].children[1].textContent = '';
                newRow.children[2].children[0].setAttribute('id',`file_input_${lastRowIndex}_preview_container`);

                if (newRow.children[2].children[0].hasChildNodes) {

                    newRow.children[2].children[0].innerHTML = '';

                }

                secondSectionBlocksTbody.append(newRow);

                reloadImagePreview();

            }

        });

        let removeRow = document.querySelector('#remove_row');

        removeRow.addEventListener('click', function(event){

            event.preventDefault();

            let lastRow = secondSectionBlocksTbody.lastElementChild;
            let lastRowIndex = lastRow.id;

            if (lastRowIndex > 0) {

                lastRow.remove();

                reloadImagePreview();

            }

        });

    }

    const thirdSectionsForm = document.querySelector('#third_sections_form');

    if (thirdSectionsForm) {

        thirdSectionsForm.addEventListener('submit', function(event) {

            event.preventDefault();

            let validationErrors = document.querySelectorAll('.validation-errors');
            
            validationErrors.forEach(span => {
                span.textContent = '';
            });

            handlePostPutSubmission(thirdSectionsForm,validationErrors);

        });

        let thirdSectionContactFormSelect = document.querySelector('#third_section_contact_form_select');

        thirdSectionContactFormSelect.addEventListener('change', function(){

            let thirdSectionContactFormSelectValue = thirdSectionContactFormSelect.value;
            let thirdSectionContactForm = document.querySelector('#third_section_contact_form');
            let thirdSectionContactFormContent = document.querySelector('#third_section_contact_form_content');

            if (thirdSectionContactFormSelectValue == 0) {
                
                thirdSectionContactForm.classList.remove('d-none')
                thirdSectionContactFormContent.classList.add('show')

            } else {
                
                thirdSectionContactForm.classList.add('d-none')
                thirdSectionContactFormContent.classList.remove('show')

            }

        });

    }

    const footerSocialMediaLinksForm = document.querySelector('#footer_social_media_links_form');

    if (footerSocialMediaLinksForm) {

        footerSocialMediaLinksForm.addEventListener('submit', function(event) {

            event.preventDefault();

            let validationErrors = document.querySelectorAll('.validation-errors');

            validationErrors.forEach(span => {
                span.textContent = '';
            });

            handlePostPutSubmission(footerSocialMediaLinksForm,validationErrors);

        });

        let assignRecordSelect = document.querySelector('#assign_record_select');
        let assignPositionSelect = document.querySelector('#assign_position_select');
        let assignPositionSelectDefaultValue = assignPositionSelect.value;

        assignRecordSelect.addEventListener('change', function(){

            let assignRecordSelectValue = assignRecordSelect.value;
            let positionsContainer = document.querySelector('#positions_container');

            if (assignRecordSelectValue == 1){

                positionsContainer.classList.remove('d-none')

            } else {

                assignPositionSelect.value = assignPositionSelectDefaultValue;
                positionsContainer.classList.add('d-none')

            }

        });
        
    }

    const usersForm = document.querySelector('#users_form');

    if (usersForm) {

        usersForm.addEventListener('submit', function(event) {

            event.preventDefault();

            let validationErrors = document.querySelectorAll('.validation-errors');

            validationErrors.forEach(span => {
                span.textContent = '';
            });

            handlePostPutSubmission(usersForm,validationErrors);

        });

        let updatePasswordSelect = document.querySelector('#update_password_select');

        if (updatePasswordSelect) {

            updatePasswordSelect.addEventListener('change', function(){

                let updatePasswordSelectValue = updatePasswordSelect.value;
                let passwordContainer = document.querySelector('#password_container');
                let passwordConfirmationContainer = document.querySelector('#password_confirmation_container');
    
                if (updatePasswordSelectValue == 1){
    
                    passwordContainer.classList.remove('d-none');
                    passwordConfirmationContainer.classList.remove('d-none');
    
                } else {
    
                    passwordContainer.classList.add('d-none');
                    passwordConfirmationContainer.classList.add('d-none');
    
                }
    
            });

        }

    }

    const contactForm = document.querySelector('#contact_form');

    if (contactForm) {

        contactForm.addEventListener('submit', function(event) {

            event.preventDefault();

            let validationErrors = document.querySelectorAll('.validation-errors');

            validationErrors.forEach(span => {
                span.textContent = '';
            });

            handlePostPutSubmission(contactForm,validationErrors);

        });

    }

}