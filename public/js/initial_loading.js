
$(document).ready(function() {

	var activeMaker = function() {
        curr_page = window.location.href.split( '/' );;
        curr_page = curr_page[4];
        
        $url = $('a[class="'+curr_page+'"]').closest('li');

        
        $url.addClass('active');
        $($url).children('ul').find('li').removeClass('active');
       
        if ($url.hasClass('active')) {

          $url.parent('ul').parent('li').addClass('active');
        }

        $('.control-sidebar-tabs').find('li:eq(1)').removeClass('active');
        $('#control-sidebar-home-tab').removeClass('active');
        
        
    }
    activeMaker();

    var csrf_token = $('meta[name="csrf_token"]').attr('content');

    $.ajaxPrefilter(function(options, originalOptions, jqXHR){
        // if (options.type.toLowerCase() === "post") {
            // initialize `data` to empty string if it does not exist
            options.data = options.data || "";

            // add leading ampersand if `data` is non-empty
            options.data += options.data?"&":"";

            // add _token entry
            options.data += "_token=" + csrf_token;

            options.async = true;
        // }
    });

    

    $(document).on('keyup', '#sidebar_search', function(e) {
        var filter = jQuery(this).val();
        jQuery(".sidebar ul li").each(function () {
            if (jQuery(this).text().search(new RegExp(filter, "i")) < 0) {
                jQuery(this).hide();
            } else {
                jQuery(this).show()
            }
        });
    });

    // if ($('body').hasClass('sidebar-mini')) {
    //     $('body').addClass('sidebar-collapse');
    // }

})