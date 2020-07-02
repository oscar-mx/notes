<?php
trait Login{
    public function login(){
        echo '登录...'.PHP_EOL;
    }
}
trait Register{
    public function register(){
        echo '注册...'.PHP_EOL;
    }
}

class Auth{
    use Login, Register;
    public function authentication(){
        echo 'success'.PHP_EOL;
    }
}
$a = new Auth();
$a->register();
$a->login();
$a->authentication();