<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->
    {{-- <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-+0n0xVW2eSR5OomGNYDnhzAbDsOXxcvSN1TPprVMTNDbiYZCxYbOOl7+AMvyTG2x" crossorigin="anonymous"> --}}

    <title>Print QR !</title>
    <style>
        @media print {
            .pagebreak {
                clear: both;
                page-break-before: always !important;
            }
        }

        .row{
            width: 100%;
        }
        .col{
            width: 30%;
            float: left;
            text-align: center;
        }
    </style>
  </head>
  <body>
    <div class="row" >
        <?php $break = 0; ?>
        @foreach ($data as $item)
            <div class="col @if($break % 6 === 0) pagebreak @endif" >
                {!! QrCode::size(200)->generate(asset('/api/book-qr/'.$item['id'])); !!} <br>
                <h3>{{$item['number']}}</h3>
                <h6>{{$item['title']}}</h6>
            </div>
            <?php $break++; ?>
        @endforeach
    </div>
  </body>
</html>

<script>
    window.print()
</script>