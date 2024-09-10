<style>
    .error-message {
        color: red;
        margin-top: 5px;
    }
</style>

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
                        <input type="hidden" name="recherche" class="form-control" id="inputtext" placeholder="Votre Recherche" >
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div id="table-container">
                            @include('template.tableau.Tableau', ['recherches' => $recherches])
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="{{ asset('assets/js/jquery.js') }}"></script>

<script>
    $(document).on('click', '.pagination a', function(e) {
        e.preventDefault();
        var url = $(this).attr('href');
        $.ajax({
            url: url,
            type: 'GET',
            success: function(data) {
                console.log(data);
                $('#table-container').html(data);
            }
        });
    });


</script>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const searchInput = document.getElementById('inputtext');
        const tableBody = document.getElementById('table-body');

        searchInput.addEventListener('input', function () {
            const searchTerm = this.value.toLowerCase();
            const rows = tableBody.getElementsByTagName('tr');

            Array.from(rows).forEach(row => {
                let found = false;
                Array.from(row.cells).forEach(cell => {
                    const cellText = cell.textContent.toLowerCase();
                    if (cellText.includes(searchTerm)) {
                        found = true;
                    }
                });
                if (found) {
                    row.style.display = '';
                } else {
                    row.style.display = 'none';
                }
            });
        });
    });
</script>
