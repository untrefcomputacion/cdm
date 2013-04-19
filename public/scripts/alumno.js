$(function(){
    requestPassword();
    $("input#newPassword").live('keyup', requestPassword);
});

function requestPassword() {
    if ($("input#newPassword").val() != '') {
        $("input#currentPassword, input#sndNewPassword").attr("disabled", false);
    } else {
        $("input#currentPassword, input#sndNewPassword").attr("disabled", "disabled");
    }
}
