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
    } elseif (containsNumber($filter['username'])) {
        $errors['username']['notnumber'] = 'Họ tên không được chứa số !!';
    } elseif (strlen($filter['username']) < 5) {
        $errors['username']['minlength'] = 'Họ tên phải có ít nhất 5 kí tự !!';
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
        $activeToken = sha1(uniqid().time());
        $dataInsert = [
            'username' => $filter['username'],
            'email' => $filter['email'],
            'phone' => $filter['phone'],
            'password' => password_hash($filter['username'], PASSWORD_DEFAULT),
            'activeToken' => $activeToken,
            'create_at' => date('Y-m-d H:i:s')
        ];

        $insertStatus = insert('user', $dataInsert);
        if ($insertStatus) {
            setFlashData('smg', 'Đăng ký thành công!!');
            setFlashData('smg_type', 'success');

            // Tạo link kích hoạt tài khoản
            $linkActive = _WEB_HOST.'?module=auth&action=active&token='.$activeToken;

            // Thiết lập gửi mail
            $subject = $filter['username'].' Kích hoạt tài khoản';
            $content = 'Chào '. $filter['username'].'</>';
            $content .= ' Vui lòng click vào link dưới đây để kích hoạt tài khoản: <br>';
            $content .= $linkActive.'<br>';
            $content .= 'Trân trọng cảm ơn!!';

            // Tiến hành gửi mail
            $sendMail = sendMail($filter['email'], $subject, $content);
            if ($sendMail) {
                setFlashData('smg', 'Vui lòng kiểm tra email để kích hoạt tài khoản!!');
                setFlashData('smg_type', 'success');
            } else {
                setFlashData('smg', 'Hệ thống đang gặp sự cố vui lòng thử lại sau!!');
                setFlashData('smg_type', 'danger');
            }
        } 

        // Đi đến trang đăng nhập khi đăng ký thành công
        // redirect('?module=auth&action=login');
    } else {
        setFlashData('smg', 'Vui lòng kiểm tra lại dữ liệu');
        setFlashData('smg_type', 'danger');
        setFlashData('errors', $errors);
        setFlashData('old_data', $filter);
        // Quay lại trang đăng ký nếu thất bại
        redirect('?module=auth&action=register');
    }

    // echo '<pre>';
    // print_r($errors);
    // echo '<pre>';

}

insertLayout('header', $data);
$smg = getFlashData('smg');
$smg_type = getFlashData('smg_type');
$errors = getFlashData('errors');
$old_data = getFlashData('old_data');
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
                <input value="<?php showOldData($old_data, 'username') ?>" name="username" type="text"
                    class="form-control" id="username" placeholder="Họ và tên">
                <?php showFormErrors($errors, 'username'); ?>
            </div>

            <div class="form-group mg-form">
                <label for="email">Email</label>
                <input value="<?php showOldData($old_data, 'email') ?>" name="email" type="text" class="form-control"
                    id="email" placeholder="Địa chỉ email">
                <?php showFormErrors($errors, 'email'); ?>
            </div>

            <div class="form-group mg-form">
                <label for="phone">Số điện thoại</label>
                <input value="<?php showOldData($old_data, 'phone') ?>" name="phone" type="text" class="form-control"
                    id="phone" placeholder="Số điện thoại">
                <?php showFormErrors($errors, 'phone'); ?>
            </div>

            <div class="form-group mg-form">
                <label for="password">Mật khẩu</label>
                <input value="<?php showOldData($old_data, 'password') ?>" name="password" type="password"
                    class="form-control" placeholder="Mật khẩu">
                <?php showFormErrors($errors, 'password'); ?>
            </div>

            <div class="form-group mg-form">
                <label for="password_confirm">Nhập lại mật khẩu</label>
                <input value="<?php showOldData($old_data, 'password_confirm') ?>" name="password_confirm"
                    type="password" class="form-control" id="password_confirm" placeholder="Nhập lại mật khẩu">
                <?php showFormErrors($errors, 'password_confirm'); ?>
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