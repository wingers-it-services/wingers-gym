<form method="POST" action="{{ route('gym.reset-password') }}">
    @csrf
    <input type="hidden" name="email" value="{{ $email }}">

    <label for="password">New Password</label>
    <input type="password" name="password" id="password" required>

    <label for="password_confirmation">Confirm Password</label>
    <input type="password" name="password_confirmation" id="password_confirmation" required>

    <button type="submit">Reset Password</button>
</form>
