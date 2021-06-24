<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">


    <title>Print QR !</title>
    <style>
        @media print {
            .pagebreak {
                page-break-before: always;
            }
            .row{
                width: 100%;
            }
            .col{
                width: 10%;
                height: 150px;
                float: left;
                text-align: center;
            }
        }

        .row{
            width: 100%;
        }
        .col{
            width: 15%;
            float: left;
            text-align: center;
        }
    </style>
  </head>
  <body>
    <div class="row" >
        @foreach ($data as $item)
            <div class="col" >
                {!! QrCode::size(70)->generate(asset('/api/book-qr/'.$item['id'])); !!} <br>
                <h6>{{$item['number']}}</h6>
            </div>
        @endforeach
    </div>
  </body>
</html>

<script>
    window.print()
</script>