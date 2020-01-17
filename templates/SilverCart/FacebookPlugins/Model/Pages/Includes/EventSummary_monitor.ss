<section class="bg-white border shadow-sm m-1 pb-1" style="height: 32%!important; overflow: hidden;">
    <header class="p-3 border-bottom">
        <h2 class="p-0 m-0 d-inline-block"><a href="{$Link}">{$Name}</a></h2>
    </header>
    <div class="row no-gutters">
        <div class="col-6 p-1">
        <% if $Cover %>
            <img src="{$Cover.FillMax(348,160).URL}" alt="{$Name}" class="img-fluid" />
        <% else %>
            &nbsp;
        <% end_if %>
        </div>
        <div class="col-6 p-2 text-center">
            <% loop $UpcomingTimes.limit(1) %>
            <span class="border rounded mt-4 p-1 pb-0 mr-2 d-inline-block text-lg">
                <span class="float-left text-center mx-1">
                    <span class="d-block text-uppercase text-danger">{$StartTime.ShortMonth}</span>
                    <span class="d-block text-lg line-height-1">{$StartTime.Format('dd')}</span>
                </span>
                    <span class="ml-2 pt-2 text-right d-inline-block line-height-1">{$StartTime.Format('EEEE')}<br/><span class="fa fa-clock-o"></span> {$StartTime.Format('HH:mm')} <%t SilverCart\Model\Pages\Page.Oclock 'o\'clock' %></span>
            </span>
            <% end_loop %>
            <span class="text-muted d-none mb-4"><span class="fa fa-map-marker"></span> {$Place.Nice}</span>
            <span class="text-muted d-none mb-4">{$Description.LimitCharactersToClosestWord(180)}</span>
        </div>
    </div>
</section>