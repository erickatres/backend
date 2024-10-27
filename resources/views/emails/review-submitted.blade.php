
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>New Review Submitted</title>
</head>
<body>
    <h1>New Review Submitted</h1>
    <p>Rating: {{ $review->rating }}</p>
    <p>Comments: {{ $review->comments }}</p>
    <p>This review was submitted on: {{ $review->created_at }}</p>
</body>
</html>

