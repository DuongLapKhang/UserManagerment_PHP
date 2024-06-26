<?php
if (!defined('_CODE')) {
    die ('Access denied...');
}
$data = [
    'pageTitle' => 'Đăng nhập',
];
insertLayout('header', $data);

// Mật khẩu người dùng nhập
// echo $pass = '123456';
// echo '<br>';
// Mật khẩu đã hash
// echo $passwordHash = password_hash($pass, PASSWORD_DEFAULT);
// echo '<br>';
// Kiểm tra mật khẩu người dùng nhập có khớp với mật khẩu hash đã lưu trên csdl 
// $checkPass = password_verify($pass, $passwordHash);
// var_dump($checkPass);
// echo '<br>';

?>


<div class="row">
    <div class="col-4" style="margin: 50px auto">
        <h2 class="text-center text-uppercase">Đăng nhập</h2>
        <form action="" method="POST">
            <div class="form-group mg-form">
                <label for="email">Email</label>
                <input name="email" type="email" class="form-control" placeholder="Địa chỉ email">
            </div>

            <div class="form-group mg-form">
                <label for="password">Mật khẩu</label>
                <input name="password" type="password" class="form-control" placeholder="Mật khẩu">
            </div>

            <button type="submit" class="btn btn-primary btn-block mg-btn">Đăng nhập</button>
            <hr>
            <p class="text-center"><a href="?module=auth&action=forgot">Quên mật khẩu</a></p>
            <p class="text-center"><a href="?module=auth&action=register">Đăng ký</a></p>
        </form>
    </div>
</div>

<?php
insertLayout('footer');
?>