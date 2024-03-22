<?php
if (!defined('_CODE')) {
    die ('Access denied...');
}
$data = [
    'pageTitle' => 'Đăng ký'
];

if (isPost()) {
    $filter = filter();
    $errors = []; // mảng chứa các lỗi

    // Validate username: không được để trống, ít nhất 5 ký tự, họ tên không thể chứa số
    if (empty ($filter['username'])) {
        $errors['username']['require'] = 'Họ tên không được để trống !!';
    } elseif (strlen($filter['username']) < 5) {
        $errors['username']['minlength'] = 'Họ tên phải có ít nhất 5 kí tự !!';
    } elseif (containsNumber($filter['username'])) {
        $errors['username']['notnumber'] = 'Họ tên không được chứa số !!';
    }

    // Validate email: không được để trống, đúng định dạng, chưa tồn tại trong CSDL
    $email = $filter['email'];
    if (empty ($email)) {
        $errors['email']['require'] = 'Email không được để trống !!';
    } elseif (!isEmail($email)) {
        $errors['email']['invalid'] = 'Email không hợp lệ !!';
    } else {
        $sql = "select * from user where email = '$email'";
        if (countRow($sql) > 0) {
            $errors['email']['unique'] = 'Email đã được sử dụng !!';
        }
    }

    // Validate phone: không được để trống, đúng định dạng, chưa tồn tại trong CSDL
    $phone = $filter['phone'];
    if (empty ($phone)) {
        $errors['phone']['require'] = 'Số điện thoại không được để trống !!';
    } elseif (!isPhone($phone)) {
        $errors['phone']['invalid'] = 'Số điện thoại không hợp lệ !!';
    } else {
        $sql = "select * from user where phone = '$phone'";
        if (countRow($sql) > 3) {
            $errors['phone']['unique'] = 'Mỗi số điện thoại chỉ đăng ký tối đa 3 tài khoản !!';
        }
    }

    // Validate password: không được để trống, ít nhất 6 ký tự
    if (empty ($filter['password'])) {
        $errors['password']['require'] = 'Mật khẩu không được để trống !!';
    } elseif (strlen($filter['password']) < 6) {
        $errors['password']['minlength'] = 'Mật khẩu phải có ít nhất 6 kí tự !!';
    }

    // Validate password_confirm: không được để trống, ít nhất 6 ký tự
    if (empty ($filter['password_confirm'])) {
        $errors['password_confirm']['require'] = 'Bạn phải nhập lại mật khẩu !!';
    } elseif ($filter['password'] != $filter['password_confirm']) {
        $errors['password_confirm']['match'] = 'Mật khẩu nhập lại không đúng !!';
    }

    if (empty ($errors)) {
        setFlashData('smg', 'Đăng ký thành công!!');
        setFlashData('smg_type', 'success');
    } else {
        setFlashData('smg', 'Vui lòng kiểm tra lại dữ liệu');
        setFlashData('smg_type', 'danger');
    }

    // echo '<pre>';
    // print_r($errors);
    // echo '<pre>';
}

insertLayout('header', $data);
$smg = getFlashData('smg');
$smg_type = getFlashData('smg_type');
?>

<div class="row">
    <div class="col-4" style="margin: 50px auto">
        <h2 class="text-center text-uppercase">Đăng ký</h2>
        <?php if (!empty ($smg)) {
            getSmg($smg, $smg_type);
        }
        ?>
        <form action="" method="post">
            <div class="form-group mg-form">
                <label for="username">Họ và tên</label>
                <input name="username" type="text" class="form-control" id="username" placeholder="Họ và tên">
            </div>

            <div class="form-group mg-form">
                <label for="email">Email</label>
                <input name="email" type="text" class="form-control" id="email" placeholder="Địa chỉ email">
            </div>

            <div class="form-group mg-form">
                <label for="phone">Số điện thoại</label>
                <input name="phone" type="text" class="form-control" id="phone" placeholder="Số điện thoại">
            </div>

            <div class="form-group mg-form">
                <label for="password">Mật khẩu</label>
                <input name="password" type="password" class="form-control" placeholder="Mật khẩu">
            </div>

            <div class="form-group mg-form">
                <label for="password_confirm">Nhập lại mật khẩu</label>
                <input name="password_confirm" type="password" class="form-control" id="password_confirm"
                    placeholder="Nhập lại mật khẩu">
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