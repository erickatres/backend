<!DOCTYPE html>
<html>
<head>
    <title>Appointment Notification</title>
</head>
<body>
    <h1>Appointment {{ $status }}</h1>

    <h2>Client Information</h2>
    <ul>
        <li><strong>First Name:</strong> {{ $appointment['first_name'] }}</li>
        <li><strong>Last Name:</strong> {{ $appointment['last_name'] }}</li>
        <li><strong>Phone:</strong> {{ $appointment['phone'] }}</li>
        <li><strong>Email:</strong> {{ $appointment['email'] }}</li>
        <li><strong>Address:</strong> {{ $appointment['address'] }}</li>
    </ul>

    <h2>Pet Information</h2>
    <ul>
        <li><strong>Pet's Name:</strong> {{ $appointment['furbabys_name'] }}</li>
        <li><strong>Pet Type:</strong> {{ $appointment['pet_type'] }}</li>
    </ul>

    <h2>Appointment Details</h2>
    <ul>
        <li><strong>Appointment Date:</strong> {{ $appointment['appointment_date'] }}</li>
        <li><strong>Appointment Time:</strong> {{ $appointment['appointment_time'] }}</li>
        <li><strong>Service Type:</strong> {{ $appointment['service_type'] }}</li>
        <li><strong>Chosen Service:</strong> {{ $appointment['chosen_service'] }}</li>
        <li><strong>Additional Details:</strong> {{ $appointment['additional_details'] }}</li>
    </ul>

    <p>Thank you,</p>
    <p>{{ config('app.name') }}</p>
</body>
</html>
