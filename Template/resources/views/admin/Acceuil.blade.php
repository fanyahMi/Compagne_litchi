<script src="{{ asset('assets/js/chart.js') }}"></script>
<script src="{{ asset('assets/js/jquery.js') }}"></script>

        <!-- ### $App Screen Content ### -->
            <div class="row gap-20 masonry pos-r">
              <div class="masonry-sizer col-md-6"></div>
              <div class="masonry-item w-100">
                <div class="row gap-20">


                  @include('template.statistique.NumberStat')

                  @include('template.statistique.NumberStat')

                  @include('template.statistique.NumberStat')

                  @include('template.statistique.NumberStat')

                </div>
              </div>

                 @include('template.chart.Batton')

                 @include('template.chart.LineSimpleChart')


                 @include('template.chart.LinePlusChart')

              </div>

            </div>




