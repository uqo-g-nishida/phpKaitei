<?php
session_start();
session_regenerate_id(true);
if (!isset($_SESSION['member_login'])) {
    echo '
        ログインされていません。<br>
        <a href="shop_list.php">商品一覧へ</a>
        ';
    exit();
}
?>
<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>ご注文完了</title>
</head>
<body>

<?php
try {

    require_once '../common/sanitize.php';

    $post = sanitize($_POST);

    $onamae = $post['onamae'];
    $email = $post['email'];
    $postal = $post['postal'];
    $addres = $post['addres'];
    $tel = $post['tel'];

    echo "
    {$onamae}様<br>
    ご注文ありがとうございました。<br>
    {$email}にメールを送りましたのでご確認ください。<br>
    商品は以下の住所に送付させていただきます。<br>
    {$postal}<br>
    {$addres}<br>
    {$tel}<br>
    ";

    $honbun = "
        {$onamae}様
        この度はご注文ありがとうございました。
        ご注文商品
        --------------------
        ";

    $cart = $_SESSION['cart'];
    $kazu = $_SESSION['kazu'];
    $max = count($cart);

    // DB接続
    $dsn = 'mysql:dbname=shop;host=localhost';
    $user = 'root';
    $password = 'root';
    $dbh = new PDO($dsn, $user, $password);
    $dbh->query('SET NAMES utf8');

    // メール本文に設定
    for ($i = 0; $i < $max; $i++) {

        $sql = 'SELECT * FROM mst_product WHERE code = ?';
        $stmt = $dbh->prepare($sql);
        $data[0] = $cart[$i];
        $stmt->execute($data);

        $rec = $stmt->fetch(PDO::FETCH_ASSOC);
        $name = $rec['name'];
        $price = $rec['price'];
        $kakaku[] = $price;
        $suryo = $kazu[$i];
        $shokei = $price * $suryo;

        $honbun .= "{$name} {$price}円 x {$suryo}個 = {$shokei}円\n";
    }

    // TABLELOCK
    $sql = 'LOCK TABLES dat_sales WRITE, dat_sales_product WRITE, dat_member WRITE';
    $stmt = $dbh->prepare($sql);
    $stmt->execute();

    // DBに注文を登録
    $sql = 'INSERT INTO dat_sales(code_member,name,email,postal,address,tel) VALUES (?,?,?,?,?,?)';
    $stmt = $dbh->prepare($sql);
    $data = array();
    $data[] = $_SESSION['member_code'];
    $data[] = $onamae;
    $data[] = $email;
    $data[] = $postal;
    $data[] = $addres;
    $data[] = $tel;
    $stmt->execute($data);

    $sql = 'SELECT LAST_INSERT_ID()';
    $stmt = $dbh->prepare($sql);
    $stmt->execute();
    $rec = $stmt->fetch(PDO::FETCH_ASSOC);
    $lastcode = $rec['LAST_INSERT_ID()'];

    // DBに商品を登録
    for ($i = 0; $i < $max; $i++) {
        // DBに登録
        $sql = 'INSERT INTO dat_sales_product(code_sales,code_product,price,quantity) VALUES (?,?,?,?)';
        $stmt = $dbh->prepare($sql);
        $data = array();
        $data[] = $lastcode;
        $data[] = $cart[$i];
        $data[] = $kakaku[$i];
        $data[] = $kazu[$i];
        $stmt->execute($data);
    }

    // TABLEUNLOCK
    $sql = 'UNLOCK TABLES';
    $stmt = $dbh->prepare($sql);
    $stmt->execute();

    $dbh = null;

    $honbun .="
        送料は無料です。
        --------------------
        
        代金は以下の口座にお振り込みください。
        ろくまる銀行 やさい支店 普通口座 1234567
        
        〜安心野菜のろくまる農園〜
        
        ○○県六丸郡六丸村 123-4
        電話 090-6060-xxxx
        メール info@rokumarunouen.co.jp
        ";

    // メール本文の確認用
    // echo '<br>'.nl2br($honbun);

    // お客様用
    $title = 'ご注文ありがとうございます。';
    $header = 'From:info@rokumarunouem.co.jp';
    $honbun = html_entity_decode($honbun, ENT_QUOTES, 'UTF-8');
    mb_language('Japanese');
    mb_internal_encoding('UTF-8');
    mb_send_mail($email, $title, $honbun, $header);

    // お店用
    $title = 'お客様から注文がありました。';
    $header = "From:{$email}";
    $honbun = html_entity_decode($honbun, ENT_QUOTES, 'UTF-8');
    mb_language('Japanese');
    mb_internal_encoding('UTF-8');
    mb_send_mail('info@rokumarunouem.co.jp', $title, $honbun, $header);

    // カートの削除
    $_SESSION = array();
    if (isset($_COOKIE[session_name()])) {
        setcookie(session_name(), '', time() - 42000, '/');
    }
    session_destroy();

} catch (Exception $e) {
    echo 'ただいま障害により大変ご迷惑をお掛けしております。';
    exit();
}
require_once '../common/sanitize.php';

?>

<br>
<a href="shop_list.php">商品画面へ</a>

</body>
</html>