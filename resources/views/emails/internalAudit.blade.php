<!DOCTYPE html>
<html>
<head>
    <title>Aversi Clinic Internal Audit</title>
</head>
<body>
    <p><strong>სახელი, გვარი: </strong>{{ $details['name'] }}</p>
    <p><strong>შეტყობინების წარმდგენი: </strong> {{ $details['presenter'] }}</p>
    <p><strong>ტელეფონი: </strong> {{ $details['phone'] }}</p>
    <p><strong>ელ-ფოსტა: </strong> {{ $details['email'] }}</p><p></p>
    <p><strong>შეტყობინება: </strong><br> {{ $details['message'] }}</p>
</body>
</html>