<?php include ROOT . '/views/layouts/header.php'; ?>

    <div class="container">
        <div class="row">

            <div class = "col-md-3 col-sm-6"><h1>Кабинет пользователя</h1></div>
            <div class = "col-md-1 col-sm-6"><h7>Привет, <?php echo $user['name'];?>!</h7></div>
            <ul>
                <li><a href="/cabinet/edit">Редактировать данные</a></li>
            </ul>
           
        </div>
    </div>  

<?php include ROOT . '/views/layouts/footer.php'; ?>