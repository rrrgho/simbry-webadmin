  <form action="{{url('books-management/categoryEditExecute')}}" method="POST">@csrf
    <div class="modal-header" >
        <h5 class="modal-title" id="exampleModalLabel">Edit Kategori</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
        </div>
        <div class="modal-body" id="box_edit_category">
            {{-- Data will be sent --}}
            <input type="hidden" name="id" value="{{$data['id']}}">
            <div class="form-group">
                <label for="">Buku : </label>
                <input type="text" name="name" required class="form-control" value="{{$data['name']}}">
                @if ($errors->has('name'))
                    <span class="text-danger">{{ $errors->first('name') }}</span>
                @endif
            </div>
            <div class="form-group">
                @if($data->sub_category == NULL)
                <label>Pilih Sub Kategori : </label><br>
                <select required class="form-control" style="width: 100%" name="sub_category">
                    <option value="" hidden>Pilih Sub Kategori</option>
                    @foreach($sub_category as $item)
                        <option value="{{ $item['id'] }}">
                            {{ $item['name'] }}</option>
                    @endforeach
                </select>
                @else
                {{-- <select name="" id="" hidden required>
                </select>
                <div class="alert alert-warning">
                    Data kategori buku tidak di temukan ! mohon masukkan data kategori!!
                </div> --}}
                <label>Pilih Sub Kategori : </label><br>
                <select required class="form-control" style="width: 100%" name="sub_category">
                    <option value="{{$data['sub_category']}}">{{$data['sub_category_name']}}</option>
                    @foreach($sub_category as $item)
                        <option value="{{ $item['id'] }}">
                            {{ $item['name'] }}</option>
                    @endforeach
                </select>
                @endif
            </div>
        </div>
        <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
        <button type="submit" class="btn btn-primary">Simpan</button>
    </div>
</form>