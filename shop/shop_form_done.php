<?php
session_start();
session_regenerate_id(true);
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
        {$onamae}様\n\nこの度はご注文ありがとうございました。\n
        \n
        ご注文商品\n
        --------------------\n
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

    // DBに注文を登録
    $sql = 'INSERT INTO dat_sales(code_member,name,email,postal,address,tel) VALUES (?,?,?,?,?,?)';
    $stmt = $dbh->prepare($sql);
    $data = array();
    $data[] = 0;
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

    $dbh = null;

    $honbun .="
        送料は無料です。\n
        --------------------\n
        \n
        代金は以下の口座にお振り込みください。\n
        ろくまる銀行 やさい支店 普通口座 1234567\n
        \n
        　　　　　　　　　　　　　　　　　\n
        　〜安心野菜のろくまる農園〜\n
        \n
        ○○県六丸郡六丸村 123-4\n
        電話 090-6060-xxxx\n
        メール info@rokumarunouen.co.jp\n
        　　　　　　　　　　　　　　　　　\n
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

} catch (Exception $e) {
    echo 'ただいま障害により大変ご迷惑をお掛けしております。';
    exit();
}
require_once '../common/sanitize.php';

?>

</body>
</html>