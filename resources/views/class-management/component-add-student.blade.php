<form id="form-add-student">@csrf
    <div class="row">
        <div class="col-6">
            <input type="text" name="name" required placeholder="Nama siswa" class="form-control">
        </div>
        <div class="col-6">
            <input type="text" name="user_number" required placeholder="Nomor Induk" class="form-control">
        </div>
        <div class="col-6 mt-3">
            <select class="form-control" name="class_id" required style="width: 100%" data-style="btn btn-link" id="exampleSelectClass">
                <option value="" hidden>Pilih Kelas</option>
                @foreach ($class as $item)
                    <option value="{{$item['id']}}">{{$item['name']}}</option>
                @endforeach
            </select>
        </div>
        <div class='col-6 mt-3'>
            <input type="text" name="password" required placeholder="Password .." class="form-control">
        </div>
        <div class="col-12 mt-3">
            <button class="btn btn-success btn-block" id="btn-tambah-siswa">Tambah Siswa</button>
        </div>
    </div>
</form>
<script>
    $('#exampleSelectClass').select2({
        dropdownParent: $('#addStudent')
    })
</script>
