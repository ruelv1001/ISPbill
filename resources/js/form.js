document.addEventListener('DOMContentLoaded', function () {
        $('.select2').select2({
            width: '100%',
            containerCssClass: 'default-select2' // Add your class here
        })
        $('.select2-filter').each(function() {
            const value = $(this).attr('data-value');
            const form = $(this).closest('form');

            $(this).select2({
                width: '150px',
                containerCssClass: 'select2-filter-container' // Add your class here
            });
            $(this).val(value).trigger('change');
        });
        $('.select-option').select2({
            minimumResultsForSearch: -1,
            containerCssClass: 'select-option-container'
        })

        $('.table-filter-clear').on('click', function(event) {
            event.preventDefault();
            const form = $(this).closest('form');
            const formId = form.attr('id');
            const elementsDate = document.getElementsByClassName('date-filter');
            Array.from(elementsDate).forEach(element => {
                element.value = ''; // Clear the value of each date input
            });

            const elements = document.getElementsByClassName('select2-filter');
            Array.from(elements).forEach(element => {
                $(element).val(null).trigger('change')
            });

            $('#' + formId).submit();
        })

        $('#location-registration-form').validate({
            rules: {
                location_name: {
                    required: true,
                },
                opening_time: {
                    required: true,
                },
                closing_time: {
                    required: true,
                },
                break_time: {
                    required: false,
                },
                convention_id: {
                    required: true,
                }
            },
            messages: {
                location_name: {
                    required: "Please enter your location name.",
                },
                opening_time: {
                    required: "Please enter the opening time.",
                },
                closing_time: {
                    required: "Please enter the closing time.",
                },
                break_time: {
                },
                convention_id: {
                    required: "Please select convention.",
                }
            }
        });

        $('#break_time_in, #break_time_out').on('change', function() {
            const break_time_in = $('#break_time_in').val();
            const break_time_out = $('#break_time_out').val();

            if (break_time_in && break_time_out) {
                $('#break_time').val(`${break_time_in} - ${break_time_out}`);
            } else {
                $('#break_time').val(''); // Clear if either time is not set
            }
        });
}, false);
