jQuery(document).ready(function(a){if(a("#nc-notification-area").length&&"no"==nc_notification_ajax_script.logged_in){var b=a("#nc-notification-area #remove-notification").attr("rel");a.cookie("nc-notification-"+b)?a("#nc-notification-area").detach():a("#nc-notification-area").show()}a("#remove-notification").click(function(){var b=a(this).attr("rel");"no"==nc_notification_ajax_script.logged_in&&a.cookie("nc-notification-"+b,"with-cookie",{expires:1});var c={action:"mark_notification_as_read",nc_notification_read:b};return a.post(nc_notification_ajax_script.ajaxurl,c,function(){a("#nc-notification-area").detach()}),!1})});