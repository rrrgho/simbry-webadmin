let user_number;
let book_number = $('#book_number').val();
let data_book;
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
$('#btn-check-book').click(function(){
    $.ajax({
        url: $('#route-check-book').val(),
        type: "POST",
        headers: {'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content')},
        data: {
            data_book : $('#data_book_check').val()
        },
        success:function(response){
            if(response.error == false){
                $.each(response.data,function(i,item){
                    var newOption = new Option((response.data[i].name + " - "+ response.data[i].book_number), response.data[i].book_number, false, false);
                    $('#book_number').append(newOption).trigger('change');
                })
            }else{
                var newOption = new Option("Buku Tidak ada !!",null, false, false);
                    $('#book_number').append(newOption).trigger('change');
            }
        }
    })
})
$('#book_number').on('change',function(){
    book_number = this.value
})
$('#form-pinjam-buku').submit(function(event){
    event.preventDefault()
    var formData = new FormData(this)
    formData.append('user_id', user_number)
    formData.append('book_number', book_number)
    $.ajax({
        url: $('#route-pinjam').val(),
        type: 'POST', cache: false, contentType: false, processData: false,
        data: formData,
        success:function(response){
            if(response.error == false){
                swal("Good job!", response.message, "success");
                setTimeout(() => {
                    location.reload()
                },500)
            }else{
                swal({
                    title: "Maaf??",
                    text: response.message,
                    icon: "warning",
                    buttons: true,
                    dangerMode: true,
                })
            }
        }
    })
})
// $('.livesearchBuku').select2({
//     placeholder: 'Pilih Buku',
//     ajax: {
//         url: 'new-order',
//         dataType: 'json',
//         delay: 250,
//         processResults: function (data) {
//             return {
//                 results: $.map(data, function (item) {
//                     return {
//                         text: item.name,
//                         id: item.id
//                     }
//                 })
//             };
//         },
//         cache: true
//     }
// });
$( function() {
    $( "#datepicker" ).datepicker();
  } );
