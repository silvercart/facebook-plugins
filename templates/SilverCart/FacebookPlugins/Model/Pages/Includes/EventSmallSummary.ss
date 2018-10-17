<section class="bg-white border shadow-sm mb-4">
    <header class="py-1 px-2 py-lg-2 px-lg-3 border-bottom">
        <h3 class="p-0 m-0 text-truncate"><a href="{$Link}">{$Name}</a></h3>
    </header>
    <div class="py-2 px-3 py-lg-3 px-lg-4">
        <div class="row">
        <% if $Cover %>
            <div class="col-12 col-sm-4 mb-2 mb-sm-0"><a class="d-inline-block" href="{$Link}"><img src="{$Cover.ScaleMaxWidth(200).CropHeight(100).URL}" alt="{$Name}" class="img-fluid" /></a></div>
            <div class="col-12 col-sm-8"><span class="text-muted d-block mb-2"><span class="fa fa-map-marker"></span> {$Place.Nice}</span></div>
        <% else %>
            <div class="col-12"><span class="text-muted d-block mb-2"><span class="fa fa-map-marker"></span> {$Place.Nice}</span></div>
        <% end_if %>
            <div class="col-12">
                <span class="text-muted d-block mb-2">{$Description.LimitCharactersToClosestWord(150)}<br/>
                    <a class="ml-2" href="{$Link}"><span class="fa fa-arrow-right"></span> weitere Details</a>
                    <a class="ml-2" href="{$FacebookLink}" target="blank"><span class="fa fa-facebook-square"></span> {$fieldLabel('OpenInFacebook')} <span class="fa fa-xs fa-external-link"></span></a>
                </span>
                <% loop $UpcomingTimes.limit(1) %>
                <a class="border rounded mt-2 p-1 pb-0 mr-2 d-inline-block" href="{$FacebookLink}" target="blank">
                    <span class="float-left text-center mx-1">
                        <span class="d-block text-uppercase text-danger">{$StartTime.ShortMonth}</span>
                        <span class="d-block text-lg line-height-1">{$StartTime.Format('dd')}</span>
                    </span>
                    <span class="font-weight-bold ml-2 line-height-3 d-inline-block"><span class="fa fa-clock-o"></span> {$StartTime.Format('EEEEEE')} {$StartTime.Format('HH:mm')} <%t SilverCart\Model\Pages\Page.Oclock 'o\'clock' %></span>
                </a>
                <% end_loop %>
                <% if $UpcomingTimes.limit(1000,1) %>
                <a class="border rounded mt-2 p-1 pb-0 mr-2 d-inline-block" href="{$Link}#times">
                    <span class="font-weight-bold mx-3 line-height-3 d-inline-block">+{$UpcomingTimes.limit(1000,1).count}</span>
                </a>
                <% end_if %>
            </div>
        </div>
    </div>
</section>