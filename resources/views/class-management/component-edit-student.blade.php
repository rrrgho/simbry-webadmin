<form id="form-edit-student">@csrf
    <div class="row">
        <input type="hidden" name="id" value="{{$user->id}}">
        <div class="col-6">
            <input type="text" name="name" value="{{$user->name}}" required placeholder="Nama siswa" class="form-control">
        </div>
        <div class="col-6">
            <input type="text" name="user_number" value="{{$user->user_number}}" required placeholder="Nomor Induk" class="form-control">
        </div>
        <div class="col-6 mt-3">
            <select class="form-control" name="class_id" required data-style="btn btn-link" id="exampleFormControlSelect1">
                <option value="" hidden>Pilih Kelas</option>
                @foreach ($class as $item)
                    <option @if($user->class_id == $item['id']) selected @endif value="{{$item['id']}}">{{$item['name']}}</option>
                @endforeach
            </select>
        </div>
        {{-- <div class='col-6 mt-3'>
            <input type="text" name="password" required placeholder="Password .." class="form-control">
        </div> --}}
        <div class="col-12 mt-3">
            <button class="btn btn-success btn-block" id="btn-tambah-siswa">Tambah Siswa</button>
        </div>
    </div>
</form>