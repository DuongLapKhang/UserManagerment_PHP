<?php
if (!defined('_CODE')) {
    die ('Access denied...');
}
$data = [
    'pageTitle' => 'Đăng ký',
];
insertLayout('header', $data);
?>

<div class="row">
    <div class="col-4" style="margin: 50px auto">
        <h2 class="text-center text-uppercase">Đăng ký</h2>
        <form action="" method="post">
            <div class="form-group mg-form">
                <label for="fullname">Họ và tên</label>
                <input name="fullname" type="text" class="form-control" placeholder="Họ và tên">
            </div>

            <div class="form-group mg-form">
                <label for="email">Email</label>
                <input name="email" type="email" class="form-control" placeholder="Địa chỉ email">
            </div>

            <div class="form-group mg-form">
                <label for="phone">Số điện thoại</label>
                <input name="phone" type="text" class="form-control" placeholder="Địa chỉ email">
            </div>

            <div class="form-group mg-form">
                <label for="password">Mật khẩu</label>
                <input name="password" type="password" class="form-control" placeholder="Mật khẩu">
            </div>

            <div class="form-group mg-form">
                <label for="password">Nhập lại mật khẩu</label>
                <input name="password" type="password" class="form-control" placeholder="Nhập lại mật khẩu">
            </div>

            <button type="submit" class="btn btn-primary btn-block mg-btn">Đăng ký</button>
            <hr>
            <p class="text-center"><a href="?module=auth&action=login">Đã có tài khoản? Đăng nhập</a></p>
        </form>
    </div>
</div>

<?php
insertLayout('footer');
?>