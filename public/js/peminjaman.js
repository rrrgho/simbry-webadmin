let user_id;
let book_number = $('#book_number_order').val();
let data_book;
let data_user;
// $('#btn-check-user').click(function(){
//     $.ajax({
//         url: $('#route-check').val(),
//         type: "POST",
//         headers: {'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content')},
//         data: {
//             user_number : $('#user_number_check').val()
//         },
//         success:function(response){
//             if(response.error == false){
//                 user_number = response.data.id
//                 $('#user-found').removeClass('d-none').removeClass('alert-danger').html(' <i class="fa text-white fa-check mr-2"> </i> Data ditemukan <b> " '+ response.data.name +' "</b>')
//                 $('#btn-pinjam').attr('disabled',false);
//             }else{
//                 $('#user-found').removeClass('d-none').addClass('alert-danger').html('<i class="fa text-white fa-times mr-2"> </i> Data tidak ditemukan dengan Nomor pengguna' + $('#user_number_check').val())
//                 $('#btn-pinjam').attr('disabled',true);
//             }
//         }
//     })
// })
$('#btn-check-user').click(function(){
    $.ajax({
        url: $('#route-check').val(),
        type: "POST",
        headers: {'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content')},
        data: {
            data_user : $('#user_number_check').val()
        },
        success:function(response){
            console.log(response)
            let html = '';
            if(response.error == false){
                html += `<option value="">Pilih Siswa/Guru</option>`;
                $.each(response.data,function(i,item){
                    html += `<option value="${response.data[i].id}">${response.data[i].name}</option>`
                })
                $('#user_id').html(html)
                $('#btn-pinjam').attr('disabled',false);
            }else{
                html += `<option value="">Siswa Tidak ada !!</option>`;
                $('#user_id').html(html)
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
            let html = '';
            if(response.error == false){
                html += `<option value="">Pilih Buku</option>`;
                $.each(response.data,function(i,item){
                    html += `<option value="${response.data[i].id}">${response.data[i].name} - ${response.data[i].book_number}</option>`
                })
                $('#book_number_order').html(html)
            }else{
                html += `<option value="">Buku Tidak ada !!</option>`;
                $('#book_number_order').html(html)
            }
        }
    })
})
$('#user_id').on('change',function(){
    user_id = this.value
    // alert(user_id)
})
$('#book_number').on('change',function(){
    book_number = this.value
})
$('#form-pinjam-buku').submit(function(event){
    event.preventDefault()
    var formData = new FormData(this)
    formData.append('user_id', user_id)
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
