<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pet Boarding Appointment Confirmation</title>
</head>
<body>
    <h1>Pet Boarding Appointment Confirmation</h1>
    <p>Dear {{ $petBoarding['first_name'] }} {{ $petBoarding['last_name'] }},</p>
    <p>Your pet boarding appointment has been successfully booked!</p>
    <ul>
        <li><strong>Phone:</strong> {{ $petBoarding['phone'] }}</li>
        <li><strong>Email:</strong> {{ $petBoarding['email'] }}</li>
        <li><strong>Address:</strong> {{ $petBoarding['address'] }}</li>
        <li><strong>Furbaby's Name:</strong> {{ $petBoarding['furbabys_name'] }}</li>
        <li><strong>Pet Type:</strong> {{ $petBoarding['pet_type'] }}</li>
        <li><strong>Check-In:</strong> {{ $petBoarding['pet_check_in'] }}</li>
        <li><strong>Check-In Date:</strong> {{ \Carbon\Carbon::parse($petBoarding['check_in_date'])->format('F j, Y') }}</li>
        <li><strong>Check-In Time:</strong> {{ $petBoarding['check_in_time'] }}</li>
        <li><strong>Days:</strong> {{ $petBoarding['days'] }}</li>
        <li><strong>Hours:</strong> {{ $petBoarding['hours'] }}</li>
        <li><strong>Additional Details:</strong> {{ $petBoarding['additional_details'] }}</li>
    </ul>
    <p>Thank you for choosing us for your pet's care!</p>
</body>
</html>
