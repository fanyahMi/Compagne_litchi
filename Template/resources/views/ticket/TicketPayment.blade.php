<style>
    .error-message {
        color: red;
        margin-top: 5px;
    }

    .form-group {
        margin-bottom: 20px;
    }
</style>
<div class="masonry-item col-md-10">
    <div class="bgc-white p-20 bd">
        <h6 class="c-grey-900">Paiement des billets</h6>
        <div class="mT-30">
            @if(Session::has('error'))
                <div class="alert alert-danger">
                    {{ Session::get('error') }}
                </div>
            @endif
            <div class="error-messages"></div>
            <form action="{{ url('ticketState') }}" method="post" enctype="multipart/form-data">
                @csrf
                <div class="form-group row">
                    <div class="col-md-6">
                        <label for="ticketNumber1" class="form-label">Numéro de billet</label>
                        <input type="text" name="ticketNumber1" class="form-control" id="ticketNumber1" required>
                        @error('ticketNumber1')
                        <p class="error-message">{{ $message }}</p>
                        @enderror
                    </div>
                    <div class="col-md-6" style="display: none">
                        <input type="hidden" name="ticketNumber2" class="form-control" id="ticketNumber2">
                        @error('ticketNumber2')
                        <p class="error-message">{{ $message }}</p>
                        @enderror
                    </div>
                    <div class="mb-5 col-md-6" id="client" style="display: none">
                        <label class="form-label" >Client</label>
                        <select  class="form-control" name="customer_id">
                                <option selected="selected" value="0">Choose...</option>
                              @foreach($customers as $customer)
                                  <option value="{{ $customer->id_customer }}">{{ $customer->name }}  </option>
                              @endforeach
                        </select>
                      </div>
                </div>
                <div class="form-group row">
                    <div class="mb-5 col-md-4">
                        <label class="form-label" for="inputState">Tranche de paiment</label>
                        <select id="inputState" class="form-control" name="tranche">
                          <option value="1">en 1</option>
                          <option value="2">en 2</option>
                          <option value="3">en 3</option>
                        </select>
                    </div>
                    <div class="col-md-4" >
                        <label for="payement" class="form-label">Total à payer pour le billet</label>
                        <input type="number" class="form-control" id="payementTotal" value="0" disabled>
                    </div>
                    <div class="col-md-4">
                        <label for="payement" class="form-label">Total à payer pour chaque billet</label>
                        <input type="number" name="payement" class="form-control" id="payement" value="0" disabled>
                        <input type="hidden" name="paiment2" class="form-control" id="payement2" value="0">
                        <input type="hidden"  class="form-control" id="reste" value="0">
                            @error('paiment2')
                            <p class="error-message">{{ $message }}</p>
                            @enderror
                    </div>
                </div>

                <button type="submit" class="btn btn-primary btn-color mt-3">Valider</button>
            </form>

        </div>
    </div>
</div>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function() {
        $('#ticketNumber1, #ticketNumber2').change(function() {
            var ticketNumber1Value = $('#ticketNumber1').val();
            var ticketNumber2Value = $('#ticketNumber2').val();

            $.ajax({
                    url: "{{url('checkCustomer')}}",
                    type: 'POST',
                    data: {
                        ticketNumber1: ticketNumber1Value,
                        _token: '{{ csrf_token() }}'
                    },
                    success: function(response) {
                        if (response.success) {
                           if(response.customer_id == false){
                                $('#client').show();
                           }
                        }
                    }
                });





            $.ajax({
                    url: "{{url('ticketPriceTotal')}}",
                    type: 'POST',
                    data: {
                        ticketNumber1: ticketNumber1Value,
                        ticketNumber2: ticketNumber2Value,
                        _token: '{{ csrf_token() }}'
                    },
                    success: function(response) {
                         if (response.success) {
                            $('#payement').val(response.reste_paye);
                            $('#payement2').val(response.reste_paye);
                            $('#reste').val(response.reste_paye);
                            $('#payementTotal').val(response.total_paye);
                        } else {
                            var errorsHtml = '<ul>';
                            $.each(response.errors, function(index, error) {
                                errorsHtml += '<li>' + error + '</li>';
                            });
                            errorsHtml += '</ul>';
                            $('.error-messages').html(errorsHtml);
                        }
                    }
                });
            });
    });

    $(document).ready(function() {
        $('#inputState').change(function() {
            var selectedOption = $(this).val();
            var paymentValue = parseFloat($('#reste').val());
            if (!isNaN(paymentValue)) {
                $('#payement').val(paymentValue / selectedOption);
                $('#payement2').val(paymentValue / selectedOption);
            }
        });
    });
</script>
