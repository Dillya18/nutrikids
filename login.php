<?php
// MySQL-ге қосылу
$servername = "localhost";
$username = "root";
$password_db = "";
$dbname = "nutrikids_db";

$conn = new mysqli($servername, $username, $password_db, $dbname);

if ($conn->connect_error) {
    die("Қосылым қатесі: " . $conn->connect_error);
}

// Кіруді өңдеу
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $login_email = htmlspecialchars($_POST['login_email']);
    $login_password = $_POST['login_password'];

    $sql = "SELECT * FROM registration WHERE email = '$login_email'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        if (password_verify($login_password, $row['password'])) {
            echo "<script>alert('Сәтті кірдіңіз!');</script>";
        } else {
            echo "<script>alert('Қате пароль');</script>";
        }
    } else {
        echo "<script>alert('Бұл email тіркелмеген');</script>";
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Войти - NutriKids</title>
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
                <p><a href="registration.php">Регистрация</a></p>
                <p><a href="login.php">Войти</a></p>
            </div>
        </div>
    </header>

    <section class="auth-section">
        <div class="auth-container">
            <h1>Войти</h1>
            <p>Войдите в свой аккаунт</p>
            <form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
                <div class="form-group">
                    <label for="login_email">Почта:</label>
                    <input type="email" id="login_email" name="login_email" placeholder="Введите ваш email" required>
                </div>
                <div class="form-group">
                    <label for="login_password">Пароль:</label>
                    <input type="password" id="login_password" name="login_password" placeholder="Введите пароль" required>
                </div>
                <button type="submit" class="auth-btn">Войти</button>
            </form>
        </div>
    </section>

    <footer>
        <p>NutriKids - детское питание!</p>
        <p>2025</p>
    </footer>
</body>
</html>