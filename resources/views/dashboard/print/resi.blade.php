<!DOCTYPE html>
<html lang="en">

<head>
    @include('dashboard.layouts.head')
    <style>
        @page{
            size:auto;
            margin:0mm;
        }
        body{
            width: 210mm;
            height: 148mm;
            margin: 0mm;
        }
        .content{
            width: 210mm;
            min-height: 148mm;
            overflow: auto;
        }

        html{
            padding: 0mm;
            width: 210mm;
            height: 148mm;
            margin: 0mm;
        }
        img{
            width: 4cm;
            margin-bottom: 1cm;
        }
    </style>
</head>

<body>
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-3">
                                <img src="{{ asset('dashboard/img/logo-axcelia.PNG')}}" alt="" class="img-fluid">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <h2 class="font-weight-bold">Dari :</h2>
                                <p>asdasd</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="{{ asset('dashboard')}}/js/app.js"></script>
    <script>
        $(document).ready(function () {
            window.print();
        });
    </script>
</body>

</html>
