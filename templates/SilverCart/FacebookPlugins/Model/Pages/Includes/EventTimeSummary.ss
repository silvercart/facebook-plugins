<div class="pb-3 mx-4 mb-3 border-bottom">
    <a class="float-left text-center mr-md-3 mr-3" href="{$Link}">
        <span class="d-block text-uppercase text-danger">{$StartTime.ShortMonth}</span>
        <span class="d-block text-lg">{$StartTime.Format('dd')}</span>
    </a>
    <div class="ml-5 clearfix">
        <h3 class="d-inline-block"><a href="{$Link}">{$Event.Name}</a></h3><br/>
        <span class="text-muted mr-1 mr-md-3"><span class="fa fa-clock-o"></span> {$StartTime.Format('EEEEEE')} {$StartTime.Format('HH:mm')} <%t SilverCart\Model\Pages\Page.Oclock 'o\'clock' %></span>
        <span class="text-muted"><span class="fa fa-map-marker"></span> {$Event.Place}</span>
        <a class="float-right" href="{$FacebookLink}" target="blank"><span class="fa fa-facebook-square"></span> {$Event.fieldLabel('OpenInFacebook')} <span class="fa fa-xs fa-external-link"></span></a><br/>
    </div>
</div>
{$LoadMicrodata}