<div class="row">
    <section id="content-main" class="col-12 col-md-9">
        <h2 class="sr-only"><%t SilverCart\FacebookPlugins\Model\Pages\EventsPage.PastEvents 'Past Events' %></h2>
        <% include SilverCart/Model/Pages/BreadCrumbs %>
        <article class="bg-white border shadow-sm">
        <% if $PaginatedPastEvents %>
            <header class="p-3 mb-3 border-bottom">
                <h1 class="p-0 m-0 d-inline-block"><%t SilverCart\FacebookPlugins\Model\Pages\EventsPage.PastEvents 'Past Events' %></h1>
            <% with $PaginatedPastEvents %>
                <% if $TotalPages == 1 %>
                <span class="ml-2"><%t SilverCart\FacebookPlugins\Model\Pages\EventsPage.PageXofYSingular '{items} events on one page' items=$TotalItems %></span>
                <% else %>
                <span class="ml-2"><%t SilverCart\FacebookPlugins\Model\Pages\EventsPage.PageXofYPlural 'Page {current} of {pages} | {items} events on {pages} pages' current=$CurrentPage pages=$TotalPages items=$TotalItems %></span>
                <% end_if %>
            <% end_with %>
            </header>
            <% loop $PaginatedPastEvents %>
                <% include SilverCart/FacebookPlugins/Model/Pages/EventTimeSummary %>
            <% end_loop %>
            <% with $PaginatedPastEvents %>
                <% include SilverCart/FacebookPlugins/Model/Pages/EventTimePagination %>
            <% end_with %>
        <% end_if %>
        </article>
        <% include SilverCart/Model/Pages/WidgetSetContent %>
    </section>
    <aside class="col-12 col-md-3">
        {$SubNavigation}
        {$InsertWidgetArea('Sidebar')}
    </aside>
</div>