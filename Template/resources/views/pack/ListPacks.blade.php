<style>
    .error-message {
        color: red;
        margin-top: 5px;
    }
</style>
<div class="row mT-30">

    <div class="row mT-15">
       <div class="col-md-12 ">
            <div class="bgc-white bd bdrs-3 p-20 mB-20">
                <h4 class="c-grey-900 mB-20">Ajout pack</h4>
                <form action="{{ url('createPack') }}" method="post" enctype="multipart/form-data">
                    @csrf
                    <div class="row">
                        <div class="mb-6 col-md-3">
                        <label class="form-label" for="inputext">Name</label>
                        <input type="text" name="name" class="form-control"  id="inputtext" placeholder="name" required>
                            @error('name')
                                <p class="error-message">{{ $message }}</p>
                            @enderror
                        </div>
                        <div class="mb-6 col-md-3">
                            <label class="form-label" for="inputext">Prix</label>
                            <input type="number" name="price" class="form-control"  id="inputtext" placeholder="prix" required>
                            @error('name')
                                <p class="error-message">{{ $message }}</p>
                            @enderror
                        </div>
                        <div class="mb-12 col-md-3">
                            <label class="form-label" for="image">Images</label>
                            <input type="file" name="images[]" class="form-control" id="image" accept="image/*" multiple>
                            @error('images')
                                <p class="error-message">{{ $message }}</p>
                            @enderror
                        </div>

                    </div>
                    <button type="submit" class="btn btn-primary btn-color mT-15">Valider</button>
                </form>
            </div>


       </div>
    </div>

    <div class="row mt-4">
        @if(session('error'))
        <div class="col-12">
            <div class="alert alert-danger">{{ session('error') }}</div>
        </div>
        @endif
        @foreach($packs as $data)
        <div class="col-md-4 mt-4">
            <div class="card">
                <img src="{{ asset($data->picture) }}" class="card-img-top" alt="{{ $data->name }}">
                <div class="card-body">
                    <h5 class="card-title">{{ $data->name }} <b>numero</b> {{ $data->id_pack }}</h5>
                    <p class="card-text">Prix : {{ $data->price }} AR</p>
                    <div class="d-flex justify-content-between align-items-center">
                        <a href="{{ url('detailPack/' . $data->id_pack) }}" class="btn btn-primary">Détails</a>
                        <a href="#" class="btn btn-warning edit-detail" data-id="{{$data->id_pack}}">Modifier</a>
                        <form action="{{ route('packs.delete', ['id' => $data->id_pack]) }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger">Supprimer</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        @endforeach
    </div>

</div>

<div id="detailModal" class="modal" style="display: none;" tabindex="-1" aria-labelledby="detailModal" aria-hidden="true">
    <form id="editDetailForm" action="{{ url('updatePack') }}" method="post" enctype="multipart/form-data">
        @csrf
        <div class="modal-dialog">
            <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Modifier le  pack {{ $data->name }} <b>numero</b> {{ $data->id_pack }}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"  onclick="closeModal()" aria-label="Close"></button>
            </div>
            <div class="modal-body">


                <div class="row">
                    <div class="mb-6 col-md-12">
                    <label class="form-label" for="inputext">Name</label>
                    <input type="text" name="name" class="form-control"  id="name" placeholder="name" required>
                    <input type="hidden" name="id_pack" id="id_pack" class="form-control"  id="inputtext" placeholder="name" required>
                        @error('name')
                            <p class="error-message">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div class="row">
                    <div class="mb-6 col-md-12">
                        <label class="form-label" for="inputext">Prix</label>
                        <input type="number" name="price" id="price" class="form-control"  id="inputtext" placeholder="prix" required>
                        @error('name')
                            <p class="error-message">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div class="row">
                    <div class="mb-12 col-md-12">
                        <label class="form-label" for="image">Image</label>
                        <input type="file" class="form-control" id="image" name="image">
                        @error('images')
                            <p class="error-message">{{ $message }}</p>
                        @enderror
                    </div>
                </div>


            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary"  onclick="closeModal()" data-bs-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary">Valider</button>
            </div>
            </div>
        </div>
    </form>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script>
    $(document).ready(function(){
        $('.edit-detail').click(function(){
            var id = $(this).data('id');
            $.ajax({
               url: "{{ url('/pack') }}/" + id,
                type: 'GET',
                success: function(response) {
                    console.log(response);
                    $('#name').val(response.name);
                    $('#id_pack').val(response.id_pack);
                    $('#price').val(response.price);
                     $('#detailModal').show();
                }
            });
        });

    });
    </script>
<script>
    function closeModal() {
        var modal = document.getElementById('detailModal');
        modal.style.display = 'none';
    }
    </script>

