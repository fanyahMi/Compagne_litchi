<style>
    .error-message {
        color: red;
        margin-top: 5px;
    }
</style>

<div class="masonry-item col-md-12">
    <div class="bgc-white p-20 bd">
        <h6 class="c-grey-900">Complex Form Layout</h6>
        <div class="mT-30">
            <form action="{{ url('addform') }}" method="post" enctype="multipart/form-data">
                @csrf
                <div class="row">
                    <div class="mb-12 col-md-6">
                        <label class="form-label" for="inputext">Type text</label>
                        <input type="text" name="textI" class="form-control" id="inputtext" placeholder="text" value="{{ old('text') }}" >
                        @error('textI')
                            <p class="error-message">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- Number Field -->
                <div class="row mT-15">
                    <div class="mb-12 col-md-6">
                        <label class="form-label" for="input">Number</label>
                        <input type="number" name="numberI" class="form-control" id="input" placeholder="number" value="{{ old('number') }}" >
                        @error('numberI')
                            <p class="error-message">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- Date Field -->
                <div class="row mT-15">
                    <div class="mb-12 col-md-6">
                        <label class="form-label" for="input">Date</label>
                        <input type="date" name="dateI" class="form-control" id="input" placeholder="number" value="{{ old('date') }}" >
                        @error('dateI')
                            <p class="error-message">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- Images Field -->
                <div class="row mT-15">
                    <div class="mb-12 col-md-6">
                        <label class="form-label" for="image">Images</label>
                           <input type="file" name="images[]" class="form-control" id="image" accept="image/*" multiple required>
                        @error('images.*')
                            <p class="error-message">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- CSV File Field -->
                <div class="row mT-15">
                    <div class="mb-12 col-md-6">
                        <label class="form-label" for="csv_file">Fichier CSV</label>
                        <input type="file" name="csv_fileI" class="form-control" id="csv_file" accept="text/csv">
                        @error('csv_fileI')
                            <p class="error-message">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- Excel File Field -->
                <div class="row mT-15">
                    <div class="mb-12 col-md-6">
                        <label class="form-label" for="excel_file">Fichier Excel</label>
                        <input type="file" name="excel_fileI" class="form-control" id="excel_file" accept=".xlsx, .xls" >
                        @error('excel_fileI')
                            <p class="error-message">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- Select Field -->
                <div class="row mT-15">
                    <div class="mb-5 col-md-5">
                        <label class="form-label" for="inputState">Select Option</label>
                        <select id="inputState" class="form-control" name="selectI" >
                            <option value="0" {{ old('select') == 0 ? 'selected' : '' }}>Choose...</option>
                            @foreach($selectOptions as $option)
                                <option value="{{ $option->id }}" {{ old('select') == $option->id ? 'selected' : '' }}>{{ $option->name }}</option>
                            @endforeach
                        </select>
                        @error('selectI')
                            <p class="error-message">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- Textarea Field -->
                <div class="row mT-5">
                    <div class="mb-12 col-md-6">
                        <label class="form-label" for="textarea">Zone de texte</label>
                        <textarea name="textareaI" class="form-control" id="textarea" placeholder="Votre texte" >{{ old('textarea') }}</textarea>
                        @error('textareaI')
                            <p class="error-message">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- Checkbox Field -->
                <div class="row mT-15">
                    <div class="mb-12 col-md-6">
                        <label class="form-label">Checkbox Example</label>
                        @foreach($checkboxOptions as $checkboxOption)
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="checkbox[]" id="{{ $checkboxOption->id }}" value="{{ $checkboxOption->id }}"
                                       @if(is_array(old('checkbox')) && in_array($checkboxOption->id, old('checkbox'))) checked @endif>
                                <label class="form-check-label" for="{{ $checkboxOption->id }}">
                                    {{ $checkboxOption->name }}
                                </label>
                            </div>
                        @endforeach
                        @error('checkbox')
                            <p class="error-message">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- Radio Button Field -->
                <div class="row mT-15">
                    <div class="mb-12 col-md-6">
                        <label class="form-label">Radio Button Example</label>
                        @foreach($radioOptions as $radioOption)
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="radio" id="{{ $radioOption->id }}" value="{{ $radioOption->id }}" {{ old('radio') == $radioOption->id ? 'checked' : '' }}>
                                <label class="form-check-label" for="{{ $radioOption->id }}">
                                    {{ $radioOption->name }}
                                </label>
                            </div>
                        @endforeach
                        @error('radio')
                            <p class="error-message">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- Bouton de soumission -->
                <br>
                <button type="submit" class="btn btn-primary btn-color">Valider</button>
            </form>
        </div>


    </div>
</div>

<script src="{{ asset('assets/js/jquery.js') }}"></script>

<a href="#" class="pR-20 edit-detail" data-id="1">
    <button class="btn btn-danger">Ty ny button modif <i class="fas fa-edit"></i></button>
</a>

@include('template.form.parcial.Modal')

<br>
@include('template.form.parcial.ImportMande')


<br>

