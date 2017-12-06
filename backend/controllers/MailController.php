<?php
namespace backend\controllers;

use yii\web\Controller;
use Yii;
use common\widgets\Smtp;

/**
 * Created by PhpStorm.
 * User: ZhengJY
 * Date: 2017/10/12
 * Time: 13:02
 */
class MailController extends Controller
{
    /**
     * 邮件发送
     */
    public function actionSend()
    {
        $message = Yii::$app->mailer->compose()
            ->setFrom(['ceshi@qq.com' => 'testadmin'])
//            ->setFrom(['oibaiyang@163.com' => 'testadmin'])
            ->setTo('ceshi@qq.com')
            ->setSubject('Message subject')
            ->setTextBody('Plain text content')
            ->setHtmlBody('<b>HTML content</b>');

        if ( $message->send() ) {
            echo 'success';
        } else {
            echo 'fail';
        }
    }

    public function actionSend2()
    {
        /************************ 配置信息 ****************************/
        /*$smtpserver = "smtp.exmail.qq.com";  // SMTP服务器
        $smtpserverport = 465;  // SMTP服务器端口
        $smtpusermail = "ceshi@qq.com";  //SMTP服务器的用户邮箱
        $smtpuser = "ceshi@qq.com";  //SMTP服务器的用户帐号，注：部分邮箱只需@前面的用户名
        $smtppass = "**********";  //SMTP服务器的用户密码*/

        $smtpserver = "smtp.exmail.qq.com";  // SMTP服务器
        $smtpserverport = 25;  // SMTP服务器端口
        $smtpusermail = "ceshi@qq.com";  //SMTP服务器的用户邮箱
        $smtpuser = "ceshi@qq.com";  //SMTP服务器的用户帐号，注：部分邮箱只需@前面的用户名
        $smtppass = "**********";  //SMTP服务器的用户密码

        /*$smtpserver = "smtp.163.com";  // SMTP服务器
        $smtpserverport = 25;  // SMTP服务器端口
        $smtpusermail = "ceshi@qq.com";  //SMTP服务器的用户邮箱
        $smtpuser = "ceshi@qq.com";  //SMTP服务器的用户帐号，注：部分邮箱只需@前面的用户名
        $smtppass = "**********";  //SMTP服务器的用户密码*/

        $smtpemailto = "ceshi@qq.com";  //发送给谁
        $mailtitle = "测试邮件主题";  //邮件主题
        $mailcontent = "<h1>"."测试101201"."</h1>";  //邮件内容
        $mailtype = "HTML";  //邮件格式（HTML/TXT）,TXT为文本邮件


        /************************ 发送操作 ***********************/
        $smtp = new Smtp($smtpserver, $smtpserverport, true, $smtpuser, $smtppass);  // 这里面的一个true是表示使用身份验证,否则不使用身份验证.
        $smtp->debug = false;//是否显示发送的调试信息
        $state = $smtp->sendmail($smtpemailto, $smtpusermail, $mailtitle, $mailcontent, $mailtype);

        if ( $state == "" ) {
            echo "对不起，邮件发送失败！请检查邮箱填写是否有误。";
        } else {
            echo "恭喜！邮件发送成功！！";
        }
    }


}