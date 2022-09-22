<div class="container mt-4">
    <div class="row">
        <div class="col">
            <h1>Форма регистрации</h1>
            <h2><? echo $this->params['message']; ?></h2>
            <form action="/store" method="post">
                <input type="text" name="name" required class="form-control" id="login" placeholder="Name"><br>
                <input type="text" name="phone" required class="form-control" id="name" placeholder="Phone"><br>
                <input type="email" name="email" required class="form-control" id="email" placeholder="Email"><br>
                <input type="password" name="password" class="form-control" id="pass" placeholder="Password"><br>
                <input type="password" name="password-confirm" class="form-control" id="pass-confirm" placeholder="Password confirm"><br>
                <button class="btn btn-success">Зарегистрироваться</button><br>
            </form>
        </div>
    </div>
</div>
