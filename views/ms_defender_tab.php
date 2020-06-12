<h2 data-i18n="ms_defender.title"></h2>
<div id="ms_defender-tab"></div>

<div id="ms_defender-msg" data-i18n="listing.loading" class="col-lg-12 text-center"></div>

<script>
$(document).on('appReady', function(){
	$.getJSON(appUrl + '/module/ms_defender/get_data/' + serialNumber, function(data){
        // Check if we have data
        if(!data[0].engine_version && data[0].engine_version !== null && data[0].engine_version !== 0){
            $('#ms_defender-msg').text(i18n.t('no_data'));
            $('#ms_defender-header').removeClass('hide');

        } else {

            // Hide
            $('#ms_defender-msg').text('');
            $('#ms_defender-view').removeClass('hide');

            var skipThese = ['id','serial_number'];
            $.each(data, function(i,d){

                // Generate rows from data
                var rows = ''
                for (var prop in d){
                    // Skip skipThese
                    if(skipThese.indexOf(prop) == -1){
                        // Do nothing for empty values to blank them
                        if (d[prop] == '' || d[prop] == null){
                            rows = rows

                        // Format date
                        } else if((prop == "definitions_updated") && d[prop] > 0){
                            var date = new Date(d[prop] * 1000);
                            rows = rows + '<tr><th>'+i18n.t('ms_defender.'+prop)+'</th><td><span title="'+moment(date).fromNow()+'">'+moment(date).format('llll')+'</span></td></tr>';
                            
                        // Format yes/no
                        } else if((prop == "cloud_automatic_sample_submission" || prop == "cloud_diagnostic_enabled" || prop == "cloud_enabled" || prop == "licensed" || prop == "real_time_protection_available" || prop == "real_time_protection_enabled" || prop == "erd_early_preview_enabled" || prop == "healthy") && d[prop] == 0){
                            rows = rows + '<tr><th>'+i18n.t('ms_defender.'+prop)+'</th><td>'+i18n.t('no')+'</td></tr>';
                        } else if((prop == "cloud_automatic_sample_submission" || prop == "cloud_diagnostic_enabled" || prop == "cloud_enabled" || prop == "licensed" || prop == "real_time_protection_available" || prop == "real_time_protection_enabled" || prop == "erd_early_preview_enabled" || prop == "healthy") && d[prop] == 1){
                            rows = rows + '<tr><th>'+i18n.t('ms_defender.'+prop)+'</th><td>'+i18n.t('yes')+'</td></tr>';

                        // Else, build out rows from entries
                        } else {
                            rows = rows + '<tr><th>'+i18n.t('ms_defender.'+prop)+'</th><td>'+d[prop]+'</td></tr>';
                        }
                    }
                }

                $('#ms_defender-tab')
                    .append($('<div style="max-width:600px;">')
                        .append($('<table>')
                            .addClass('table table-striped table-condensed')
                            .append($('<tbody>')
                                .append(rows))))
            })
        }
	});
});
</script>
