<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contact Us Message</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            background-color: #f4f4f4;
            color: #333;
            margin: 0;
            padding: 20px;
        }

        .container {
            max-width: 600px;
            margin: 0 auto;
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        h1 {
            color: blue;
        }

        p {
            margin-bottom: 20px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        th, td {
            padding: 12px;
            border: 1px solid #ddd;
            text-align: left;
        }

        th {
            background-color: blue;
            color: #fff;
        }
    </style>
</head>
<body>

<div class="container">
    <h1>Customer Suggestion Message</h1>
    <p>Dear NRF,</p>
    
    <p>You have received a new message from the contact form. Here are the details:</p>

    <table>
        <tr>
            <th>Name</th>
            <td>{{ $data['name'] }}</td>
        </tr>
        <tr>
            <th>Email</th>
            <td>{{ $data['email'] }}</td>
        </tr>
        <tr>
            <th>Subject</th>
            <td>{{ $data['subject'] }}</td>
        </tr>
        <tr>
            <th>Message</th>
            <td>{{ $data['message'] }}</td>
        </tr>
    </table>

    <p>Thank you!</p>
</div>

</body>
</html>
