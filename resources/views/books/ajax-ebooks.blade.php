<form action="{{url('books-management/ebooks-editexecute')}}" enctype="multipart/form-data" method="POST">@csrf
    <div class="modal-header" >
        <h5 class="modal-title" id="exampleModalLabel">Edit E-Books</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
        </div>
        <div class="modal-body" id="box_edit_ebooks">
            {{-- Data will be sent --}}
            <input type="hidden" name="id" value="{{$data['id']}}">
            <div class="row">
                <div class="col-12 mb-4">
                    <div class="alert alert-danger d-none" id="warning">
                    </div>
                </div>
                <div class="col-6 mt-3">
                    <label for="">Nama Buku : </label>
                    <input value="{{$data['name']}}" required class="form-control" name="name" type="text">
                </div>
                <div class="col-6 mt-3">
                    @if($category->count())
                    <label>Pilih Kategori : </label><br>
                    <select required class="form-control" style="width: 100%" name="category_id" id="category_ebooks_edit">
                        <option value="" hidden>Pilih Kategori</option>
                        @foreach($category as $item)
                        <option @if ($data['category_id'] == $item['id']) selected @endif value="{{ $item['id'] }}">
                            {{ $item['name'] }}</option>
                        @endforeach
                    </select>
                    @else
                    <select name="" id="" hidden required>
                    </select>
                    <div class="alert alert-warning">
                        Data kategori buku tidak di temukan ! mohon masukkan data kategori!!
                    </div>
                    @endif
                </div>
                <div class="col-6 mt-3">
                    <label>Penulis : </label><br>
                    <input value="{{$data['creator']}}" required class="date form-control"  name="creator" type="text">
                </div>
                <div class="col-6 mt-3">
                    @if($publisher->count())
                    <label for="">Pilih Penerbit : </label>
                    <select required class="form-control" style="width: 100%;" name="publisher_id" id="publisher_ebooks_edit">
                        <option value="" hidden>Pilih Penerbit</option>
                        @foreach($publisher as $item)
                        <option @if ($data['publisher_id'] == $item['id']) selected @endif value="{{ $item['id'] }}">
                            {{ $item['name'] }}</option>
                        @endforeach
                    </select>
                    @else
                    <select name="" id="" hidden required>
                    </select>
                    <div class="alert alert-warning">
                        Data penerbit buku tidak di temukan ! mohon masukkan data penerbit!!
                    </div>
                    @endif
                </div>
                <div class="col-6 mt-3">
                    <label for="">Pilih Edisi : </label>
                    <input value="{{$data['edition']}}" required class="date form-control"  name="edition" value="" type="text">
                </div>
                <div class="col-6 mt-3">
                    <label for="">Asal Buku : </label>
                    <input value="{{$data['origin_book']}}" required class="date form-control"  name="origin_book"  type="text">
                </div>
                <div class="col-12 mt-3">
                    <label for="">Link PDF : </label>
                    <input type="text" class="form-control" value="" name="link_pdf" required>
                </div>
                <div class="col-12 mt-3">
                    <label for="">Deskripsi : </label>
                    <textarea class="form-control" id="exampleFormControlTextarea1" name="description"
                        rows="3"></textarea>
                </div>
                <div class="col-12 mt-4">
                    <label for="imgInp">
                    <input type='file' name="cover" id="imgInp" class="d-none"/>
                    <img id="image-preview" src="https://www.canadasoccer.com/wp-content/uploads/2019/11/no-image-default.png" style="width:100%; height:50%; cursor: pointer;" alt="your image" />
                    </label>
                </div>
            </div>
        </div>
        <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
        <button type="submit" class="btn btn-primary">Simpan</button>
    </div>
</form>
<script>
$('#category_ebooks_edit').select2({
    dropdownParent: $('#editEbooks')
})
$('#publisher_ebooks_edit').select2({
    dropdownParent: $('#editEbooks')
})
</script>
