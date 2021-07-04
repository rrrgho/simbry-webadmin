$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});

$('#foto_asset').on('change', function() {
    //get the file name
    var fileName = $(this).val();
    //replace the "Choose a file" label
    // $(this).next('.custom-file-label').html(fileName);
    if (this.files && this.files[0]) {
        var reader = new FileReader();
        reader.onload = imageIsLoadedinsert;
        reader.readAsDataURL(this.files[0]);
    }
});

function imageIsLoadedinsert(e) {
    $('#display_foto').attr('src', e.target.result);
};

$("#icon-camera").click(function() {
    $("#foto_asset").trigger('click');
});

$('#foto_asset').on('change', function() {
    var val = $(this).val();
    var tmp = val.split("\\");
    var image = tmp.slice(-1)[0];
    // var tmp = str.slice("f");
    // console.log(image);
    $(this).siblings('.camera-value').text(image);
});

$('#update_foto_asset').on('change', function() {
    //get the file name
    var fileName = $(this).val();
    //replace the "Choose a file" label
    $(this).next('.custom-file-label').html(fileName);
    if (this.files && this.files[0]) {
        var reader = new FileReader();
        reader.onload = imageIsLoaded;
        reader.readAsDataURL(this.files[0]);
    }
});

function imageIsLoaded(e) {
    $('#display_foto_update').attr('src', e.target.result);
};

$("#icon-camera-update").click(function() {
    $("#update_foto_asset").trigger('click');
});

$('#update_foto_asset').on('change', function() {
    var val = $(this).val();
    var tmp = val.split("\\");
    var image = tmp.slice(-1)[0];
    // var tmp = str.slice("f");
    // console.log(image);
    $(this).siblings('.camera-value').text(image);
});

$(document).on('click', '.update_category', function() {
    var id_category = $(this).attr('id_category');
    $.ajax({
        type: "get",
        url: '/asset/setting-detail-asset-category/' + id_category,
        dataType: 'json',
        success: function(data) {
            console.log(data);
            $('#id_category').val(id_category);
            $('#nama_kategori').val(data.nama_kategori);
        }
    });
});

$(document).on('click', '.updatecategory', function() {
    var id_category = $('#id_category').val();
    var nama_kategori = $('#nama_kategori').val();
    $.ajax({
        url: '/asset/setting-update-asset-category/' + id_category,
        type: 'post',
        data: { nama_kategori: nama_kategori },
        success: function(data) {
            console.log(data);
            window.location = "/asset/setting-page";
        },
        error: function(data) {
            console.log('Error:', data);
        }
    });
});

$(document).on('click', '.update_type', function() {
    var id_type = $(this).attr('id_type');
    $.ajax({
        type: "get",
        url: '/asset/setting-detail-asset-type/' + id_type,
        dataType: 'json',
        success: function(data) {
            console.log(data);
            $('#id_type').val(id_type);
            $('#nama_jenis').val(data.nama_jenis);
        }
    });
});

$(document).on('click', '.updatetype', function() {
    var id_type = $('#id_type').val();
    var nama_jenis = $('#nama_jenis').val();
    $.ajax({
        url: '/asset/setting-update-asset-type/' + id_type,
        type: 'post',
        data: { nama_jenis: nama_jenis },
        success: function(data) {
            console.log(data);
            window.location = "/asset/setting-page";
        },
        error: function(data) {
            console.log('Error:', data);
        }
    });
});

$(document).on('click', '.update_lokasi', function() {
    var id_lokasi = $(this).attr('id_lokasi');
    $.ajax({
        type: "get",
        url: '/asset/setting-detail-asset-lokasi/' + id_lokasi,
        dataType: 'json',
        success: function(data) {
            console.log(data);
            $('#id_lokasi').val(id_lokasi);
            $('#lokasi').val(data.lokasi);
        }
    });
});

$(document).on('click', '.updatelokasi', function() {
    var id_lokasi = $('#id_lokasi').val();
    var lokasi = $('#lokasi').val();
    $.ajax({
        url: '/asset/setting-update-asset-lokasi/' + id_lokasi,
        type: 'post',
        data: { lokasi: lokasi },
        success: function(data) {
            console.log(data);
            window.location = "/asset/setting-page";
        },
        error: function(data) {
            console.log('Error:', data);
        }
    });
});

// detail-asset
$(document).on('click', '#asset_detail', function() {
    var uid_asset = $(this).attr('uid_asset');
    $.ajax({
        type: "get",
        url: '/asset/asset-detail/' + uid_asset,
        dataType: 'json',
        success: function(data) {
            $('.detail-asset').html('');
            console.log(data);
            var image = '';
            if (data.data.thisAsset.asset_image == null) {
                image = '/Images/asset-image/asset.png';
            } else {
                image = data.data.thisAsset.asset_image;
            }
            $('.detail-asset').append('<div class="card mt-3 border border-0"><div class="mx-auto d-block"><img class="rounded-circle p-2" src="' + image + '" alt="" width="180px" height="175px"></div></div><div><label for="" class="mt-3">Nama Asset</label><input type="text" class="form-control form-control-sm bg-white border border-top-0 border-right-0 border-left-0 border-dark" value="' + data.data.thisAsset.nama_asset + '" readonly></div><div class="row mt-3"><div class="col-sm-6"><label for="" class="">Kode Asset</label><input type="text" class="form-control form-control-sm bg-white border border-top-0 border-right-0 border-left-0 border-dark" value="' + data.data.thisAsset.kode_asset + '" readonly></div><div class="col-sm-6"><label for="" class="">Tanggal Terima</label><input type="text" class="form-control form-control-sm bg-white border border-top-0 border-right-0 border-left-0 border-dark" value="' + data.data.thisAsset.tanggal + '" readonly></div></div><div class="row mt-3"><div class="col-sm-6"><label for="" class="">Serial Angka</label><input type="text" class="form-control form-control-sm bg-white border border-top-0 border-right-0 border-left-0 border-dark" value="' + data.data.thisAsset.serial_number + '" readonly></div><div class="col-sm-6"><label for="" class="">Nilai Asset</label><input type="text" class="form-control form-control-sm bg-white border border-top-0 border-right-0 border-left-0 border-dark" value="' + format(data.data.thisAsset.nilai_asset) + '" readonly></div></div><div class="row mt-3"><div class="col-sm-6"><label for="" class="">Garansi (Bulan)</label><input type="text" class="form-control form-control-sm bg-white border border-top-0 border-right-0 border-left-0 border-dark" value="' + data.data.thisAsset.garansi + ' Bulan" readonly></div><div class="col-sm-6"><label for="" class="">Penyusutan/Bulan</label><input type="" id="" class="form-control form-control-sm bg-white border border-top-0 border-right-0 border-left-0 border-dark" value="' + format(data.data.thisAsset.nilai_susutan) + ' / Bulan" readonly></div></div><div class="row mt-3"><div class="col-sm-6"><label for="" class="">Penanggung Jawab</label><input type="" class="form-control form-control-sm bg-white border border-top-0 border-right-0 border-left-0 border-dark" value="' + data.data.thisAsset.penanggung_jawab_asset + '" readonly></div><div class="col-sm-6"><label for="" class="">Nilai Buku</label><input type="" class="form-control form-control-sm bg-white border border-top-0 border-right-0 border-left-0 border-dark" value="' + format(data.data.thisAsset.nilai_buku) + '" readonly></div></div><div><div class="row mt-3"><div class="col-sm-6"><label for="" class="">Jenis Asset</label><input type="" class="form-control form-control-sm bg-white border border-top-0 border-right-0 border-left-0 border-dark" value="' + data.data.thisAsset.jenis_asset + '" readonly></div><div class="col-sm-6"><label for="" class="">Kategori Asset</label><input type="" class="form-control form-control-sm bg-white border border-top-0 border-right-0 border-left-0 border-dark" value="' + data.data.thisAsset.kategori_asset + '" readonly></div></div></div><div class="row mt-3"><div class="col-sm-6"><label for="" class="">Kondisi Awal</label><input type="" class="form-control form-control-sm bg-white border border-top-0 border-right-0 border-left-0 border-dark" value="' + data.data.thisAsset.kondisi_awal + '" readonly></div><div class="col-sm-6"><label for="" class="">Jumlah Asset</label><input type="" class="form-control form-control-sm bg-white border border-top-0 border-right-0 border-left-0 border-dark" value="' + data.data.thisAsset.jumlah_asset + '" readonly></div></div><div class="row mt-3"><div class="col-sm-6"><label for="" class="">Lokasi Asset</label><input type="" class="form-control form-control-sm bg-white border border-top-0 border-right-0 border-left-0 border-dark" value="' + data.data.thisAsset.lokasi_asset + '" readonly></div><div class="col-sm-6"><label for="" class="">Opsi Penyusutan</label><input type="" class="form-control form-control-sm bg-white border border-top-0 border-right-0 border-left-0 border-dark" value="' + data.data.thisAsset.penyusutan + '%" readonly></div></div><div><label for="" class="mt-3">Deskripsi Asset</label><textarea type="text" class="form-control form-control-sm bg-white border border-bottom-0 border-top-0 border-right-0 border-left-0 border-dark">' + data.data.thisAsset.keterangan_asset + '</textarea></div><div class="mt-4 border-top border-bottom border-dark"><div class="h5 my-3 text-center">INFORMASI VENDOR</div></div><div><label for="" class="mt-3">Vendor</label><input type="text" id="" class="form-control form-control-sm" value="' + data.data.thisAsset.nama_vendor + '" readonly></div><div><label for="" class="mt-3">Email</label><input type="text" id="" class="form-control form-control-sm" value="' + data.data.thisAsset.email_vendor + '" readonly></div><div><label for="" class="mt-3">Alamat</label><input type="text" id="" class="form-control form-control-sm" value="' + data.data.thisAsset.alamat_vendor + '" readonly></div><div><label for="" class="mt-3">No Handphone</label><input type="text" id="" class="form-control form-control-sm"value="' + data.data.thisAsset.nohp_vendor + '" readonly></div>');
        }
    });
});

// $(document).on('click', '#asset_update', function() {
//     var uid_asset = $(this).attr('uid_asset');
//     $('#update_uid_asset').val(uid_asset);
//     $.ajax({
//         type: "get",
//         url: '/asset/asset-detail/' + uid_asset,
//         dataType: 'json',
//         success: function(data) {
//             console.log(data);
//             var tmp_pegawai = data.data.employee;
//             var tmp_jenis = data.data.assetType;
//             var tmp_kategori = data.data.assetCategory;
//             var tmp_kondisi_awal = [{ "kondisi_awal": "Baru" }, { "kondisi_awal": "Bekas" }, { "kondisi_awal": "Rusak" }];
//             var tmp_kondisi_sekarang = [{ "kondisi_sekarang": "Rusak" }, { "kondisi_sekarang": "Perbaikan" }, { "kondisi_sekarang": "Terjual" }, { "kondisi_sekarang": "NonAktif" }];
//             var tmp_lokasi_asset = data.data.assetLokasi;
//             var tmp_penyusutan = [{ "persen_penyusutan": 5 }, { "persen_penyusutan": 12.5 }, { "persen_penyusutan": 25 }, { "persen_penyusutan": data.data.thisAsset.penyusutan }];
//             console.log(tmp_penyusutan);

//             $('#update_uid_asset').val(uid_asset);
//             $('#update_uid_pegawai').val(data.data.thisAsset.uid_pegawai);
//             $('.update-foto-asset').html('');
//             $('.update-foto-asset').append('<img class="rounded-circle p-2" src="' + data.data.thisAsset.asset_image + '" alt="" width="180px" height="175px" id="display_foto_update">');
//             $('#update-foto-asset').html('');
//             $('#update_nama_asset').val(data.data.thisAsset.nama_asset);
//             $('#update_kode_asset').val(data.data.thisAsset.kode_asset);
//             $('#update_tanggal_terima').val(data.data.thisAsset.tanggal_terima);
//             $('#update_serial_angka').val(data.data.thisAsset.serial_number);
//             $('#update_nilai_asset').val(data.data.thisAsset.nilai_asset);
//             $('#update_garansi').val(data.data.thisAsset.garansi);
//             $('#update_batas_pemakaian').val(data.data.thisAsset.batas_pemakaian);

//             $('#update_penanggung_jawab').html('');
//             $.each(tmp_pegawai, function(k, v) {
//                 var select = '';
//                 if (v.uid == data.data.thisAsset.penanggung_jawab) {
//                     select = 'selected';
//                 }
//                 $('#update_penanggung_jawab').append('<option value="' + v.uid + '"' + select + '>' + v.nama + '</option>');
//             });

//             $('#update_id_jenis_asset').html('');
//             $.each(tmp_jenis, function(k, v) {
//                 var select = '';
//                 if (v.id == data.data.thisAsset.id_jenis_asset) {
//                     select = 'selected';
//                 }
//                 $('#update_id_jenis_asset').append('<option value="' + v.id + '"' + select + '>' + v.nama_jenis + '</option>');
//             });
//             // $('#update_id_kategori_asset').val(data.data.thisAsset.id_kategori_asset);
//             $('#update_id_kategori_asset').html('');
//             $.each(tmp_kategori, function(k, v) {
//                 var select = '';
//                 if (v.id == data.data.thisAsset.id_kategori_asset) {
//                     select = 'selected';
//                 }
//                 $('#update_id_kategori_asset').append('<option value="' + v.id + '"' + select + '>' + v.nama_kategori + '</option>');
//             });
//             $('#update_kondisi_awal').html('');
//             $.each(tmp_kondisi_awal, function(k, v) {
//                 var select = '';
//                 if (v.kondisi_awal == data.data.thisAsset.kondisi_awal) {
//                     select = 'selected';
//                 }
//                 $('#update_kondisi_awal').append('<option value="' + v.kondisi_awal + '"' + select + '>' + v.kondisi_awal + '</option>');
//             });

//             $('#update_id_lokasi_asset').html('');
//             $.each(tmp_lokasi_asset, function(k, v) {
//                 var select = '';
//                 if (v.id == data.data.thisAsset.id_lokasi_asset) {
//                     select = 'selected';
//                 }
//                 $('#update_id_lokasi_asset').append('<option value="' + v.id + '"' + select + '>' + v.lokasi + '</option>');
//             });

//             $('#update_kondisi_sekarang').html('');
//             $.each(tmp_kondisi_sekarang, function(k, v) {
//                 var select = '';
//                 if (v.kondisi_sekarang == data.data.thisAsset.kondisi_sekarang) {
//                     select = 'selected';
//                 }
//                 $('#update_kondisi_sekarang').append('<option value="' + v.kondisi_sekarang + '"' + select + '>' + v.kondisi_sekarang + '</option>');
//             });

//             $('#update_penyusutan').html('');
//             $.each(tmp_penyusutan, function(k, v) {
//                 var select = '';
//                 if (v.persen_penyusutan == data.data.thisAsset.penyusutan) {
//                     select = 'selected';
//                 }
//                 $('#update_penyusutan').append('<option value="' + v.persen_penyusutan + '"' + select + '>' + v.persen_penyusutan + '</option>');
//             });

//             $('#update_status_asset').val(data.data.thisAsset.status_asset);
//             $("#update_status_asset").prop("");
//             if ($('#update_status_asset').val() == 'Aktif') {
//                 $("#update_status_asset").prop("checked", true);
//             } else {
//                 $("#update_status_asset").prop("checked", false);
//                 $("#update_status_asset").val("Non-Aktif");
//             }

//             $('#form_update_keterangan_asset').html('');
//             $('#form_update_keterangan_asset').append('<label for="" class="mt-3">Deskripsi Asset</label><textarea type="text" id="update_keterangan_asset" class="form-control form-control-sm" name="update_keterangan_asset">' + data.data.thisAsset.keterangan_asset + '</textarea>');
//             $('#update_uid_vendor').val(data.data.thisAsset.uid_vendor);
//             $('#update_nama_vendor').val(data.data.thisAsset.nama_vendor);
//             $('#update_email_vendor').val(data.data.thisAsset.email_vendor);
//             $('#update_alamat_vendor').val(data.data.thisAsset.alamat_vendor);
//             $('#update_nohp_vendor').val(data.data.thisAsset.nohp_vendor);
//         }
//     });
// });

$(document).on('click', '#update_status_asset', function() {
    var uid_asset = $('#update_uid_asset').val();

    if ($(this).parent().find('input[name="status_asset"]').is(':checked')) {
        $('#update_status_asset').val('Aktif');

    } else {
        $('#update_status_asset').val('Non-Aktif');
    }

});

$('.select2AssetwithTags').select2({
    ajax: {
        dataType: 'json',
        data: function(params) {
            this.data('term', params.term);
            return params;
        },
        processResults: function(data) {
            if (data.length)
                return {
                    results: data
                };
            else
                return {
                    results: [{ id: this.$element.data('term'), text: this.$element.data('term') }]
                };
        }
    }
});

// $('#update_form_asset').on('submit', function() {
//     var uid_asset = $('#update_uid_asset').val();
//     var uid_pegawai = $('#update_uid_pegawai').val();
//     var foto_asset = $('#update_foto_asset').val();
//     var nama_asset = $('#update_nama_asset').val();
//     var kode_asset = $('#update_kode_asset').val();
//     var tanggal_terima = $('#update_tanggal_terima').val();
//     var serial_angka = $('#update_serial_angka').val();
//     var nilai_asset = $('#update_nilai_asset').val();
//     var garansi = $('#update_garansi').val();
//     var batas_pemakaian = $('#update_batas_pemakaian').val();
//     var penanggung_jawab = $('#update_penanggung_jawab').val();
//     var id_jenis_asset = $('#update_id_jenis_asset').val();
//     var id_kategori_asset = $('#update_id_kategori_asset').val();
//     var kondisi_awal = $('#update_kondisi_awal').val();
//     var kondisi_sekarang = $('#update_kondisi_sekarang').val();
//     var id_lokasi_asset = $('#update_id_lokasi_asset').val();
//     var penyusutan = $('#update_penyusutan').val();
//     var status_asset = $('#update_status_asset').val();
//     var keterangan_asset = $('#form_update_keterangan_asset').val();
//     var uid_vendor = $('#update_uid_vendor').val();
//     var nama_vendor = $('#update_nama_vendor').val();
//     var email_vendor = $('#update_email_vendor').val();
//     var alamat_vendor = $('#update_alamat_vendor').val();
//     var nohp_vendor = $('#update_nohp_vendor').val();

// var file_data = $('#update_foto_asset').prop('files')[0];
// var form_data = new FormData();
// form_data.append('file', file_data);

// $.ajax({
//     headers: {
//         'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
//     },
//     type: 'POST',
//     url: '/asset/asset-update/' + uid_asset,
//     data: new FormData(this),
//     dataType: 'JSON',
//     cache: false,
//     contentType: false,
//     processData: false,
// data: { uid_asset: uid_asset, uid_pegawai: uid_pegawai, foto_asset: foto_asset, nama_asset: nama_asset, kode_asset: kode_asset, tanggal_terima: tanggal_terima, serial_angka: serial_angka, nilai_asset: nilai_asset, garansi: garansi, batas_pemakaian: batas_pemakaian, penanggung_jawab: penanggung_jawab, id_jenis_asset: id_jenis_asset, id_kategori_asset: id_kategori_asset, kondisi_awal: kondisi_awal, kondisi_sekarang: kondisi_sekarang, id_lokasi_asset: id_lokasi_asset, penyusutan: penyusutan, status_asset: status_asset, keterangan_asset: keterangan_asset, uid_vendor: uid_vendor, nama_vendor: nama_vendor, email_vendor: email_vendor, alamat_vendor: alamat_vendor, nohp_vendor: nohp_vendor },
//         success: function(data) {
//             console.log(data);

//             window.location = "/asset/asset-page";
//         },
//         error: function(data) {
//             console.log('Error:', data);

//         }
//     });

// });


$('#laporan-penyusutan-asset').on('click', function() {
    window.open('/asset/laporan-penyusutan-asset');
});

$(document).on('click', '#update-barang', function() {
    const id_barang = $(this).attr('id_barang');
    $.ajax({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        method: "get",
        url: '/asset/detail-barang/' + id_barang,
        dataType: 'json',
        success: function(data) {
            console.log(data);
            $('#id_barang').val(data.barang.id);
            $('#update_kode_barang').val(data.barang.kode_barang);
            $('#update_nama_barang').val(data.barang.nama_barang);
            $('#update_satuan_barang').val(data.barang.satuan_barang);
            $('#update_saldo_awal').val(data.log.total);
            $('#update_tanggal_awal').val(data.log.tanggal);
            $('#update_jumlah_awal').val(data.log.jumlah_barang);
            $('#update_keterangan').val(data.barang.keterangan);
        },
        error: function(data) {
            console.log('Error: ', data);
        }
    });
});

$(document).on('click', '#submit-update-barang', function() {
    const id = $('#id_barang').val();
    const kode_barang = $('#update_kode_barang').val();
    const nama_barang = $('#update_nama_barang').val();
    const satuan_barang = $('#update_satuan_barang').val();
    const keterangan = $('#update_keterangan').val();
    const jumlah_awal = $('#update_jumlah_awal').val();
    const saldo_awal = $('#update_saldo_awal').val();
    const tanggal_awal = $('#update_tanggal_awal').val();

    $.ajax({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        url: '/asset/update-barang',
        type: "post",
        data: {id: id, kode_barang: kode_barang, nama_barang: nama_barang, satuan_barang: satuan_barang, keterangan: keterangan, jumlah_awal: jumlah_awal, saldo_awal: saldo_awal, tanggal_awal: tanggal_awal },
        success: function(data) {
            window.location = '/asset/permintaan-asset';
        },
        error: function(data) {
            console.log('Error: ', data);
        }
    });
});

$(document).on('click', '#update-pemesanan', function() {
    const id_pemesanan = $(this).attr('id_pemesanan');
    $('#id_pemesanan').val(id_pemesanan);
    $.ajax({
        type: "get",
        url: '/asset/detail-pemesanan/' + id_pemesanan,
        dataType: 'json',
        success: function(data) {
            console.log(data);
            var tmp_pemesanan = data.pemesanan;
            var tmp_pemesan = data.pemesan;
            var tmp_barang = data.barang;

            $('#update_nama_pemesan').html('');
            $.each(tmp_pemesan, function(k, v) {
                var select = '';
                if (v.uid == tmp_pemesanan.nama_pemesan) {
                    select = 'selected';
                }
                $('#update_nama_pemesan').append('<option value="' + v.uid + '"' + select + '>' + v.nama + '</option>');
            });

            $('#update_id_barang').html('');
            $.each(tmp_barang, function(k, v) {
                var select = '';
                if (v.id == tmp_pemesanan.id_barang) {
                    select = 'selected';
                }
                $('#update_id_barang').append('<option value="' + v.id + '"' + select + '>' + v.nama_barang + '</option>');
            });

            $('#update_tanggal_pemesanan').val(tmp_pemesanan.tanggal_pemesanan);
            $('#update_jumlah_permintaan').val(tmp_pemesanan.jumlah_permintaan);
            $('#update_harga_satuan').val(tmp_pemesanan.harga_satuan);
            $('#update_total_harga').val(tmp_pemesanan.total_harga);
            $('#update_keterangan').val(tmp_pemesanan.keterangan);

        },
        error: function(data) {
            console.log('Error: ', data);
        }
    });
});

$(document).on('click', '#submit-update-pemesanan', function() {
    const id = $('#id_pemesanan').val();
    const nama_pemesan = $('#update_nama_pemesan').val();
    const id_barang = $('#update_id_barang').val();
    const tanggal_pemesanan = $('#update_tanggal_pemesanan').val();
    const jumlah_permintaan = $('#update_jumlah_permintaan').val();
    const harga_satuan = $('#update_harga_satuan').val();
    const total_harga = $('#update_total_harga').val();
    const keterangan = $('#update_keterangan').val();

    
    $.ajax({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        url: '/asset/edit-update-pemesanan',
        type: "post",
        data: {id: id, nama_pemesan: nama_pemesan, id_barang: id_barang, tanggal_pemesanan: tanggal_pemesanan, jumlah_permintaan: jumlah_permintaan, harga_satuan: harga_satuan, total_harga: total_harga, keterangan: keterangan },
        success: function(data) {
            // console.log(data);
            window.location = '/asset/pemesanan-asset';
        },
        error: function(data) {
            console.log('Error: ', data);
        }
    });
});

$(function() {
    $('.format-uang').ready(function(e) {
        $(this).val(format($(this).val()));
    });
});

$(function() {
    $(".rupiah").keyup(function(e) {
        $(this).val(formatRupiah($(this).val()));
    });
});
// var rupiah = document.getElementById('rupiah');
// rupiah.addEventListener('keyup', function(e) {
//     // tambahkan 'Rp.' pada saat form di ketik
//     // gunakan fungsi formatRupiah() untuk mengubah angka yang di ketik menjadi format angka
//     rupiah.value = formatRupiah(this.value, 'Rp. ');
// });

/* Fungsi formatRupiah */
function formatRupiah(angka, prefix) {
    var number_string = angka.replace(/[^,\d]/g, '').toString(),
        split = number_string.split(','),
        sisa = split[0].length % 3,
        rupiah = split[0].substr(0, sisa),
        ribuan = split[0].substr(sisa).match(/\d{3}/gi);

    // tambahkan titik jika yang di input sudah menjadi angka ribuan
    if (ribuan) {
        separator = sisa ? '.' : '';
        rupiah += separator + ribuan.join('.');
    }

    rupiah = split[1] != undefined ? rupiah + ',' + split[1] : rupiah;
    return prefix == undefined ? rupiah : (rupiah ? 'Rp. ' + rupiah : '');
}

var format = function(num) {
    var str = num.toString().replace("", ""),
        parts = false,
        output = [],
        i = 1,
        formatted = null;
    if (str.indexOf(".") > 0) {
        parts = str.split(".");
        str = parts[0];
    }
    str = str.split("").reverse();
    for (var j = 0, len = str.length; j < len; j++) {
        if (str[j] != ".") {
            output.push(str[j]);
            if (i % 3 == 0 && j < (len - 1)) {
                output.push(".");
            }
            i++;
        }
    }
    formatted = output.reverse().join("");
    return ("" + formatted + ((parts) ? "." + parts[1].substr(0, 2) : ""));
};

$(document).on('keyup', '#nilai_asset', function() {
    $('#akumulasi_penyusutan').html('');
    var nilaiAsset = $('#nilai_asset').val();
    var tmpAsset = nilaiAsset.split(".");
    var asset = tmpAsset.join();
    asset = asset.replace(/,/g, '');

    const tmpPenyusutan = $('#opsi_penyusutan').val();
    const opsiPenyusutan = tmpPenyusutan / 12;
    const hasil = (opsiPenyusutan / 100) * asset;

    var nilaiPenyusutan = $('#nilai_penyusutan').val(format(hasil.toFixed(0)));

    $('#akumulasi_penyusutan').append('Akumulasi ' + opsiPenyusutan.toFixed(2) + '% : ' + format(hasil.toFixed(0)));
});

$(document).on('change', '#opsi_penyusutan', function() {
    $('#akumulasi_penyusutan').html('');
    var nilaiAsset = $('#nilai_asset').val();
    var tmpAsset = nilaiAsset.split(".");
    var asset = tmpAsset.join();
    asset = asset.replace(/,/g, '');

    const tmpPenyusutan = $('#opsi_penyusutan').val();
    const opsiPenyusutan = tmpPenyusutan / 12;
    const hasil = (opsiPenyusutan / 100) * asset;

    var nilaiPenyusutan = $('#nilai_penyusutan').val(format(hasil.toFixed(0)));

    $('#akumulasi_penyusutan').append('Akumulasi ' + opsiPenyusutan.toFixed(2) + '% : ' + format(hasil.toFixed(0)));
});

$(document).on('click', '#btn_saldo_awal', function() {
    const id_barang = $(this).attr('id_barang');
    console.log("ID Barangs = " + id_barang);
    $('#set_id_barang').val(id_barang);
});