<h2>Set up Google Authenticator</h2>
<p>Scan the QR code below using the Google Authenticator app:</p>
<img src="{{ $QRImageUrl }}" alt="QR Code">

<p>Alternatively, enter this code manually: {{ $secretKey }}</p>

<form method="POST" action="{{ route('gym.otp.verify') }}">
    @csrf
    <div class="form-group">
        <label for="otp">Enter OTP</label>
        <input type="text" name="otp" id="otp" class="form-control" required>
    </div>
    <button type="submit" class="btn btn-primary">Verify OTP</button>
</form>
