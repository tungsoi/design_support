<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>

<div>
    <div>
        <img src="{{ public_path().'/assets/img/logo-design.png' }}" alt="">
    </div>
    <div style="float: right">
        <p>CÔNG TY TNHH PHÁT TRIỂN THƯƠNG MẠI DỊCH VỤ LONG HẢI</p>
        <p>Địa chỉ : 521 Minh Khai Phường Vĩnh Tuy Quận Hai Bà Trưng TP Hà Nội</p>
        <p>Mst      : 0109534169  -  SĐT 0703552222   -   Web: supportdesign.vn   -   Email</p>
    </div>
</div>
<br>
<h4>THÔNG TIN SẢN PHẨM</h4>
<br>
<div>
    <table>
        <tr>
            <th>STT</th>
            <th>TÊN SẢN PHẨM</th>
            <th>CHẤT LIỆU</th>
            <th>KÍCH THƯỚC</th>VND
            <th>GIÁ SẢN PHẨM</th>
            <th>ĐVT</th>
            <th>SL</th>
            <th>THÀNH TIỀN()</th>
        </tr>
        @foreach($products as $key => $item)
            <tr>
                <td>{{ $key  }}</td>
                <td></td>
                <td></td>
                <td></td>
                <td>{{$item->price}}</td>
                <td>{{$item->quality}}</td>
                <td>{{$item->quality}}</td>
                <td>{{$item->quality}}</td>
                <td>{{$item->quality}}</td>
            </tr>
        @endforeach
    </table>
</div>

</body>
</html>
