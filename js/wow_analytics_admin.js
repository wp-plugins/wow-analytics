jQuery(document).ready(function () {
    jQuery('#wow_clientlookup').click(function () {
        jQuery('#dialog-form').dialog('open');
        return false;
    });

    var email = jQuery("#email"),
        password = jQuery("#password");

    jQuery("#dialog-form").dialog({
        autoOpen: false,
        height: 300,
        width: 350,
        modal: true,
        buttons: {
            "Ask WOW for Client Id": function () {

                try {
                    jQuery.ajax({
                        type: "POST",
                        url: ajaxurl,
                        data: {
                            action: 'wow_client_list',
                            wow_nonce: wow_vars.wow_nonce,
                            email: email.val(),
                            password: password.val()
                        },
                        beforeSend: function () {
                            jQuery("#wow_loading").show();
                            jQuery('#wow_clientlookup').attr('disabled', true);
                            jQuery(".ui-dialog-buttonpane button:contains('Ask WOW for Client Id')").button("disable");
                        }
                    })
                        .done(function (msg) {
                            if (msg.error !== null) {
                                alert(msg.error);
                            }
                            else {
                                jQuery('#clientid_string').val(msg.client);
                            }

                        })
                        .always(function () {
                            jQuery("#wow_loading").hide();
                            jQuery('#wow_clientlookup').attr('disabled', false);
                            jQuery(".ui-dialog-buttonpane button:contains('Ask WOW for Client Id')").button("enable");
                            jQuery('#dialog-form').dialog('close')
                        });
                }
                catch (e) {
                    alert('Unable to lookup the client id');
                }
            },
            Cancel: function () {
                jQuery(this).dialog("close");
            }
        }
    });
});