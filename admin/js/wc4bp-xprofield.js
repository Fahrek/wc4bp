jQuery(document).ready(function () {
    var groups = [];
    if (wc4bp_admin_xprofield && wc4bp_admin_xprofield.billing && wc4bp_admin_xprofield.shipping) {
        groups.push(wc4bp_admin_xprofield.billing);
        groups.push(wc4bp_admin_xprofield.shipping);
        var text = 'WC4BP auto-generated';
        if(wc4bp_admin_xprofield.autogenerated_text){
            text = wc4bp_admin_xprofield.autogenerated_text;
        }
        jQuery.each(groups, function (index, value) {
            jQuery("a[href='users.php?page=bp-profile-setup&group_id=" + value + "&mode=add_field']")
                .attr('href', 'admin.php?page=wc4bp-options-page&tab=generic')
                .text('WC4BP Settings');
            jQuery("a[href='users.php?page=bp-profile-setup&mode=edit_group&group_id=" + value + "']").remove();
            jQuery("#tabs-"+value+">p").text(text);
        });
    }
});