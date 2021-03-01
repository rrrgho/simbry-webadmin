let user_number;
let book_id;
$('#btn-check-user').click(function(){
    $.ajax({
        url: $('#route-check').val(),
        type: "POST",
        headers: {'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content')},
        data: {
            user_number : $('#user_number_check').val()
        },
        success:function(response){
            if(response.error == false){
                user_number = response.data.id
                $('#user-found').removeClass('d-none').removeClass('alert-danger').html(' <i class="fa text-white fa-check mr-2"> </i> Data ditemukan <b> " '+ response.data.name +' "</b>')
                $('#btn-pinjam').attr('disabled',false);
            }else{
                $('#user-found').removeClass('d-none').addClass('alert-danger').html('<i class="fa text-white fa-times mr-2"> </i> Data tidak ditemukan dengan Nomor pengguna' + $('#user_number_check').val())
                $('#btn-pinjam').attr('disabled',true);
            }
        }
    })
})

$('#form-pinjam-buku').submit(function(event){
    event.preventDefault()
    var formData = new FormData(this)
    formData.append('user_id', user_number)
    $.ajax({
        url: $('#route-pinjam').val(),
        type: 'POST', cache: false, contentType: false, processData: false,
        data: formData,
        success:function(response){
            console.log(response)
        }
    })
})
$('.livesearchBuku').select2({
    placeholder: 'Pilih Buku',
    ajax: {
        url: 'new-order',
        dataType: 'json',
        delay: 250,
        processResults: function (data) {
            return {
                results: $.map(data, function (item) {
                    return {
                        text: item.name,
                        id: item.id
                    }
                })
            };
        },
        cache: true
    }
});
$( function() {
    $( "#datepicker" ).datepicker();
  } );