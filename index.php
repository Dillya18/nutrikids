<?php
session_start();

// "Выйти" логикасы
if (isset($_GET['logout'])) {
    unset($_SESSION['loggedin']); // Тек логин белгісін жою
    unset($_SESSION['user_email']); // Email-ді жою (қажет болса)
    header("Location: index.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>NutriKids</title>
    <link rel="stylesheet" href="./css/style.css">
</head>
<body>
<header>
    <div class="head">
        <div class="head-1">
            <p><a href="catalog.php">Каталог продукции</a></p>
            <p><a href="index.php#continer-2">О нас</a></p>
            <p><a href="index.php#continer-6">Блог о питании</a></p>
        </div>
        <div class="head-12">
            <a href="index.php">NutriKids</a>
        </div>
        <div class="head-13">
            <p><a href="index.php#continer-7">Где купить</a></p>
            <p><a href="index.php#continer-5">Отзыв родителей</a></p>
            <?php if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] === true): ?>
                <p><a href="favorites.php">Избранное</a></p>
                <p><a href="cart.php">Корзина (<?php echo isset($_SESSION['cart']) ? count($_SESSION['cart']) : 0; ?>)</a></p>
                <p><a href="profile.php">Личный кабинет</a></p> <!-- Жаңа сілтеме -->
                <p><a href="?logout=true">Выйти</a></p>
            <?php else: ?>
                <p><a href="registration.php">Регистрация</a></p>
                <p><a href="login.php">Войти</a></p>
            <?php endif; ?>
        </div>
    </div>
</header>

    <section class="continer-1">
    <h1 class="con1">Питающие улыбки</h1>
    <p class="con12">Откройте для себя мир полезных и вкусных блюд, которые порадуют ваших малышей и подарят вам спокойствие.</p>
    <a href="catalog.php" class="con13">Посмотреть каталог</a>
    <div><img src="../nutrikids/img/1.jpg" alt="PP" class="img1"></div>
</section>

<section class="continer-2" id="continer-2">
    <!-- Бұдан әрі бөлім мазмұны жалғасады -->
    <div class="card1">
        <h2 class="con2">Ваш партнер в здоровом питании</h2>
        <p class="con22">Мы помогаем родителям найти сертифицированное и здоровое детское питание...</p>
    </div>
    <div class="card2">
        <img src="../nutrikids/img/3.jpg" alt="ppp" class="img2">
    </div>
</section>

    <section class="continer-3">
        <div class="c3tit">
            <h3 class="con3_title">Преимущества для вас</h3>
            <p class="con3_p">Выбирайте из широкого ассортимента детского питания, подходящего для разных возрастов и
                потребностей. Воспользуйтесь преимуществами качественных сертификатов, удобных инструментов поиска и
                фильтрации, безопасных способов оплаты и быстрой доставки.</p>
        </div>
        <div class="threecard">
            <div class="choose">
                <img src="../nutrikids/img/choose.png" class="img3" />
                <p>Большой выбор продуктов</p>
                <p>У нас вы найдёте разнообразные детские продукты на любой вкус и возраст.</p>
            </div>
            <div class="quan">
                <img src="../nutrikids/img/quan.png" class="img4" />
                <p>Сертификаты качества</p>
                <p>Все наши продукты имеют необходимые сертификаты и соответствуют стандартам безопасности.</p>
            </div>
            <div class="find">
                <img src="../nutrikids/img/find.png" class="img5" />
                <p class="fp">Удобный поиск и фильтры</p>
                <p class="fp">Вы легко найдёте нужные продукты с помощью удобных фильтров и сортировки.</p>
            </div>
        </div>
    </section>

    <section class="continer-4">
    <div class="c4tit">
        <h3 class="con4_title">Изучите наш каталог продукции</h3>
        <p class="con4_p">Просмотрите нашу тщательно подобранную коллекцию детского питания, разделенную по возрасту, диетическим требованиям и формату. Найдите все, от баночек и пакетиков до полезных перекусов.</p>
    </div>
    <div class="con4_cards">
        <a href="baby.php" class="baby card-link">
            <img src="../nutrikids/img/3.jpg" class="babimg">
            <h5 class="bah">Питание для малышей</h5>
            <p class="bap">Разнообразие продуктов для самых маленьких, включая гипоаллергенные и безглютеновые варианты.</p>
        </a>
        <a href="school.php" class="school card-link">
            <img src="../nutrikids/img/4.jpg" class="scimg">
            <h5 class="sch">Школьное питание</h5>
            <p class="scp">Питательные перекусы и обеды для школьников, способствующие концентрации внимания и энергии.</p>
        </a>
        <a href="teen.php" class="teen card-link">
            <img src="../nutrikids/img/5.jpg" class="teimg">
            <h5 class="teh">Подростковое питание</h5>
            <p class="tep">Продукты, поддерживающие активный образ жизни подростков и помогающие в развитии.</p>
        </a>
    </div>
</section>

    <section class="continer-5" id="continer-5">
        <div class="con5_title">
            <h>Узнайте, что говорят родители</h>
        </div>
        <div class="con5cards">
            <div class="one">
                <img src="../nutrikids/img/mom.jpg" class="img5">
                <div class="text1">
                    <p class="p1">Наконец-то нашла то, что нужно моему малышу! Все продукты качественные и полезные, а
                        главное — вкусные!</p>
                    <h5 class="h1">Ольга</h5>
                    <p class="pp1">Мама двоих детей</p>
                </div>
            </div>
            <div class="one">
                <img src="../nutrikids/img/dad.jpg" class="img5">
                <div class="text1">
                    <p class="p1">Очень удобно, что можно найти всё необходимое в одном месте. И цены вполне доступные.
                    </p>
                    <h5 class="h1">Игорь</h5>
                    <p class="pp1">Папа троих детей</p>
                </div>
            </div>
            <div class="two">
                <img src="../nutrikids/img/mom2.jpg" class="img5">
                <div class="text1">
                    <p class="p1">Спасибо за вашу работу! Теперь я уверена, что мой ребёнок получает самое лучшее
                        питание.</p>
                    <h5 class="h1">Елена</h5>
                    <p class="pp1">Молодая мама</p>
                </div>
            </div>
            <div class="two">
                <img src="../nutrikids/img/dad2.jpg" class="img5">
                <div class="text1">
                    <p class="p1">Быстро доставили заказ, всё аккуратно упаковано. Буду заказывать ещё!</p>
                    <h5 class="h1">Александр</h5>
                    <p class="pp1">Отец двоих детей</p>
                </div>
            </div>
        </div>
    </section>

    <section class="continer-6" id="continer-6">
    <div class="con6tit">
        <h3 class="con6_title">Питательные идеи</h3>
        <p class="con6_p">Следите за обновлениями в нашем блоге, где вы найдете интересные статьи о детском питании,
            рецептах, советах по кормлению и рекомендациях по здоровому питанию на каждом этапе роста вашего
            ребенка.</p>
    </div>
    <div class="con6cards">
        <div class="sixcard">
            <img src="../nutrikids/img/6.jpg" class="img6">
            <div class="text6">
                <h5 class="h6">Питание для малышей</h5>
                <p class="p6">Особенности питания детей до года, правила введения прикорма и советы по выбору
                    продуктов.</p>
                <a href="baby.php" class="button6">Узнать больше</a>
            </div>
        </div>
        <div class="sixcard2">
            <img src="../nutrikids/img/7.jpg" class="img6">
            <div class="text6">
                <h5 class="h6">Здоровое питание школьников</h5>
                <p class="p6">Рецепты полезных блюд, советы по организации питания и выбору продуктов для детей
                    школьного возраста.</p>
                <a href="school.php" class="button6">Узнать больше</a>
            </div>
        </div>
    </div>
</section>

    <!-- ... Алдыңғы бөлімдер сол күйінде қалады ... -->

    <section class="continer-7" id="continer-7">
        <div class="con7tit">
            <h3 class="con7_title">Начните свое путешествие</h3>
            <p class="con7_p">Присоединяйтесь к нашему сообществу родителей...</p>
        </div>

        <div class="anketa">
            <form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
                <div class="form-group">
                    <label for="name" class="lbl">Имя:</label>
                    <input type="text" class="int" id="name" name="name" placeholder="Введите ваше имя" required>
                </div>

                <div class="form-group">
                    <label for="email" class="lbl">Почта:</label>
                    <input type="email" class="int" id="email" name="email" placeholder="Введите ваш email" required>
                </div>

                <div class="form-group">
                <label for="phone" class="lbl">Номер:</label>
                <input type="tel" class="int" id="phone" name="phone" placeholder="Введите ваш номер телефона" required>
            </div>

                <div class="form-group">
                    <label for="message" class="lbl3">Сообщение:</label>
                    <textarea id="message" name="message" rows="5" placeholder="Ваше сообщение" required></textarea>
                </div>

                <button type="submit" class="button7">Отправить</button>
            </form>
        </div>
    </section>

<!-- ... Келесі бөлімдер сол күйінде қалады ... -->

<section class="continer-8" id="continer-8">
        <div class="con8tit">
            <h5 class="con8_title">Свяжитесь с нами</h5>
            <p class="con8_p">Свяжитесь с нами
                Телефон: 8 705 826-49-00<br>
                Электронная почта: d.azbergenova@aues.kz<br>
                Форма обратной связи: оставьте сообщение, и мы свяжемся с вами</p>
        </div>
        <div class="map">
            <iframe
                src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d2907.3819872670374!2d76.93214737619739!3d43.222450221125726!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x38836f25aa0658d1%3A0xcaf83e54014f5fc9!2z0YPQu9C40YbQsCDQl9C10LnQvdCwINCo0LDRiNC60LjQvdCwIDE00JAsINCQ0LvQvNCw0YLRiw!5e0!3m2!1sru!2skz!4v1729104596890!5m2!1sru!2skz"
                width="660" height="400" style="border:0;" allowfullscreen="" loading="lazy"
                referrerpolicy="no-referrer-when-downgrade"></iframe>
        </div>
    </section>

    <footer>
        <p>NutriKids - детское питание!</p>
        <p>2025</p>
    </footer>

</body>

</html>