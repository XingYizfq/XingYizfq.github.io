<?php
//https://www.hkmre.top

// 定义变量并初始化为空
$name = $email = $message = "";
$nameErr = $emailErr = $messageErr = "";
$successMessage = "";

// 表单提交处理
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // 验证并获取输入的数据
    $name = test_input($_POST["name"]);
    $email = test_input($_POST["email"]);
    $message = test_input($_POST["message"]);

    // 检查姓名是否为空
    if (empty($name)) {
        $nameErr = "姓名是必填项";
    } else {
        // 姓名格式验证
        if (!preg_match("/^[a-zA-Z ]*$/", $name)) {
            $nameErr = "只允许字母和空格";
        }
    }

    // 检查电子邮件是否为空
    if (empty($email)) {
        $emailErr = "电子邮件是必填项";
    } else {
        // 验证电子邮件格式
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $emailErr = "无效的电子邮件格式";
        }
    }

    // 检查留言是否为空
    if (empty($message)) {
        $messageErr = "留言是必填项";
    }

    // 如果没有错误，发送邮件并显示成功消息
    if (empty($nameErr) && empty($emailErr) && empty($messageErr)) {
        $to = "3529506067@qq.com"; // 将此处替换为你自己的电子邮件地址
        $subject = "反馈表单提交";
        $headers = "From: $email \r\n";

        // 发送邮件
        if (mail($to, $subject, $message, $headers)) {
            $successMessage = "您的反馈已成功提交";
            // 清空输入字段
            $name = $email = $message = "";
        } else {
            $successMessage = "抱歉，邮件发送失败";
        }
    }
}

// 清理并验证输入数据
function test_input($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

?>

<!DOCTYPE html>
<html>
<head>
    <title>反馈表单</title>
</head>
<body>

<h2>反馈表单</h2>

<p><span class="error">* 必填字段</span></p>

<form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
    <label for="name">姓名：</label>
    <input type="text" name="name" value="<?php echo $name; ?>">
    <span class="error">* <?php echo $nameErr; ?></span>
    <br><br>

    <label for="email">电子邮件：</label>
    <input type="email" name="email" value="<?php echo $email; ?>">
    <span class="error">* <?php echo $emailErr; ?></span>
    <br><br>

    <label for="message">留言：</label>
    <textarea name="message"><?php echo $message; ?></textarea>
    <span class="error">* <?php echo $messageErr; ?></span>
    <br><br>

    <input type="submit" name="submit" value="提交">
</form>

<?php echo $successMessage; ?>

</body>
</html>