<div class="col-lg-4 col-md-6">
    <div class="panel panel-default" id="ms_defender-health_widget">
        <div class="panel-heading" data-container="body" title="">
            <h3 class="panel-title"><i class="fa fa-heart"></i>
                <span data-i18n="ms_defender.report_title"></span>
                <list-link data-url="/show/listing/mdm_status/mdm_status"></list-link>
            </h3>
        </div>
        <div class="panel-body text-center"></div>
    </div><!-- /panel -->
</div><!-- /col -->

<script>
$(document).on('appUpdate', function(e, lang) {

    $.getJSON( appUrl + '/module/ms_defender/get_health_stats', function( data ) {
        
        if(data.error){
            //alert(data.error);
            return;
        }
        
        var panel = $('#ms_defender-health_widget div.panel-body'),
            baseUrl = appUrl + '/show/listing/ms_defender/ms_defender';
        panel.empty();

        // Set statuses
        if(data[0].unhealthy){
            panel.append(' <a href="'+baseUrl+'" class="btn btn-danger"><span class="bigger-150">'+data[0].unhealthy+'</span><br>'+"  "+i18n.t('ms_defender.unhealthy')+"  "+'</a>');
        }
        if(data[0].healthy){
            panel.append(' <a href="'+baseUrl+'" class="btn btn-success"><span class="bigger-150">'+data[0].healthy+'</span><br>'+"  "+i18n.t('ms_defender.healthy')+"  "+'</a>');
        }
    });
});
</script>