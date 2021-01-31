<form id="form-add-teacher">@csrf
    <div class="row">
        <div class="col-6">
            <input type="text" name="name" placeholder="Nama Guru" class="form-control">
        </div>
        <div class="col-6">
            <input type="text" name="user_number" placeholder="Nomor Induk" class="form-control">
        </div>
        <div class='col-12 mt-3'>
            <input type="text" name="password" placeholder="Password .." class="form-control">
        </div>
        <div class="col-12 mt-3">
            <button class="btn btn-success btn-block" id="btn-tambah-guru">Tambah Guru</button>
        </div>
    </div>
</form>