var ms_defenderTimestampToMoment = function(col, row){
    var cell = $('td:eq('+col+')', row)
    var checkin = parseInt(cell.text());
    if (checkin > 0){
        var date = new Date(checkin);
        cell.html('<span title="'+date+'">'+moment(date).fromNow()+'</span>');
    } else {
        cell.text("")
    }
}