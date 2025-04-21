<form id="registerForm">
    @csrf
    <input type="text" name="name" placeholder="Nama" required>
    <input type="email" name="email" placeholder="Email" required>
    <input type="password" name="password" placeholder="Password" required>
    <input type="password" name="password_confirmation" placeholder="Konfirmasi Password" required>
    <button type="submit">Daftar</button>
</form>
