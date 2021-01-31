<form id="form-edit-teacher">@csrf
    <div class="row">
        <input type="hidden" name="id" value="{{$user->id}}">
        <div class="col-6">
            <input type="text" name="name" value="{{$user->name}}" required placeholder="Nama siswa" class="form-control">
        </div>
        <div class="col-6">
            <input type="text" name="user_number" value="{{$user->user_number}}" required placeholder="Nomor Induk" class="form-control">
        </div>
        {{-- <div class='col-6 mt-3'>
            <input type="text" name="password" required placeholder="Password .." class="form-control">
        </div> --}}
        <div class="col-12 mt-3">
            <button class="btn btn-success btn-block" id="btn-tambah-siswa">Tambah Guru</button>
        </div>
    </div>
</form>