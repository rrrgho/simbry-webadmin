<form action="{{ url('books-management/' . $data['id'] . '/edit-books') }}" enctype="multipart/form-data" method="POST">@csrf
    <div class="modal-header">
        <h4 class="modal-title">Edit Buku</h4>
    </div>
    <div class="modal-body" id="box_examplar_edit">
        <div class="row">
            <input type="hidden" name="id" value="{{ $data['id'] }}">
            <div class="col-6 mt-3">
                <label>Judul : </label><br>
                <input required class="date form-control" name="name" value="{{ $data['name'] }}" type="text">
            </div>
            <div class="col-6 mt-3">
                <label>Pilih Kategori : </label><br>
                <select required class="form-control" style="width: 100%" name="category_id" id="category">
                    <option value="" hidden>Pilih Category</option>
                    @foreach ($category as $item)
                        <option @if ($data['category_id'] == $item['id']) selected @endif value="{{ $item['id'] }}">
                            {{ $item['name'] }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-6 mt-3">
                <label>Penulis : </label><br>
                <input required class="date form-control" name="creator" value="{{ $data['creator'] }}" type="text">
            </div>
            <div class="col-6 mt-3">
                <label for="">Pilih Loker : </label>
                <select required class="form-control" style="width: 100%" name="locker_id">
                    <option value="" hidden>Pilih Loker</option>
                    @foreach ($locker as $item)
                        <option @if ($data['locker_id'] == $item['id']) selected @endif value="{{ $item['id'] }}">
                            {{ $item['name'] }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-6 mt-3">
                <label for="">Asal Buku : </label>
                <input required class="date form-control" name="origin_book" type="text"
                    value="{{ $data['origin_book'] }}">
            </div>
            <div class="col-6 mt-3">
                <label for="">Nomor Panggil : </label>
                <input required class="date form-control" name="no_panggil" type="text"
                    value="{{ $data['no_panggil'] }}">
            </div>
            <div class="col-12 mt-3">
                <label for="imgInp">
                @if ($data['cover'] == true)
                <input type='file' name="cover" id="imgInp" class="d-none"/>
                <img id="image-preview" src="{{$data['cover']}}" style="width:100%; height:50%; cursor: pointer;" alt="your image" />
                @else
                <input type='file' name="cover" id="imgInp" class="d-none"/>
                <img id="image-preview" src="https://www.canadasoccer.com/wp-content/uploads/2019/11/no-image-default.png" style="width:100%; height:50%; cursor: pointer;" alt="your image" />
                @endif
                </label>
            </div>
        </div>
    </div>
    <div class="modal-footer">
        <div class="form-group text-center">
            <button type="button" class="btn btn-light" data-dismiss="modal">Close</button>
            <button class="btn btn-success" id="btn-tambah-books" type="submit">Edit Buku</button>
        </div>
    </div>
</form>
<script>
    $('#category').select2()
    // Image Preview
    function readURL(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();

            reader.onload = function(e) {
            $('#image-preview').attr('src', e.target.result);
            console.log(reader)
            }

            reader.readAsDataURL(input.files[0]); // convert to base64 string
        }
    }
    $("#imgInp").change(function() {
        readURL(this);
    });
</script>
