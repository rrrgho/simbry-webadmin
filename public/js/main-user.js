function loader(status){
    if(status == true){
        $('.preloader').delay(500).fadeIn(500);
    }else{
        $('.preloader').delay(500).fadeOut(500);
    }
}

let baseUrl = $('#base_url').val()
let pageBookShow = 1;
let inSearch = false;



const sectionShowHide = (section,status) => {
    if(status == 'hide')
        $('#'+section).addClass('d-none')
    else
        $('#'+section).removeClass('d-none')
}
const hideAllComponent = (except) => {
    let component = [$('#order'),$('#content')];
    component.map((item, index) => {
        item.addClass('d-none')
    })
    $(except).removeClass('d-none')
}


const orderBook = (user, examplar) => {
    var formData = new FormData()
    formData.append('id', user)
    formData.append('examplar', examplar)
    $.ajax({
        url: baseUrl + '/order-book',
        headers: {'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content')},
        type: 'POST', cache: false, contentType: false, processData: false,
        data: formData,
        success: function(response){
            sectionShowHide('content','hide')
            sectionShowHide('order','show')
        }
    })
}

const bookComponent = (page, cari = false, ) => {
    var formData = new FormData()
    formData.append('judul', cari)
    $.ajax({
        url: baseUrl+ '/show-book-component?page='+page,
        headers: {'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content')},
        type: 'POST', cache: false, contentType: false, processData: false,
        data: cari != false ? formData : ' ',
        success:function(response){
            if(cari == false && inSearch != true){
                $('#buku').append(response)
                $('#load-more-book').removeClass('d-none')
            }
            else{
                pageBookShow = 1;
                $('#load-more-book').addClass('d-none')
                $('#buku').html(response)
                inSearch = true
            }
            pageBookShow++
        }
    })
}

const orderComponent = () => {
    $.ajax({
        url: baseUrl+ '/show-order-component',
        success:function(response){
            $('#order').html(response)
        }
    })
}
orderComponent()

bookComponent(pageBookShow)
$('#load-more-book').click(function(){
    bookComponent(pageBookShow)
})
$('#btn-cari-buku').click(function(){
    let cari = $('#cari-buku').val()
    bookComponent(1, cari)
})


$('#home').click(function(){
    hideAllComponent('#content')
})
$('#peminjaman').click(function(){
    orderComponent()
    hideAllComponent('#order')
})