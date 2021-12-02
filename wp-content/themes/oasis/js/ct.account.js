/**
 * CT Account Validation
 *
 * @package WP Pro Real Estate 7
 * @subpackage JavaScript
 */

var ctAccount = (function () {
    var $ = jQuery,
        self = {},
        $e = {};

    var _log = function(e) { console.log(e); }

    self.init = function() {
        $e.loginForm = $('#ct_login_form');
        $e.loginSubmit = $('#ct_login_submit');
        $e.error_wrapper = $('#ct_account_errors');

        $e.loginSubmit.click(function(e){
            e.preventDefault();

            var data = $e.loginSubmit.serialize();

            $("body").css("cursor", "progress");
            $.post(window.object_name.ct_ajax_url, $('#ct_login_form').serialize(), function(response) {
                if(response.length >= 1000) {
                    location.reload();
                } else {
                    $("body").css("cursor", "default");
                    if(!response.success) {
                        var e_txt = '<div class="ct_errors">'
                        for(var i=0;i<response.errors.length;i++) {
                            e_txt += '<span class="error"><strong>Error</strong>: '+response.errors[i]+'</span><br/>';
                        }
                        e_txt += '</div>';
                        $e.error_wrapper.html(e_txt);
                    }
                }
            });
        });

    }

    return self;
}());


jQuery(function() {
    ctAccount.init();
});