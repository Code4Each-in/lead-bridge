<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Lead Update</title>
</head>
<body style="font-family: Arial; background:#f4f4f4; padding:20px;">

    <div style="background:#fff; padding:20px; border-radius:8px;">
        <h2>{{ $title }}</h2>

        <p>{{ $messageText }}</p>

        <hr>

 
        @if(isset($count))
            <p>
                <strong>Total Leads Assigned:</strong> {{ $count }}
            </p>
        @endif


        @if($lead)
            <p><strong>Lead Name:</strong> {{ $lead->name }}</p>
            <p><strong>Email:</strong> {{ $lead->email }}</p>
            <p><strong>Phone:</strong> {{ $lead->phone }}</p>

            <br>

            <p style="font-size:12px; color:#888;">
                You can view your lead here:
            </p>

            <a href="{{ url('/leads/'.$lead->id) }}"
               style="background:#007bff; color:#fff; padding:10px 15px; text-decoration:none; border-radius:5px;">
               View Lead
            </a>
        @endif

    </div>

</body>
</html>
