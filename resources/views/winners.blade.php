<!DOCTYPE html>
<html class="no-js" lang="en">
    <head>
        <meta charset="utf-8" />
        <title>Thor Winners</title>
        <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.0/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-9gVQ4dYFwwWSjIDZnLEWnxCjeSWFphJiwGPXr1jddIhOegiu1FwO5qRGvFXOdJZ4" crossorigin="anonymous">
    </head>
    <body>
        <h1>Thor Winners</h1>
        <table>
            <tr>
                <th></th>
                <th>Total</th>
                <th>Winners</th>
                <th>Last winner at</th>
            </tr>
            <tr>
                <th>NL</th>
                <td>{{ $total_nl }}</td>
                <td>{{ $winners_nl }}</td>
                <td>{{ $last_winner_at_nl }}</td>
            </tr>
            <tr>
                <th>FR</th>
                <td>{{ $total_fr }}</td>
                <td>{{ $winners_fr }}</td>
                <td>{{ $last_winner_at_fr }}</td>
            </tr>
        </table>
        <table>
            <tr>
                <th>#</th>
                <th>Name</th>
                <th>Comment</th>
                <th>Post</th>
                <th>Date</th>
            </tr>
            @foreach($winners as $i=>$winner)
                <tr>
                    <td>{{ $i+1 }}</td>
                    <td><a href="{{ $winner['user_id'] }}">{{ $winner['user_name'] }}</a></td>
                    <td><a href="{{ $winner['comment_id'] }}">{{ $winner['message'] }}</a></td>
                    <td><a href="{{ $winner['post_id'] }}">{{ $winner['post'] }}</a></td>
                    <td>{{ $winner['created_at'] }}</td>
                </tr>
            @endforeach
        </table>
        <style>
            h1 {
                text-align: center;
                margin-top: 10px;
            }
            table {
                border-collapse: collapse;
                text-align: center;
                width: 500px;
                margin: 0 auto 20px auto;
            }
            td, th {
                border: 1px solid #d3d3d3;
                padding: 5px;
            }
        </style>
    </body>
</html>