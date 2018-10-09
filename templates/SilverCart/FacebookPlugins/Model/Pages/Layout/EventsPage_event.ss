<div class="row">
    <section id="content-main" class="col-12 col-md-9">
        <h2 class="sr-only">{$Event.Name}</h2>
        <% include SilverCart/Model/Pages/BreadCrumbs %>
        <% if $Event %>
            <% with $Event %>
        <article class="bg-white border shadow-sm my-4">
            <header class="p-3 border-bottom">
                <h1 class="p-0 m-0 d-inline-block">{$Name}</h1>
                <span class="text-danger ml-2"><%t SilverCart.Until 'until' %> {$EndTime.Format('dd')}. {$EndTime.ShortMonth}</span>
            </header>
            <div class="py-3 px-4 clearfix">
            <% if $Cover %>
                <div class="float-left mr-2 mr-lg-3 mb-2 mb-lg-3 mr-xl-4 w-100 w-sm-30 w-xl-50 w-xxl-30"><img src="{$Cover.ScaleMaxWidth(500).URL}" class="img-fluid" /></div>
            <% end_if %>
                <span class="text-muted text-md d-block mb-3 pb-2 pt-0 border-bottom"><span class="fa fa-map-marker"></span> {$Place}</span>
                <span class="text-muted text-md d-block mb-0 pb-2 pt-0"><span class="fa fa-clock-o"></span> <%t SilverCart.Until 'until' %> {$EndTime.Format('dd')}. {$EndTime.ShortMonth}</span>
                <div class="pl-4">
                <% loop $EventTimes.limit(4) %>
                    <a class="border rounded p-1 pb-0 mr-2 mb-2 d-inline-block" href="{$Link}">
                        <span class="float-left text-center mx-1">
                            <span class="d-block text-uppercase text-danger">{$StartTime.ShortMonth}</span>
                            <span class="d-block text-lg line-height-1">{$StartTime.Format('dd')}</span>
                        </span>
                        <span class="font-weight-bold ml-2 line-height-3 d-inline-block"><span class="fa fa-clock-o"></span> {$StartTime.Format('EEEEEE')} {$StartTime.Format('HH:mm')} <%t SilverCart\Model\Pages\Page.Oclock 'o\'clock' %></span>
                    </a>
                <% end_loop %>
                <% if $EventTimes.limit(1000,4) %>
                    <a class="border rounded p-1 pb-0 mr-2 mb-2 d-inline-block" href="{$Link}">
                        <span class="font-weight-bold mx-3 line-height-3 d-inline-block">+{$EventTimes.limit(1000,4).count}</span>
                    </a>
                <% end_if %>
                </div>
                <span class="text-muted d-block mt-1 pt-3 border-top">{$Description}</span>
                <a class="float-right" href="{$FacebookLink}" target="blank"><span class="fa fa-facebook-square"></span> {$fieldLabel('OpenInFacebook')} <span class="fa fa-xs fa-external-link"></span></a>
            </div>
        </article>
        <% if $PaginatedUpcomingTimes %>
        <section class="bg-white border shadow-sm">
            <header class="p-3 mb-3 border-bottom">
                <h1 class="p-0 m-0 d-inline-block"><%t SilverCart\FacebookPlugins\Model\Pages\EventsPage.UpcomingEvents 'Upcoming Events' %></h1>
            <% with $PaginatedUpcomingTimes %>
                <% if $TotalPages == 1 %>
                <span class="ml-2"><%t SilverCart\FacebookPlugins\Model\Pages\EventsPage.PageXofYSingular '{items} events on one page' items=$TotalItems %></span>
                <% else %>
                <span class="ml-2"><%t SilverCart\FacebookPlugins\Model\Pages\EventsPage.PageXofYPlural 'Page {current} of {pages} | {items} events on {pages} pages' current=$CurrentPage pages=$TotalPages items=$TotalItems %></span>
                <% end_if %>
            <% end_with %>
            </header>
            <% loop $PaginatedUpcomingTimes %>
                <% include SilverCart/FacebookPlugins/Model/Pages/EventTimeSummary %>
            <% end_loop %>
            <% with $PaginatedUpcomingTimes %>
                <% include SilverCart/FacebookPlugins/Model/Pages/EventTimePagination %>
            <% end_with %>
        </section>
        <% end_if %>
            <% end_with %>
        <% end_if %>
        <% include SilverCart/Model/Pages/WidgetSetContent %>
    </section>
    <aside class="col-12 col-md-3">
        {$SubNavigation}
        {$InsertWidgetArea('Sidebar')}
    </aside>
</div>