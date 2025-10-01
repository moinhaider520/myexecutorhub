<!DOCTYPE html>
<html>

<head>
    <title>Document Successfully Stored</title>
</head>

<body>
    <p>Hi {{ $data['first_name'] }},</p>

    <p>Great job! You’ve successfully uploaded your <strong>{{ $data['document_name'] }}</strong> to Executor Hub.
        Taking this step ensures your important documents are secure and accessible when needed.</p>

    <p>🔍 <strong>What’s next?</strong></p>
    <ul>
        <li>✅ Check that all key documents are uploaded.</li>
        <li>✅ Review them regularly to keep them up to date.</li>
        <li>✅ Ensure your executors and advisers have the access they need.</li>
    </ul>

    <p>We’re here to make estate planning simple and stress-free. If you have any questions, we’re happy to help.</p>

    <p>📂 <a href="{{route('login')}}" style="color: #007bff; text-decoration: none;">Review your documents now</a></p>

    <p>Best,</p>
    <p><strong>Executor Hub Team</strong></p>

    <br /><br />
    <p><b>Executor Hub Team</b></p>
    <p><b>Executor Hub Ltd</b></p>
    <p><b>Empowering Executors, Ensuring Legacies</b></p>
    <p><b>Email: hello@executorhub.co.uk</b></p>
    <p><b>Website: https://executorhub.co.uk</b></p>
    <p><b>ICO Registration: ZB932381</b></p>
    <p><b>This email and any attachments are confidential and intended solely for the recipient.</b></p>
    <p><b>If you are not the intended recipient, please delete it and notify the sender.</b></p>
    <p><b>Executor Hub Ltd accepts no liability for any errors or omissions in this message.</b></p>
</body>

</html>