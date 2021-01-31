$('.id_unit').on('change', function() {
    var deskripsi = $('.id_unit option:selected').text();
    if (deskripsi == 'CBM') {
        $(".tmp_deskripsi").append('<div class="deskripsi"><label for="">Description :</label><input name="description" class="form-control" style="height:35px;"></div>');
    } else {
        $(".deskripsi").remove();
    }

});