<!-- resources/views/emails/password.blade.php -->

Suis ce lien pour réinitialiser ton mot de passe : {{ route('password.reset',$token) }}