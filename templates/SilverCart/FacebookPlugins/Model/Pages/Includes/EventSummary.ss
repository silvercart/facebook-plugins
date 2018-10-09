<section class="bg-white border shadow-sm my-4">
    <header class="p-3 border-bottom">
        <h2 class="p-0 m-0 d-inline-block"><a href="{$Link}">{$Name}</a></h2>
        <span class="text-danger ml-2"><%t SilverCart.Until 'until' %> {$EndTime.Format('dd')}. {$EndTime.ShortMonth}</span>
    </header>
    <div class="py-3 px-4">
        <div class="row">
        <% if $Cover %>
            <div class="col-12 col-sm-4 mb-3 mb-sm-0"><img src="{$Cover.ScaleMaxWidth(500).CropHeight(250).URL}" class="img-fluid" /></div>
        <% end_if %>
            <div class="
                 <% if $Cover %>
                 col-12 col-sm-8
                 <% else %>
                 col-12
                 <% end_if %>
                 ">
                <span class="text-muted d-block mb-4"><span class="fa fa-map-marker"></span> {$Place}</span>
                <span class="text-muted d-block mb-4">{$Description.LimitCharactersToClosestWord(180)}
                    <a class="ml-2" href="{$Link}"><span class="fa fa-arrow-right"></span> weitere Details</a>
                    <a class="ml-2" href="{$FacebookLink}" target="blank"><span class="fa fa-facebook-square"></span> {$fieldLabel('OpenInFacebook')} <span class="fa fa-xs fa-external-link"></span></a>
                </span>
                <% loop $UpcomingTimes.limit(2) %>
                <a class="border rounded mt-2 p-1 pb-0 mr-2 d-inline-block" href="{$FacebookLink}" target="blank">
                    <span class="float-left text-center mx-1">
                        <span class="d-block text-uppercase text-danger">{$StartTime.ShortMonth}</span>
                        <span class="d-block text-lg line-height-1">{$StartTime.Format('dd')}</span>
                    </span>
                    <span class="font-weight-bold ml-2 line-height-3 d-inline-block"><span class="fa fa-clock-o"></span> {$StartTime.Format('EEEEEE')} {$StartTime.Format('HH:mm')} <%t SilverCart\Model\Pages\Page.Oclock 'o\'clock' %></span>
                </a>
                <% end_loop %>
                <% if $UpcomingTimes.limit(1000,2) %>
                <a class="border rounded mt-2 p-1 pb-0 mr-2 d-inline-block" href="{$Link}#times">
                    <span class="font-weight-bold mx-3 line-height-3 d-inline-block">+{$UpcomingTimes.limit(1000,2).count}</span>
                </a>
                <% end_if %>
            </div>
        </div>
    </div>
</section>