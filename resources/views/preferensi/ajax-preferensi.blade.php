<form action="{{route('preferensi-edit-execute')}}" method="POST">@csrf
    <div class="modal-header" >
        <h5 class="modal-title" id="exampleModalLabel">Edit Preferensi</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
        </div>
        <div class="modal-body" id="box_edit_preferensi">
            {{-- Data will be sent --}}
            <input type="hidden" name="id" value="{{ $data['id'] }}">
            <div class="form-group">
                <label>Pilih Status Preferensi : </label><br>
                <select required class="form-control" style="width: 100%" name="status">
                    <option value="0">APPROVED</option>
                </select>
                @if ($errors->has('name'))
                    <span class="text-danger">{{ $errors->first('name') }}</span>
                @endif
            </div>
            <div class="form-group">
                <label>Input komentar : </label><br>
                <input type="text" class="form-control" id="exampleFormControlInput1" placeholder="Hello World!!" name="komentar">
                @if ($errors->has('name'))
                    <span class="text-danger">{{ $errors->first('name') }}</span>
                @endif
            </div>
        </div>
        <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
        <button type="submit" class="btn btn-success">Simpan</button>
    </div>
</form>
