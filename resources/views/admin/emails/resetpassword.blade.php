<!doctype html>
<html lang="vi">

<head>
    <meta content="text/html; charset=utf-8" http-equiv="Content-Type" />
    <title>Email Đặt lại Mật khẩu</title>
    <meta name="description" content="Email Đặt lại Mật khẩu.">
    <style type="text/css">
        a:hover {
            text-decoration: underline !important;
        }
    </style>
</head>

<body marginheight="0" topmargin="0" marginwidth="0" style="margin: 0px; background-color: #f2f3f8;" leftmargin="0">
    <!--100% body table-->
    <table cellspacing="0" border="0" cellpadding="0" width="100%" bgcolor="#f2f3f8"
        style="@import url(https://fonts.googleapis.com/css?family=Rubik:300,400,500,700|Open+Sans:300,400,600,700); font-family: 'Open Sans', sans-serif;">
        <tr>
            <td>
                <table style="background-color: #f2f3f8; max-width:570px;  margin:0 auto;" width="100%" border="0"
                    align="center" cellpadding="0" cellspacing="0">
                    <tr>
                        <td style="height:80px;">&nbsp;</td>
                    </tr>
                    <tr>
                        <td style="text-align:center;">
                            <!-- <a href="https://rakeshmandal.com" title="logo" target="_blank">
                <img width="60" src="https://i.ibb.co/hL4XZp2/android-chrome-192x192.png" title="logo" alt="logo">
              </a> -->
                        </td>
                    </tr>
                    <tr>
                        <td style="height:20px;">&nbsp;</td>
                    </tr>
                    <tr>
                        <td>
                            <table width="100%" border="0" align="center" cellpadding="0" cellspacing="0"
                                style="max-width:570px;background:#fff; border-radius:3px; text-align:center;-webkit-box-shadow:0 6px 18px 0 rgba(0,0,0,.06);-moz-box-shadow:0 6px 18px 0 rgba(0,0,0,.06);box-shadow:0 6px 18px 0 rgba(0,0,0,.06);">
                                <tr>
                                    <td style="height:40px;">&nbsp;</td>
                                </tr>
                                <tr>
                                    <td style="padding:0 35px;">
                                        <h1
                                            style="color:#1e1e2d; font-weight:600; margin:0;font-size:30px;font-family:'Rubik',sans-serif;">
                                            Xin chào!, {{ $name }}</h1>
                                        <span
                                            style="display:inline-block; vertical-align:middle; margin:29px 0 26px; border-bottom:1px solid #cecece; width:100px;"></span>
                                        <p style="color:#455056; font-size:15px;line-height:24px; margin:0;">
                                            Bạn đang nhận email này vì chúng tôi nhận được yêu cầu đặt lại mật khẩu
                                            cho tài khoản của bạn.
                                        </p>
                                        <a href="{{ $url }}"
                                            style="background:#20e277;text-decoration:none !important; font-weight:500; margin:35px 0; color:#fff;text-transform:uppercase; font-size:14px;padding:10px 24px;display:inline-block;border-radius:50px;">Đặt
                                            Lại Mật Khẩu</a>
                                        <p style="color:#455056; font-size:15px;line-height:24px; margin:0;">Liên kết đặt
                                            lại mật khẩu này sẽ hết hạn trong <strong>5 phút</strong>.
                                            <br>
                                            Nếu bạn không yêu cầu đặt lại mật khẩu, không cần thêm hành động nào.
                                        </p>

                                    </td>
                                </tr>
                                <tr>
                                    <td style="height:40px;">&nbsp;</td>
                                </tr>
                            </table>
                        </td>
                    <tr>
                        <td style="height:20px;">&nbsp;</td>
                    </tr>
                    <tr>
                        <td style="text-align:center;">
                            <p
                                style="font-size:14px; color:rgba(69, 80, 86, 0.7411764705882353); line-height:18px; margin:0 0 0;">
                                &copy; <strong style="color: #455056;"><a style="color: #455056;"
                                        href="{{ getEnv('APP_URL') }}">{{ getEnv('APP_URL') }}</a></strong></p>
                        </td>
                    </tr>
                    <tr>
                        <td style="height:80px;">&nbsp;</td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
    <!--/100% body table-->
</body>

</html>
