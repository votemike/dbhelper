<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>DB HELPER</title>

    <link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">

    <!-- Fonts -->
    <link href='//fonts.googleapis.com/css?family=Roboto:400,300' rel='stylesheet' type='text/css'>
</head>
<body>

<div class="container-fluid">
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <header class="jumbotron">
                <h1>DB Helper</h1>
                <span>Some helpers to help tidy your DB. Take its advise at your own risk.</span>
            </header>

            <div class="panel panel-default">
                <div class="panel-body">
                    <h1>Database helper!</h1>

                    @foreach($tables as $table)
                        @include('dbhelper::table', ['table' => $table])
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Scripts -->
<script src="//cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.1/js/bootstrap.min.js"></script>
</body>
</html>