<style>
    @media print {
        .noPrint{
            display:none;
        }
        .print{
            display: block;
            text-align: left !important;
            margin-top: -150px;
        }

        .inRealPreview{
            height: auto !important;
        }
    }
    .inRealPreview{
        height:300px; 
        overflow-y:scroll
    }
    /* @page { size: auto;  margin: 0mm; } */
</style>

<div class="card rian">
    <div class="card-body">
        <div class="row inRealPreview">
            @foreach ($id as $item)
                <div class="col-3 mt-3 text-center">
                    {!! QrCode::size(100)->generate(asset('/api/book-qr/'.$item['id'])); !!} <br>
                    <h3>{{$item['number']}}</h3>
                    <h6>{{$item['title']}}</h6>
                </div>
            @endforeach
        </div>
        <div class="row mt-3">
            <div class="col-12">
                <a href="{{url('books-management/qr-page/'.json_encode($id))}}" target="_blank" class="btn btn-block btn-info">
                    <i class="fa fa-print"></i>
                    Cetak QR
                </a>
            </div>
        </div>
    </div>
</div>

<script>
    window.qrData = @json($id, JSON_PRETTY_PRINT);
</script>