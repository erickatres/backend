<!DOCTYPE html>
<html>
<head>
    <title>Appointment Confirmation</title>
</head>
<body>
    <h1>Appointment Confirmation</h1>
    <p>Dear {{ $appointment['client_name'] }},</p>
    <p>Your appointment has been successfully booked!</p>
    <ul>
        <li><strong>Phone:</strong> {{ $appointment['phone'] }}</li>
        <li><strong>Email:</strong> {{ $appointment['email'] }}</li>
        <li><strong>Address:</strong> {{ $appointment['address'] }}</li>
        <li><strong>Furbaby's Name:</strong> {{ $appointment['furbabys_name'] }}</li>
        <li><strong>Pet Type:</strong> {{ $appointment['pet_type'] }}</li>
        <li><strong>Date:</strong> {{ $appointment['appointment_date'] }}</li>
        <li><strong>Time:</strong> {{ $appointment['appointment_time'] }}</li>
        <li><strong>Service Type:</strong> {{ $appointment['service_type'] }}</li>
        <li><strong>Chosen Service:</strong> {{ $appointment['chosen_service'] }}</li>
        <li><strong>Additional Details:</strong> {{ $appointment['additional_details'] }}</li>
    </ul>
    <p>Thank you for choosing us!</p>
</body>
</html>
