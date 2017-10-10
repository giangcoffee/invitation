/**
 * Created by giang on 10/10/17.
 */
$(document).ready(function() {
    $.fn.editable.defaults.ajaxOptions = {type: "PATCH"};
    $('#groom_nm_eng').editable({
        success: function(response, newValue) {
            console.log('new value is ' + newValue);
        }
    });
});
