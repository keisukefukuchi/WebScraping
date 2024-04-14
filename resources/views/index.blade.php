<!-- index.blade.php -->

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>飲食店舗 スクレイピング</title>
</head>
<body>
    <h1>飲食店舗 スクレイピング</h1>
    <table>
        <tr>
            <th>店舗名</th>
            <th>店舗URL</th>
        </tr>
        @foreach ($store_infos as $store_info)
            <tr>
                <td>{{$store_info['name']}}</td>
                <td>
                    <a href="{{$store_info['link']}}">{{$store_info['link']}}</a>
                </td>
            </tr>
        @endforeach
    </table>
</body>
</html>
