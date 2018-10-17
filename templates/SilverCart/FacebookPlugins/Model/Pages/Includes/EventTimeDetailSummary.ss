<div class="pb-3 mx-4 mb-3 mx-aside-3 mb-aside-2 border-bottom">
    <a class="float-left text-center mr-md-3 mr-3" href="{$Link}">
        <span class="d-block text-uppercase text-danger">{$StartTime.ShortMonth}</span>
        <span class="d-block text-lg">{$StartTime.Format('dd')}</span>
    </a>
    <div class="ml-5 ml-aside-4 clearfix">
    <% if $StartTime.Format('d') < $EndTime.Format('d') %>
        <h3 class="line-height-2 d-inline-block"><span class="fa fa-clock-o"></span> {$StartTime.Format('EEEE')}, {$StartTime.Format('HH:mm')} <%t SilverCart.Until 'until' %> {$StartTime.Format('EEEE')}, {$EndTime.Format('HH:mm')} <%t SilverCart\Model\Pages\Page.Oclock 'o\'clock' %></h3>
    <% else %>
        <h3 class="pt-3 d-inline-block"><span class="fa fa-clock-o"></span> {$StartTime.Format('EEEE')}, {$StartTime.Format('HH:mm')} <%t SilverCart.Until 'until' %> {$EndTime.Format('HH:mm')} <%t SilverCart\Model\Pages\Page.Oclock 'o\'clock' %></h3>
    <% end_if %>
        <a class="float-right" href="{$FacebookLink}" target="blank"><span class="fa fa-facebook-square"></span> {$Event.fieldLabel('OpenInFacebook')} <span class="fa fa-xs fa-external-link"></span></a><br/>
    </div>
</div>
{$Microdata}