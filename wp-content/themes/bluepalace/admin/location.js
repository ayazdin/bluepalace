jQuery( window ).load(function() {
    var onloadcity =  jQuery('#_ct_city').val();
    var onloadcommunity =  jQuery('#_ct_community').val();
    var onloadsubcommunity = jQuery('#_ct_sub_community').val();
    var onloadaction  = 'getbuilding';

    jQuery.ajax({
        type : 'POST',
        url : ajaxurl,
        data : {
            "action":onloadaction,
            "city":onloadcity,
            "community":onloadcommunity,
            "sub_community":onloadsubcommunity,

        },
        success: function(data)
        {
            jQuery('#_ct_building').empty().val(data);
        }
    });
});

jQuery(document).ready(function($){
    $('#_ct_city option[value="0"]').remove();
    $('#_ct_community option[value="0"]').remove();
    $('#_ct_sub_community option[value="0"]').remove();

    //get value of city on change
    $('#_ct_city').on('change',function(){
        var city = $(this).val();
        var action = 'getcommunity';

        $.ajax({
           type: 'POST',
            url : ajaxurl,
            data : {
                "action":action,
                "city":city,

            },
            success: function(data){
                //console.log(data);
                $('#_ct_community').empty().append(data);
                $('#_ct_sub_community').empty().append('<option>--Select Sub Community--</option>');
            }
        });
    });

    $('#_ct_community').on('change',function(){
        var city = $('#_ct_city').val();
        var community = $(this).val();
        var action = 'getsubcommunity';
        $.ajax({
           type : 'POST',
            url : ajaxurl,
            data:{
                "action": action,
                "city": city,
                "community": community,

            },
            success: function(comm){
                console.log(comm);
                res = JSON.parse(comm);
                var subcommuniites = res.sub_communities;
                var building = res.building;
                $('#_ct_sub_community').empty().append(subcommuniites);
                $('#_ct_building').empty().val(building);
            }
        });
    });

    $('#_ct_sub_community').on('change',function(){
        var city = $('#_ct_city').val();
        var community = $('#_ct_community').val();
        var subcommunity = $(this).val();
        var action = 'getbuilding';
        $.ajax({
            type : 'POST',
            url : ajaxurl,
            data:{
                "action": action,
                "city": city,
                "community": community,
                "sub_community":subcommunity,

            },
            success: function(comm){
                //alert(comm);
                $('#_ct_building').empty().val(comm);
            }
        });
    });


});