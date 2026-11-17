<x-guest-layout>
    @if (session('status'))
        <div class="status">{{ session('status') }}</div>
    @endif

    <form method="POST" action="{{ route('login') }}">
        @csrf

        <label for="email">Email</label>
        <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus>
        @error('email')
            <div class="error">{{ $message }}</div>
        @enderror

        <label for="password">Password</label>
        <input id="password" type="password" name="password" required>
        @error('password')
            <div class="error">{{ $message }}</div>
        @enderror

        <label class="remember">
            <input type="checkbox" name="remember"> Ingat saya
        </label>

        <button type="submit">Masuk</button>
    </form>
</x-guest-layout>