<div class="container mt-4">
    <div class="row">
        <div class="col">
            <h1>Главная страница</h1>
            <?php if(!isset($_COOKIE['user'])): ?>
            <h2><? echo $this->params['message']; ?></h2>
            <?php else: ?>
            <h2><a href="/update"> Обновить профиль </a></h2>
            <?php endif; ?>

        </div>
    </div>
</div>
