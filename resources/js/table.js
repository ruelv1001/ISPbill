document.addEventListener('DOMContentLoaded', function () {
    var tables = {};

    // $('table.table-content').on('click', 'tbody tr', function() {
    //     var item = $(this).data('trid');
    //     var table = item.split('-');
    //     var tableName = table[0];
    //     var itemID = table[1];

    //     var checkboxItem =  $('#checkbox-'+item);
    //     var isChecked = checkboxItem.is(':checked');
    //     if (!isChecked) {
    //         checkboxItem.prop('checked', true);
    //         addItemTable(tableName,itemID)
    //     } else {
    //         checkboxItem.prop('checked', false);
    //         removeItemTable(tableName,itemID);
    //     }

    //     enbaleTableOption(tableName);

    // });
    $('.table-cancel-option').on('click', function(event) {
        event.stopPropagation();
        var $tableContainer = $(this).closest('.table-container');
        var tableId = $tableContainer.attr('id'); // Get the ID of the table container
        var table = tableId.split('-');
        var tableName = table[0];
        $('table.table-content', $tableContainer).each(function() {
            var $table = $(this);
            var $tbodyCheckboxes = $table.find('tbody tr input[type="checkbox"]'); // Get all checkboxes in the tbody
            $table.find('thead tr th input[type="checkbox"]').prop('checked', false);
            $tbodyCheckboxes.prop('checked', false);
            if (tables[tableName]) {
                tables[tableName] = []; // Reset the array
            }

        });
        enbaleTableOption(tableName);
    });

    $('.checkbox-all-search').on('click',function(event) {
        event.stopPropagation();
        if ($(this).is(':checked')) {
            $(this).parents('thead').siblings('tbody').find('tr input[type="checkbox"]').prop('checked', true);
            $(this).parents('thead').siblings('tbody').find('tr input[type="checkbox"]').each(function(){
                    var item = $(this).attr('id');
                    item = item.split('checkbox-');
                    var table = item[1].split('-');
                    var tableName = table[0];
                    var itemID = table[1];
                    if( $.inArray(itemID, tables[tableName]) == -1 ){
                        addItemTable(tableName,itemID);
                    }
                    enbaleTableOption(tableName);
            })
        } else {
            $(this).parents('thead').siblings('tbody').find('tr input[type="checkbox"]').prop('checked', false);
            $(this).parents('thead').siblings('tbody').find('tr input[type="checkbox"]').each(function(){
                var item = $(this).attr('id');
                item = item.split('checkbox-');
                var table = item[1].split('-');
                var tableName = table[0];
                var itemID = table[1];
                removeItemTable(tableName,itemID);
                enbaleTableOption(tableName);
            })
        }

    });

    $('.clear-checkbox').on('click',function(event) {
        event.stopPropagation();
        const element = $(this).parent().parent().parent().find('.table-content');
        element.find('tr input[type="checkbox"]').prop('checked', false);
        $(this).parent().parent().addClass('hide');
        element.find('tr input[type="checkbox"]').each(function(){
            var item = $(this).attr('id');
            item = item.split('checkbox-');
            var table = item[1].split('-');
            var tableName = table[0];
            var itemID = table[1];
            removeItemTable(tableName,itemID);
            enbaleTableOption(tableName);
        })
        tables = {};
    });

    $('table.table-content').on('click', 'tbody tr input[type="checkbox"]', function(event) {
        event.stopPropagation();
        var item = $(this).attr('id');
        item = item.split('checkbox-');
        var table = item[1].split('-');
        var tableName = table[0];
        var itemID = table[1];

        if($(this).is(':checked')){
            addItemTable(tableName,itemID);
        }else{
            removeItemTable(tableName,itemID);
        }

        enbaleTableOption(tableName);
    });

    function addItemTable(tableName,itemID){
        if(isTableExist(tableName)){
            var tempTable = tables[tableName];
            tempTable.push(itemID);
            tables[tableName] = tempTable;
        }else{
            tables[tableName] = [itemID];
        }
        setIDs(tableName,tables[tableName])

    }

    function removeItemTable(tableName,itemID){
        if(tables[tableName] !== undefined){
            var index = tables[tableName].indexOf(itemID);
            if (index > -1) {
                tables[tableName].splice(index, 1);
            }
            setIDs(tableName,tables[tableName])
        }
    }


    function setIDs(tableName,data){
        if($('#delete-'+tableName+'tbl-ids').find('input[name="ids[]"]').length >= 1){
            $('#delete-'+tableName+'tbl-ids').find('input[name="ids[]"]').remove();
        }

        if (!$.isEmptyObject(data) && Array.isArray(data)) {
            $.each(data, function (index, value) {
                var newInput = $('<input>').attr({
                    type: 'hidden',
                    name: 'ids[]',
                    value: value
                });
                $('#delete-'+tableName+'tbl-ids').append(newInput);
            });
        }
    }



    function isTableExist(table){
        return tables[table] !== undefined
    }

    function enbaleTableOption(tableName){
        var countItem = tables[tableName] !== undefined ? tables[tableName].length : 0;
        if(countItem == 0 ){
            $('#'+tableName+'-table').find('.table-options').addClass('hide');

        }else{
            $('#'+tableName+'-table').find('.table-options').removeClass('hide');
            $('#'+tableName+'-table').find('.table-options .count').text(countItem);
        }
    }

    function validateFilter(event) {
        const selectElements = document.querySelectorAll('select');
        for (const selectElement of selectElements) {
            if (selectElement.value === "" || selectElement.value === "0") {

                event.preventDefault(); // Prevent form submission
                return; // Exit the function
            }
        }
    }

    function capitalizeFirstLetterOfString(string) {
        return string.charAt(0).toUpperCase() + string.slice(1).toLowerCase();
    }

    function getUrlParameter(name) {
        name = name.replace(/[\[]/, '\\[').replace(/[\]]/, '\\]');
        const regex = new RegExp('[\\?&]' + name + '=([^&#]*)');
        const results = regex.exec(location.search);
        return results === null ? null : decodeURIComponent(results[1].replace(/\+/g, ' '));
    }

    $('.select2-filter[name="convention"]').on('change', function () {
        let selectedValue = $(this).val();


        if(selectedValue){
            let nearestForm = $(this).closest('form');
            let nextSelect2Filter = $(this).nextAll('.select2-filter').filter(function () {
                return $.contains(nearestForm[0], this);
            });

            if(nextSelect2Filter.length > 0){
                nextSelect2Filter.each(function () {
                    let field = $(this);
                    let nameAttr = $(this).attr('name');
                    const paramValue = getUrlParameter(nameAttr);

                    if(selectedValue != 0){
                        $.ajax({
                            url: "/convention-filter/",
                            method: 'GET',
                            data: {
                                convention: selectedValue,
                                filter: nameAttr
                            },
                            success: function(result) {

                                if(typeof result === 'object' && result.error !== "Invalid action"){

                                    field.empty();

                                    result[0] = capitalizeFirstLetterOfString(nameAttr);
                                    $.each(result, function(id, name) {
                                        const option = new Option(name, id);
                                        if (id == 0) {
                                            $(option).prop('disabled', true); // Disable the first option
                                        }
                                        field.append(option);
                                    });

                                    if(paramValue){
                                        field.val(paramValue);
                                    }else{
                                        field.val(0);
                                    }
                                    field.trigger('change').select2();
                                    if(Object.keys(result).length > 1 ){
                                        field.prop('disabled', false);
                                    }else{
                                        field.prop('disabled', true);
                                    }
                                }else{
                                    field.prop('disabled', true);
                                }
                            },
                            error: function(err) {
                                console.error("Error fetching data:", err);
                                reject(err); // Reject the promise on error
                            }
                        });
                    }
                });
            }

        }
    });

}, false);

window.addEventListener('load', function() {
const formList = document.querySelectorAll('form.filter-form');

formList.forEach((form, index) => {
    const fields = form.querySelectorAll('.filter-item');
    var hasConvention = false;
    fields.forEach((field) => {
        if(hasConvention === true){
            if ($(field).hasClass('select2-hidden-accessible')) {
                $(field).prop('disabled', true).trigger('change');
            } else {
                field.readOnly = true;
            }
        }
        if(field.name === 'convention'){
            hasConvention = true;
        }

    });
});
});
