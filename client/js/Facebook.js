var silvercart                 = silvercart                 ? silvercart                 : [];
    silvercart.facebook        = silvercart.facebook        ? silvercart.facebook        : [];
    silvercart.facebook.events = silvercart.facebook.events ? silvercart.facebook.events : [];
    
silvercart.facebook.events.TYPE_ALL      = 'all';
silvercart.facebook.events.TYPE_UPCOMING = 'upcoming';
silvercart.facebook.events.TYPE_PAST     = 'past';
silvercart.facebook.events.loadAdditionalEvents = function(link) {
    if ($('span.fa', link).hasClass('rotation')) {
        return;
    }
    $('span.fa', link).addClass('rotation');
    var offset    = link.attr('data-offset'),
        length    = link.data('length'),
        type      = link.data('type'),
        targetURL = document.location.origin + "/fb/events/load/" + type + "/" + offset + "/" + length,
        html      = '';
    $.ajax({
        url: targetURL
    }).done(function (data) {
        if (data === "") {
            link.remove();
        } else {
            link.closest('div').before(data);
            link.attr('data-offset', parseInt(offset) + parseInt(length));
            $('span.fa', link).removeClass('rotation');
        }
    });
};

$(document).ready(function() {
    $(document).on('click', '.fb-load-additional-events', function(e) {
        e.preventDefault();
        silvercart.facebook.events.loadAdditionalEvents($(this));
    });
});