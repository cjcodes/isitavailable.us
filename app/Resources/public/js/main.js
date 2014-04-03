
function update() {
    $.get(Routing.generate('status'), function (data) {
        var rowSize = Math.floor(12 / data.length);
        $('.entry-container').remove();

        for (var i in data) {
            var r = new Room(data[i], rowSize);
            $('.row').append(r.getHtml());
        }
    });
}

var Room = function (data, rowWidth) {
    this.data = data;
    this.rowWidth = rowWidth;
};

Room.prototype.template = Handlebars.compile($('#room-template').html());

Room.prototype.getHtml = function () {
    var $entry = $(this.template(this.data));

    $entry.addClass(this.getStatus());
    $entry.addClass('col-sm-' + this.rowWidth);

    var st = moment(this.data.nextEvent.startTime*1000);
    var et = moment(this.data.nextEvent.endTime*1000);
    var text = '';
    if (st > moment()) {
        text = 'Starting ';
        var minutes = (et.unix() - moment().unix()) / 60;
        if (minutes > 60) {
            text += 'at ' + st.format('hh:mm a');
        } else {
            text += 'in ' + Math.round(minutes) + 'minutes';
        }
    } else {
        text = 'Ending in ';
        var minutes = (et.unix() - moment().unix()) / 60;
        text += Math.round(minutes) + ' minutes';
    }

    $entry.find('.time').text(text);

    return $entry;
};

Room.prototype.getStatus = function () {
    return this.data.status ? 'available' : 'unavailable';
};

update();
setInterval(update, 5000);