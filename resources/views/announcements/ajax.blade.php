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
        </div>
        <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
        <button type="submit" class="btn btn-success">Simpan</button>
    </div>
</form>