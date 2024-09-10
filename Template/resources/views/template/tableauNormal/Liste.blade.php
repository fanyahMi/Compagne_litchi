<div class="row mT-30">
      <div class="row mT-15">
        <div class="col-md-12">
            <div class="bgc-white bd bdrs-3 p-20 mB-20">
                <div class="row">
                    <div class="col-md-6">
                        <h4 class="c-grey-900 mB-20">Tableau</h4>
                    </div>
                    <div class="col-md-2"></div>
                    <div class="col-md-4">
                        <input type="text" name="recherche" class="form-control" id="inputtext" placeholder="Votre Recherche" >
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div id="table-container">
                            @include('template.tableauNormal.Tableau', ['recherches' => $recherches])
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="{{ asset('assets/js/jquery.js') }}"></script>
<script type="text/javascript">
    $(document).ready(function() {
        $('#inputtext').on('input', function() {
            var recherche = $(this).val();
            $.ajax({
                type: 'GET',
                url: "{{url('rechercheTableau')}}",
                data: {
                    recherche: recherche
                },
                success: function(data) {
                    $('#table-container').html(data);
                }
            });
        });
    });
</script>
