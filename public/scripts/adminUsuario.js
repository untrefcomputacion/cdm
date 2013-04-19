$(function(){
    requestPassword();
    $("input#nombre").attr('disabled', 'disabled');
    $("input#newPassword").live('keyup', requestPassword);
    $("input#submit").live('click', submitForm)
});

function requestPassword() {
    if ($("input#newPassword").val() != '') {
        $("input#currentPassword, input#sndNewPassword").attr("disabled", false);
    } else {
        $("input#currentPassword, input#sndNewPassword").attr("disabled", "disabled");
    }
}

function submitForm() {
    $("input#nombre").attr('disabled', false);
    return true;
}
