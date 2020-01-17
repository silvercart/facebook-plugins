<section class="bg-white border shadow-sm m-1 pb-1" style="height: 32%!important; overflow: hidden;">
    <header class="p-3 border-bottom">
        <h2 class="p-0 m-0 d-inline-block"><a href="{$Link}">{$Name}</a></h2>
    </header>
    <div class="row no-gutters">
    <% if $Cover %>
        <%--div class="col-6 p-1"><img src="{$Cover.ScaleMaxWidth(500).CropHeight(250).URL}" alt="{$Name}" class="img-fluid" /></div--%>
        <div class="col-6 p-1"><img src="{$Cover.FillMax(348,160).URL}" alt="{$Name}" class="img-fluid" /></div>
    <% end_if %>
        <div class="p-2 text-center
             <% if $Cover %>
             col-6
             <% else %>
             col-12
             <% end_if %>
             ">
            <% loop $UpcomingTimes.limit(1) %>
            <span class="border rounded mt-4 p-1 pb-0 mr-2 d-inline-block text-lg">
                <span class="float-left text-center mx-1">
                    <span class="d-block text-uppercase text-danger">{$StartTime.ShortMonth}</span>
                    <span class="d-block text-lg line-height-1">{$StartTime.Format('dd')}</span>
                </span>
                <span class="font-weight-bold ml-2 line-height-3 d-inline-block"><span class="fa fa-clock-o"></span> {$StartTime.Format('EEEEEE')} {$StartTime.Format('HH:mm')} <%t SilverCart\Model\Pages\Page.Oclock 'o\'clock' %></span>
            </span>
            <% end_loop %>
            <span class="text-muted d-none mb-4"><span class="fa fa-map-marker"></span> {$Place.Nice}</span>
            <span class="text-muted d-none mb-4">{$Description.LimitCharactersToClosestWord(180)}</span>
        </div>
    </div>
</section>