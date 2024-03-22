<!-- Các hàm dùng chung -->
<?php
if (!defined('_CODE')) {
    die ('Access denied...');
}
//Import PHPMailer classes into the global namespace
//These must be at the top of your script, not inside a function
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

// Hàm chèn layout (header, footer)
function insertLayout($nameLayout = 'name', $data = [])
{
    $pathLayout = _WEB_PATH_TEMPLATES . '/layout/' . $nameLayout . '.php';
    if (file_exists($pathLayout)) {
        require_once ($pathLayout);
    }
}

// Hàm gửi mail
function sendMail($receiver, $subject, $content)
{


    //Create an instance; passing `true` enables exceptions
    $mail = new PHPMailer(true);

    try {
        //Server settings
        $mail->SMTPDebug = SMTP::DEBUG_OFF;                      //Enable verbose debug output
        $mail -> CharSet = "UTF-8mb4";
        $mail->isSMTP();                                            //Send using SMTP
        $mail->Host = 'smtp.gmail.com';                     //Set the SMTP server to send through
        $mail->SMTPAuth = true;                                   //Enable SMTP authentication
        $mail->Username = 'duonglapkhang283@gmail.com';                     //SMTP username
        $mail->Password = 'edajpcppfpjchojq';                               //SMTP password
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;            //Enable implicit TLS encryption
        $mail->Port = 465;                                    //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`

        //Recipients
        $mail->setFrom('duonglapkhang283@gmail.com', 'Mailer');
        $mail->addAddress($receiver);

        //Content
        $mail->isHTML(true);                                  //Set email format to HTML
        $mail->Subject = $subject;
        $mail->Body = $content;
        $mail->AltBody = 'This is the body in plain text for non-HTML mail clients';

        $sendStatus=  $mail->send();
        return $sendStatus;
        
    } catch (Exception $e) {
        echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
    }
}

// Hàm kiểm tra phương thức GET
function isGet()
{
    return $_SERVER['REQUEST_METHOD'] == 'GET' ? true : false;
}

// Hàm kiểm tra phương thức POST
function isPost()
{
    return $_SERVER['REQUEST_METHOD'] == 'POST' ? true : false;
}

// Hàm filter lọc dữ liệu
function filter()
{
    $filterArr = [];
    if (isGet()) {
        if (!empty ($_GET)) {
            foreach ($_GET as $key => $value) {
                // Kiểm tra value nếu nó là mảng
                $key = strip_tags($key);
                if (is_array($value)) {
                    $filterArr[$key] = filter_input(INPUT_GET, $key, FILTER_SANITIZE_SPECIAL_CHARS, FILTER_REQUIRE_ARRAY);
                } else {
                    $filterArr[$key] = filter_input(INPUT_GET, $key, FILTER_SANITIZE_SPECIAL_CHARS);
                }
            }
        }
    }

    if (isPost()) {
        if (!empty ($_POST)) {
            foreach ($_POST as $key => $value) {
                // Kiểm tra value nếu nó là mảng
                $key = strip_tags($key);
                if (is_array($value)) {
                    $filterArr[$key] = filter_input(INPUT_POST, $key, FILTER_SANITIZE_SPECIAL_CHARS, FILTER_REQUIRE_ARRAY);
                } else {
                    $filterArr[$key] = filter_input(INPUT_POST, $key, FILTER_SANITIZE_SPECIAL_CHARS);
                }
            }
        }
    }
    return $filterArr;
}

// Validate email
function isEmail($email)
{
    return $checkEmail = filter_var($email, FILTER_VALIDATE_EMAIL);
}

// Hàm kiêm tra số nguyên
function isInteger($number)
{
    return $checkInterger = filter_var($number, FILTER_VALIDATE_INT);
}
// Hàm kiểm tra số thực
function isFloat($number)
{
    return $checkFloat = filter_var($number, FILTER_VALIDATE_FLOAT);
}

// Hàm kiểm tra xem chuỗi có chứa ít nhất một số 
function containsNumber($string)
{
    return preg_match('/\d/', $string) === 1;
}

// Hàm kiểm tra chuỗi chỉ chứa số
function containsOnlyNumber($string)
{
    return preg_match('/^[0-9]+$/', $string) === 1;
}

// Hàm kiểm tra số điện thoại hợp lệ (bắt đầu bằng số 0, và đủ 10 số)
function isPhone($phone)
{
    // Kiểm tra bắt đầu bằng 0
    if ($phone[0] != '0') {
        return false;
    }
    // Kiểm tra đủ 10 số
    if (!containsOnlyNumber($phone)) {
        return false;
    }
    return true;
    
}

// Thông báo 
function getSmg($smg, $type = 'success')
{
    ($type == 'success') ? $icon = 'check' : $icon = 'times';
    echo '<div class="text-'.$type.'-emphasis alert alert-'.$type.'">';
    echo '<i class="fa fa-'.$icon.' text-'.$type.'-emphasis"></i> '.$smg;
    echo '</div>';
}

// Hàm chuyển hướng
function redirect($path='index.php') {
    header("location: $path");
    exit;
}

// Hàm hiển thị lỗi input
function showFormErrors($errors=[], $name) {
    echo !empty($errors["$name"]) ? '<span class="error">'.reset($errors["$name"]).'</span>' : null;
}

// Hiển thị dữ liệu đã nhập (dữ liệu sẽ được giữ lại dù kết thúc session)
function showOldData($errors=[], $data) {
    echo !empty($errors["$data"]) ? $errors["$data"] : null;
}