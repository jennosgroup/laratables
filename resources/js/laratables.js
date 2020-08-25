const Swal = require('sweetalert2');

(function () {

    // Work individually on each table incase there is more than one table on the page
    document.querySelectorAll("div[laratables-wrapper='yes']").forEach(function (wrapperElement) {

        var shouldUseAjax = wrapperElement.getAttribute('laratables-use-ajax');
        var parentCheckboxIdentifier = wrapperElement.getAttribute('laratables-parent-checkbox-id');
        var bodyCheckboxIdentifier = wrapperElement.getAttribute('laratables-body-checkbox-id');
        var bulkOptionsElement = wrapperElement.querySelector("select[laratables-id='bulk-options-select']");
        var perPageElement = wrapperElement.querySelector("select[laratables-id='per-page-select']");
        var activeSectionElement = wrapperElement.querySelector("div[laratables-section='active']");
        var trashSectionElement = wrapperElement.querySelector("div[laratables-section='trash']");
        var searchElement = wrapperElement.querySelector("input[laratables-id='search-input']");

        /**
         * Submit the bulk request.
         *
         * @param  object  event
         */
        bulkOptionsElement.onchange = function (event) {

            var element = event.target;
            var form = element.form;
            var checkedValues = [];
            var method = "post";

            // A bulk action must be selected
            if (element.value == '') {
                return Swal.fire({
                    title: 'Error',
                    icon: 'error',
                    text: 'Oops, you did not select a bulk action!',
                });
            }

            // Get all the checked items and add them to the form for submitting
            wrapperElement.querySelectorAll(bodyCheckboxIdentifier).forEach(function (checkbox) {

                if (checkbox.checked != true) {
                    return;
                }

                // Store the checked value
                checkedValues.push(checkbox.value);

                // Create form input
                var inputElement = document.createElement('input');
                inputElement.setAttribute('type', 'hidden');
                inputElement.setAttribute('name', 'values[]');
                inputElement.setAttribute('value', checkbox.value);

                // Add to existing form
                form.appendChild(inputElement);
            });

            // If there are no checked items, we reset the bulk option and also
            // let the user know that nothing was selected.
            if (checkedValues.length < 1) {

                element.value = '';

                return Swal.fire({
                    title: 'Error',
                    icon: 'error',
                    text: 'Oops, there is no checked value to submit!',
                });
            }

            // Get the selected option element
            var option = element.options[element.selectedIndex];
            var requestType = option.getAttribute('request_type').toLowerCase();
            var route = option.getAttribute('route');

            if (requestType == 'get') {
                method = 'get';
            }

            // If request type is not post or patch, we don't need the token field
            if (requestType != 'post' && requestType != 'patch') {
                form.querySelector("input[laratables-id='bulk-options-csrf-token']").removeAttribute('name');
            }

            // Add the token if request method is post or patch
            if (requestType == 'post' || requestType == 'patch') {
                form.querySelector("input[laratables-id='bulk-options-csrf-token']").setAttribute('name', '_token');
            }

            // If request type is get or post, we don't need the method spoofing
            if (requestType == 'get' || requestType == 'post') {
                form.querySelector("input[laratables-id='bulk-options-method']").removeAttribute('name');
            }

            // If request type is not get and post, add method spoofing
            if (requestType != 'get' && requestType != 'post') {
                var methodElement = form.querySelector("input[laratables-id='bulk-options-method']");
                methodElement.setAttribute('name', '_method');
                methodElement.setAttribute('value', requestType);
            }

            // Finally we submit the form
            form.submit();
        }

        /**
         * Submit the per page request.
         *
         * @param  object  event
         */
        perPageElement.onchange = function (event) {

            var element = event.target;

            if (element.value == '') {
                return Swal.fire({
                    title: 'Error',
                    icon: 'error',
                    text: 'Oops, looks like you did not specify the amount of entries you want to be displayed!',
                });
            }

            element.form.submit();
        }

        /**
         * Program the head and foot checkbox to automatically select/de-select all body checkboxes.
         */
        wrapperElement.querySelectorAll(parentCheckboxIdentifier).forEach(function (parentCheckbox) {
            parentCheckbox.addEventListener('click', function (event) {

                // Now we cycle through the body checkboxes and make them the same state as the parent
                wrapperElement.querySelectorAll(bodyCheckboxIdentifier).forEach(function (checkbox) {
                    checkbox.checked = parentCheckbox.checked;
                });

                // We do the same for the other parent checkbox
                wrapperElement.querySelectorAll(parentCheckboxIdentifier).forEach(function (mainCheckbox) {
                    mainCheckbox.checked = parentCheckbox.checked;
                });
            });
        });

        /**
         * Handle search submit.
         *
         * @param  object  event
         */
        searchElement.form.onsubmit = function (event) {

            var element = event.target.querySelector("input[laratables-id='search-input']");

            if (element.value.length > 2) {
                return;
            }

            event.preventDefault();

            return Swal.fire({
                title: 'Error',
                icon: 'error',
                text: 'Oops, your search query must contain more than 2 characters!',
            });
        }
    });
})();
