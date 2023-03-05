<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" integrity="sha384-JcKb8q3iqJ61gNV9KGb8thSsNjpSL0n8PARn9HuZOnIxN0hoP+VmmDGMN5t9UJ0Z" crossorigin="anonymous">
    <title>Parsing</title>
    <style>
        .block{
            display: flex;
        }
        .block1{
            float: left;
            display: block;
            width: 49%;
        }  
        .block2{
            float: right;
            display: block;
            width: 49%;
            margin-left: 2px;
        }  
        .mx{
            float: inline-end;
        }
    </style>
</head>
<body>


<nav class="navbar navbar-expand-lg navbar-dark bg-dark mb-3">
    <a class="navbar-brand" href="{{ route('home') }}">Parsing</a>
</nav>

<div class="container">

    <div class="row">

        <div class="col-md-12">

            <form  method="get" action="{{route('search')}}">
                <div class="form-row">
                    <div class="form-group col-md-10">
                        <input type="text" class="form-control" id="s" name="s" placeholder="Search...">
                    </div>
                    <div class="form-group col-md-2">
                        <button type="submit" class="btn btn-primary btn-block">Search</button>
                    </div>
                </div>

            </form>

        </div><!-- ./col-md-12-->

    </div><!-- ./row-->

    <div class="row mt-3 mb-3">
        <div class="col-md-12">

            @yield('content')

        </div><!-- ./col-md-12-->

    </div><!-- ./row-->

</div><!-- ./container-->


</body>
</html>
