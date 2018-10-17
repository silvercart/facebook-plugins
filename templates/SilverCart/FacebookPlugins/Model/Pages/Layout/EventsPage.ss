<div class="row">
<% cached $UpcomingEvents.Max('LastEdited') %>
    <section id="content-main" class="col-12 col-md-8">
        <h2 class="sr-only">{$Title}</h2>
        <% include SilverCart/Model/Pages/BreadCrumbs %>
        <article>
            <header><h1>{$Title}</h1></header>
            {$Content}
        <% if $Events %>
            <% loop $Events %>
                <% include SilverCart/FacebookPlugins/Model/Pages/EventSummary %>
            <% end_loop %>
        <% end_if %>
        <% if $UpcomingEvents.limit(4) %>
        <section class="bg-white border shadow-sm my-4 last-child-no-border" id="upcoming-events">
            <header class="p-3 mb-3 border-bottom"><h2 class="p-0 m-0 d-inline-block"><%t SilverCart\FacebookPlugins\Model\Pages\EventsPage.UpcomingEvents 'Upcoming Events' %></h2><a class="text-muted text-xs ml-2" href="{$Link('upcoming')}"><span class="fa fa-arrow-right"></span> <%t SilverCart\FacebookPlugins\Model\Pages\EventsPage.ShowAll 'Show all' %></a></header>
            <% loop $UpcomingEvents.limit(4) %>
                <% include SilverCart/FacebookPlugins/Model/Pages/EventTimeSummary %>
            <% end_loop %>
            <% if $UpcomingEvents.count > 4 %>
            <div class="mx-4 mb-3 text-center">
                <a class="btn btn-link text-primary fb-load-additional-events" href="{$Link('upcoming')}" data-offset="4" data-length="4" data-type="upcoming"><span class="fa fa-refresh"></span> <%t SilverCart\FacebookPlugins\Model\Pages\EventsPage.LoadAdditionalEvents 'Load additional events' %></a>
            </div>
            <% end_if %>
        </section>
        <% end_if %>
        <% if $PastEvents.limit(4) %>
        <section class="bg-white border shadow-sm my-4 last-child-no-border" id="past-events">
            <header class="p-3 mb-3 border-bottom"><h2 class="p-0 m-0 d-inline-block"><%t SilverCart\FacebookPlugins\Model\Pages\EventsPage.PastEvents 'Past Events' %></h2><a class="text-muted text-xs ml-2" href="{$Link('past')}"><span class="fa fa-arrow-right"></span> <%t SilverCart\FacebookPlugins\Model\Pages\EventsPage.ShowAll 'Show all' %></a></header>
            <% loop $PastEvents.limit(4) %>
                <% include SilverCart/FacebookPlugins/Model/Pages/EventTimeSummary %>
            <% end_loop %>
            <% if $PastEvents.count > 4 %>
            <div class="mx-4 mb-3 text-center">
                <a class="btn btn-link text-primary fb-load-additional-events" href="{$Link('past')}" data-offset="4" data-length="4" data-type="past"><span class="fa fa-refresh"></span> <%t SilverCart\FacebookPlugins\Model\Pages\EventsPage.LoadAdditionalEvents 'Load additional events' %></a>
            </div>
            <% end_if %>
        </section>
        <% end_if %>
        </article>
        <% include SilverCart/Model/Pages/WidgetSetContent %>
    </section>
    <aside class="col-12 col-md-4">
        <% if $UpcomingEvents.limit(3) %>
        <section class="bg-white border shadow-sm mb-4 last-child-no-border d-none d-md-block">
            <header class="p-3 mb-3 border-bottom"><h2 class="p-0 m-0 d-inline-block"><%t SilverCart\FacebookPlugins\Model\Pages\EventsPage.UpcomingEvents 'Upcoming Events' %></h2></header>
            <% loop $UpcomingEvents.limit(3) %>
                <% include SilverCart/FacebookPlugins/Model/Pages/EventTimeSummary %>
            <% end_loop %>
            <% if $UpcomingEvents.count > 3 %>
            <div class="mx-4 mb-3 text-center">
                <a class="btn btn-link text-primary" href="#upcoming-events"><span class="fa fa-arrow-right"></span> <%t SilverCart\FacebookPlugins\Model\Pages\EventsPage.ShowMore 'Show more events' %></a>
            </div>
            <% end_if %>
        </section>
        <% end_if %>
        <% if $PastEvents.limit(2) %>
        <section class="bg-white border shadow-sm my-4 last-child-no-border d-none d-md-block">
            <header class="p-3 mb-3 border-bottom"><h2 class="p-0 m-0 d-inline-block"><%t SilverCart\FacebookPlugins\Model\Pages\EventsPage.PastEvents 'Past Events' %></h2></header>
            <% loop $PastEvents.limit(2) %>
                <% include SilverCart/FacebookPlugins/Model/Pages/EventTimeSummary %>
            <% end_loop %>
            <% if $PastEvents.count > 2 %>
            <div class="mx-4 mb-3 text-center">
                <a class="btn btn-link text-primary" href="#past-events"><span class="fa fa-arrow-right"></span> <%t SilverCart\FacebookPlugins\Model\Pages\EventsPage.ShowMore 'Show more events' %></a>
            </div>
            <% end_if %>
        </section>
        <% end_if %>
    <% uncached %>
        {$InsertWidgetArea('Sidebar')}
    <% end_uncached %>
    </aside>
</div>
<% end_cached %>