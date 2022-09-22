<div class="container mt-4">
    <div class="row">
        <div class="col">
            <h1>Форма входа</h1>
            <h2><? echo $this->params['message']; ?></h2>
            <form action="/login" method="post">
                <input type="text" name="phone" required class="form-control" id="name" placeholder="Phone or email"><br>
                <input type="password" name="password" class="form-control" id="pass" placeholder="Password"><br>
                <input type="hidden" name="recaptcha_response" id="recaptchaResponse">
                <button class="btn btn-success">Войти</button><br>
            </form>
        </div>
    </div>
</div>
<script src="https://www.google.com/recaptcha/api.js?render=6Le7CxciAAAAANfDuBy1ef4kidrozolzr9SwW0Ae"></script>
<script>
    grecaptcha.ready(function () {
        grecaptcha.execute('6Le7CxciAAAAANfDuBy1ef4kidrozolzr9SwW0Ae', { action: 'contact' }).then(function (token) {
            var recaptchaResponse = document.getElementById('recaptchaResponse');
            recaptchaResponse.value = token;
        });
    });
</script>