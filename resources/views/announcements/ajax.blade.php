<form action="{{url('announcementEditExecute')}}" method="POST">@csrf
    <div class="modal-header" >
        <h5 class="modal-title" id="exampleModalLabel">Edit Pengumuman</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
        </div>
        <div class="modal-body" id="box_edit_announcements">
            {{-- Data will be sent --}}
            <input type="hidden" name="id" value="{{$data['id']}}">
            <div class="form-group">
                <label for="">Judul : </label>
                <input type="text" name="name" required class="form-control" value="{{$data['name']}}">
                @if ($errors->has('name'))
                    <span class="text-danger">{{ $errors->first('name') }}</span>
                @endif
            </div>
            <div class="form-group">
                <label for="">Deskripsi : </label>
                <input type="text" name="description" required class="form-control" value="{{$data['description']}}">
                @if ($errors->has('description'))
                    <span class="text-danger">{{ $errors->first('description') }}</span>
                @endif
            </div>
            <div class="form-group">
                <div class="col-12 mt-3">
                    <label for="imgInp1">
                    @if ($data['images'] == true)
                    <input type='file' name="images" id="imgInp1" class="d-none"/>
                    <img id="image-preview-edit" src="{{$data['images']}}" style="width:100%; height:50%; cursor: pointer;" alt="your image" />
                    @else
                    <input type='file' name="images" id="imgInp1" class="d-none"/>
                    <img id="image-preview" src="https://www.canadasoccer.com/wp-content/uploads/2019/11/no-image-default.png" style="width:100%; height:50%; cursor: pointer;" alt="your image" />
                    @endif
                    </label>
                </div>
            </div>
        </div>
        <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
        <button type="submit" class="btn btn-success">Simpan</button>
    </div>
</form>
<script>
    function readURL(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();

            reader.onload = function(e) {
            $('#image-preview-edit').attr('src', e.target.result);
            }

            reader.readAsDataURL(input.files[0]); // convert to base64 string
        }
    }
    $("#imgInp1").change(function() {
        readURL(this);
    });
</script>
