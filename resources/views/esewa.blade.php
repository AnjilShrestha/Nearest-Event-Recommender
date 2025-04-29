<!DOCTYPE html>
<html>
<head>
    <title>eSewa Payment</title>
</head>
<body>
    <h3>Redirecting to eSewa...</h3>
    <form id="esewaForm" action="{{ env('ESEWA_PAYMENT_URL') }}" method="POST">
        @foreach ($data as $key => $value)
            <input type="hidden" name="{{ $key }}" value="{{ $value }}">
        @endforeach
        <button type="submit">Pay with eSewa</button>
    </form>

    <script>
        document.getElementById('esewaForm').submit();
    </script>
</body>
</html>
