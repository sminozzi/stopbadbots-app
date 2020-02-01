// jQuery(document).ready(function($) {



            if(window.screen)
            {
                $wsize = screen.width;
            }
            else
            {
                $wsize = 0;
            }

            /*
            jQuery.ajax({
                url: ajaxurl,
                data: {
                    'action':'stopbadbots_grava_fingerprint',
                    'fingerprint' : $wsize
                },
                success:function(data) {
                    // This outputs the result of the ajax request
                    //console.log(data);
                },
                error: function(errorThrown){
                    //console.log(errorThrown);
                }
            }); 
            */ 






    eraseCookie('stopbadbots_cookie');
    if (readCookie('stopbadbots_cookie') == null) {
        createCookie('stopbadbots_cookie', '1');
    }
    function createCookie(name, value, days) {
        var expires;
        if (days) {
            var date = new Date();
            date.setTime(date.getTime() + (days * 24 * 60 * 60 * 1000));
            expires = "; expires=" + date.toGMTString();
        } else {
            expires = "";
        }
        document.cookie = escape(name) + "=" + escape(value) + expires + "; path=/";
    }
    function readCookie(name) {
        var nameEQ = escape(name) + "=";
        var ca = document.cookie.split(';');
        for (var i = 0; i < ca.length; i++) {
            var c = ca[i];
            while (c.charAt(0) === ' ') c = c.substring(1, c.length);
            if (c.indexOf(nameEQ) === 0) return unescape(c.substring(nameEQ.length, c.length));
        }
        return null;
    }
    function eraseCookie(name) {
        createCookie(name, "", -1);
    }
// });