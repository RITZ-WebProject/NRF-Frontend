<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <script>
		let url = "{{ $redirect_url }}";
		let result_url = url.replace(/&amp;/g, "&");
        top.location.href = result_url;
    </script>
</body>
</html>