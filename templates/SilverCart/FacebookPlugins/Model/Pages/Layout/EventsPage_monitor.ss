<div class="row">
    <section id="content-main" class="col-12">
        <h2 class="sr-only">{$Title}</h2>
        <article>
            <header class="sr-only"><h1>{$Title}</h1></header>
            <div class="row no-gutters">
                <div class="col-6">
                    <div class="fb-events-fade h-100 first active">
                    <% if $Events %>
                        <% loop $Events.limit(3) %>
                            <% include SilverCart/FacebookPlugins/Model/Pages/EventSummary_monitor %>
                        <% end_loop %>
                    <% end_if %>
                    </div>
                    <div class="fb-events-fade h-100" style="display: none;">
                    <% if $Events %>
                        <% loop $Events.limit(3,3) %>
                            <% include SilverCart/FacebookPlugins/Model/Pages/EventSummary_monitor %>
                        <% end_loop %>
                    <% end_if %>
                    </div>
                    <div class="fb-events-fade h-100" style="display: none;">
                    <% if $Events %>
                        <% loop $Events.limit(3,6) %>
                            <% include SilverCart/FacebookPlugins/Model/Pages/EventSummary_monitor %>
                        <% end_loop %>
                    <% end_if %>
                    </div>
                </div>
                <div class="col-6">
                    <% if $UpcomingEvents.limit(8) %>
                    <section class="bg-white border shadow-sm m-1 last-child-no-border d-none d-md-block">
                        <header class="sr-only"><h2 class="p-0 m-0 d-inline-block"><%t SilverCart\FacebookPlugins\Model\Pages\EventsPage.UpcomingEvents 'Upcoming Events' %></h2></header>
                        <% loop $UpcomingEvents.limit(8) %>
                            <% include SilverCart/FacebookPlugins/Model/Pages/EventTimeSummary_monitor %>
                        <% end_loop %>
                    </section>
                    <% end_if %>
                </div>
            </div>
        </article>
    </section>
</div>
<script>
$(document).ready(function() {
    var fadeNextEvent = function() {
        $('.fb-events-fade.active').fadeToggle('slow', function() {
            $(this).removeClass('active');
            if ($(this).next('.fb-events-fade').length > 0) {
                $(this).next('.fb-events-fade').fadeToggle('slow');
                $(this).next('.fb-events-fade').addClass('active');
            } else {
                $('.fb-events-fade.first').fadeToggle('slow');
                $('.fb-events-fade.first').addClass('active');
            }
        });
    };
    setInterval(fadeNextEvent, 15000);
    //$(document).on('click', '.fb-events-fade.active', fadeNextEvent);
});
</script>