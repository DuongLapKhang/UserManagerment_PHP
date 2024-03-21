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

        $mail->send();
        echo 'Message has been sent';
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