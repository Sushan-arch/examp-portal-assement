<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>Questionnaire Invitation Mail</title>
</head>

<body>
    <p>Hello {{ $studentName }},</p>

    <p>You've been invited to answer the questionnaire!</p>

    <p>Please click the following link to accept the invitation:</p>

    <a href="{{ $uniqueGeneratedUrl }}">Accept Invitation</a>

    <p>If you did not request this invitation or believe this is in error, please ignore this email.</p>

    <p>Thank you,</p>

</body>

</html>