<style>
    .error-message {
        color: red;
        margin-top: 5px;
    }
</style>

<div class="masonry-item col-md-12">
    <div class="bgc-white p-20 bd">
        <h6 class="c-grey-900">Rechercher Full Text</h6>
        <div class="mT-30">
            <form action="{{ url('fulltext') }}" method="get" enctype="multipart/form-data">
                @csrf
                <div class="row">
                    <div class="mb-6 col-md-6">
                        <label class="form-label" for="inputext">Mot cles</label>
                        <input type="text" name="fulltext" class="form-control" id="inputtext" placeholder="text" value="{{ old('text') }}" >
                        @error('fulltext')
                            <p class="error-message">{{ $message }}</p>
                        @enderror
                    </div>
                    <div class="mb-6 col-md-6">
                        <button style="margin-top: 5%" type="submit" class="btn btn-primary btn-color">Rechercher</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<br>

<div class="masonry-item col-md-12">
    <div class="bgc-white p-20 bd">
        <h6 class="c-grey-900">Simple</h6>
        <div class="mT-30">
            <form action="{{ url('multimot') }}" method="get" enctype="multipart/form-data">
                @csrf
                <div class="row">
                    <div class="mb-6 col-md-6">
                        <label class="form-label" for="inputext">Mots</label>
                        <input type="text" name="multimot" class="form-control" id="inputtext" placeholder="text" value="{{ old('text') }}" >
                        @error('multimot')
                            <p class="error-message">{{ $message }}</p>
                        @enderror
                    </div>
                    <div class="mb-6 col-md-6">
                        <button style="margin-top: 5%" type="submit" class="btn btn-primary btn-color">Rechercher</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<br>

<div class="masonry-item col-md-12">
    <div class="bgc-white p-20 bd">
        <h6 class="c-grey-900">Recherche Multi-Critères</h6>
        <div class="mT-30">
            <form action="{{ url('multicritere') }}" method="get">
                @csrf
                <div class="row">
                    <div class="mb-6 col-md-6">
                        <label class="form-label" for="department">Département :</label>
                        <select name="department" id="department" class="form-control">
                            <option value="">Sélectionner un département</option>
                            @foreach($departments as $department)
                                <option value="{{ $department->department_id }}">{{ $department->department_name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-6 col-md-6">
                        <label class="form-label" for="min_salary">Salaire minimum :</label>
                        <input type="number" name="min_salary" id="min_salary" class="form-control" placeholder="Salaire minimum">
                    </div>
                </div>
                <div class="row">
                    <div class="mb-6 col-md-6">
                        <label class="form-label" for="max_salary">Salaire maximum :</label>
                        <input type="number" name="max_salary" id="max_salary" class="form-control" placeholder="Salaire maximum">
                    </div>
                    <div class="mb-6 col-md-6">
                        <label class="form-label" for="start_date">Date de début :</label>
                        <input type="date" name="start_date" id="start_date" class="form-control">
                    </div>
                </div>
                <div class="row">
                    <div class="mb-6 col-md-6">
                        <label class="form-label" for="end_date">Date de fin :</label>
                        <input type="date" name="end_date" id="end_date" class="form-control">
                    </div>
                    <div class="mb-6 col-md-6">
                        <label class="form-label" for="keyword">Mot-clé :</label>
                        <input type="text" name="keyword" id="keyword" class="form-control" placeholder="Mot-clé">
                    </div>
                </div>
                <div class="row">
                    <div class="mb-6 col-md-12">
                        <button type="submit" class="btn btn-primary btn-color">Rechercher</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>






<div class="row mT-30">
      <div class="row mT-15">
        <div class="col-md-12">
            <div class="bgc-white bd bdrs-3 p-20 mB-20">
                <h4 class="c-grey-900 mB-20">Recherches</h4>
                <div id="table-container">
                    @include('template.recherche.Tableau', ['recherches' => $recherches])
                </div>
            </div>
        </div>
    </div>
</div>

