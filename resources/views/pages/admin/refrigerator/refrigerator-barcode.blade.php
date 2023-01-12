<!DOCTYPE html>
<html>
    <head>
        <title>{{ config('app.name') . ' - ' . $title }}</title>
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
        <style>
            .qr{text-align:center;margin-top:50px;}
            h4{text-align:center;margin-top:120px;}
        </style>
    </head>
    <body>
        <a class="btn btn-info" id="button" onclick="myfunction()" style="margin-left:20px;margin-top:20px;">print</a>
        <a class="btn btn-warning"  href="{{ route('admin.refrigerator.index') }}" id="back"  style="margin-left:10px;margin-top:20px;">back</a>
        <h4 >{{$refrigerator->refrigerator_name}}</h4>
        <div class="qr">
            {!! BarCodeHelper::generateBarcodePng($refrigerator->barcode) !!}
        </div>
        <script>
            function myfunction()
            {

                $('#button').css('visibility','hidden');
                $('#back').css('visibility','hidden');
                window.print();
            }
        </script>
    </body>
</html>
