<% if $UpcomingEvents %>
<header class="sr-only"><h2><%t SilverCart\FacebookPlugins\Model\Pages\EventsPage.UpcomingEvents 'Upcoming Events' %></h2></header>
<div class="bg-white border shadow-sm my-0 px-0 pt-3 last-child-no-border last-child-pb-0">
    <% loop $UpcomingEvents %>
        <% include SilverCart/FacebookPlugins/Model/Pages/EventTimeSummary %>
        <% if $First && not $Last %>
</div>
<div class="bg-white border shadow-sm my-0 px-0 pt-3 mt-3 last-child-no-border last-child-pb-0">
        <% end_if %>
    <% end_loop %>
</div>
    <% if $EventsLink %>
<a class="btn btn-sm btn-link mt-2 float-right" href="{$EventsLink}"><span class="fa fa-arrow-right"></span> <%t SilverCart\FacebookPlugins\Model\Pages\EventsPage.ShowMore 'Show more events' %></a>
    <% end_if %>
<% end_if %>