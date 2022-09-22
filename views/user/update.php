<div class="container mt-4">
    <div class="row">
        <div class="col">
            <h1>Изменить данные</h1>
            <h2><? echo $this->params['message']; ?></h2>
            <form action="/upgrade" method="post">
                <input type="text" name="name" value="<? echo $this->params['user']['name']; ?>" required class="form-control" id="login" placeholder="Name"><br>
                <input type="text" name="phone" value="<? echo $this->params['user']['phone']; ?>" required class="form-control" id="name" placeholder="Phone"><br>
                <input type="email" name="email" value="<? echo $this->params['user']['email']; ?>"  required class="form-control" id="email" placeholder="Email"><br>
                <input type="password" name="password" class="form-control" id="pass" placeholder="Password"><br>
                <input type="password" name="password-confirm" class="form-control" id="pass-confirm" placeholder="Password confirm"><br>
                <button class="btn btn-success">Изменить</button><br>
            </form>
        </div>
    </div>
</div>
