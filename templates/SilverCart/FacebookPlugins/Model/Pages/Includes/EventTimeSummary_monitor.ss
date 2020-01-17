<div class="pb-3 mx-4 my-3 mx-aside-3 mb-aside-2 border-bottom">
<% if $IsPast %>
    <a class="float-left text-center mr-md-3 mr-3" href="{$Link}">
        <span class="d-block text-uppercase text-muted">{$StartTime.ShortMonth}</span>
        <span class="d-block text-lg text-muted">{$StartTime.Format('dd')}</span>
    </a>
<% else %>
    <a class="float-left text-center mr-md-3 mr-3" href="{$Link}">
        <span class="d-block text-uppercase text-danger">{$StartTime.ShortMonth}</span>
        <span class="d-block text-lg">{$StartTime.Format('dd')}</span>
    </a>
<% end_if %>
    <div class="ml-5 ml-aside-4 clearfix">
        <h2 class="text-truncate mb-aside-0"><a href="{$Link}" title="{$Event.Name}">{$Event.Name}</a></h2>
        <span class="text-muted mr-1 mr-md-3 mr-aside-1"><span class="fa fa-clock-o"></span> {$StartTime.Format('EEEEEE')} {$StartTime.Format('HH:mm')} <%t SilverCart\Model\Pages\Page.Oclock 'o\'clock' %></span>
    </div>
</div>