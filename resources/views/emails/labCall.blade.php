<!DOCTYPE html>
<html>
<head>
    <title>Aversi Clinic Laboratory</title>
</head>
<body>
    <p><strong>სახელი: </strong>{!! $details['name'] !!}</p>
    <p><strong>ელ-ფოსტა: </strong> {{ $details['email'] }}</p>
    <p><strong>ტელეფონი: </strong> {{ $details['phone'] }}</p>
    <p><strong>მისამართი: </strong> {{ $details['address'] }}</p>
</body>
</html>