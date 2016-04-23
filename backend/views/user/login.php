<?php

use yii\helpers\Url;
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use backend\assets\BaseAsset;
use backend\assets\CountdownAsset;

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \backend\models\LoginForm */

CountdownAsset::register($this);
BaseAsset::addCss($this, '@web/css/login.css');

$this->title = '登录';

?>
<div id="login-box">
    <div class="logo">
        <?= Html::img('images/logo.png') ?>
    </div>
    <div class="border">
        <?php $form = ActiveForm::begin([
            'enableClientValidation' => false,
        ]); ?>
        <p class="info-tip"></p>
        <?= $form->field($model, 'phone', [
            'options' => [
                'class' => 'form-group form-group-lg'
            ],
            'inputTemplate' => '<div class="input-group"><span class="input-group-addon"><i class="glyphicon glyphicon-phone"></i></span>{input}</div>',
        ])->label(false)->error(false) ?>
        <?= $form->field($model, 'code', [
            'options' => [
                'class' => 'form-group form-group-lg'
            ],
            'inputTemplate' => '<div class="input-group"><span class="input-group-addon"><i class="glyphicon glyphicon-lock"></i></span>{input}<span class="input-group-btn"><button id="send-sms-btn" class="btn btn-default btn-lg" type="button">发送验证码</button></span></div>'
        ])->label(false)->error(false) ?>
        <?= $form->field($model, 'remember')->checkbox() ?>
        <div class="form-group form-group-lg">
            <?= Html::submitButton('登录', ['class' => 'btn btn-default btn-lg btn-block']) ?>
        </div>
        <?php ActiveForm::end(); ?>
    </div>
</div>

<?php

$sendSmsUrl = Url::to(['user/send-sms']);

$js = <<<JS
    $('#send-sms-btn').click(function() {
        // 先清除消息提示
        $('.info-tip').removeClass('has-error');
        $('.info-tip').text('');

        // 获取输入的手机号
        var phone = $('#loginform-phone').val();
        if (phone == '') {
            $('.info-tip').addClass('has-error');
            $('.info-tip').text('手机号不能为空');
            return false;
        }

        // 通过ajax发送短信验证码
        $.ajax({
            url : '{$sendSmsUrl}',
            type : 'post',
            data : {phone : phone},
            dataType : 'json',
            beforeSend : function() {
                // 避免重复点击
                $('#send-sms-btn').attr('disabled', true);
            }
        }).done(function (data) {
            if (data.status === 'ok') {
                $('.info-tip').text('短信发送成功,请注意查收...');
                $('#send-sms-btn').html('<em>60</em> 秒后可重发');
                $('#send-sms-btn').find('em').countdown((new Date()).getTime() + 59000, function (event) {
                    $(this).text(event.strftime('%S'));
                }).on('finish.countdown', function(event) {
                    $('#send-sms-btn').attr('disabled', false);
                    $('#send-sms-btn').text('重新发送');
                });
            } else {
                $('#send-sms-btn').attr('disabled', false);
                $('.info-tip').addClass('has-error');
                $('.info-tip').text(data.message);
            }
        });
    });
JS;

$this->registerJs($js);

?>
