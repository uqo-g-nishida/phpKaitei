<?php
session_start();
session_regenerate_id(true);

require_once 'message_link.php';

try {

    require_once '../common/sanitize.php';

    $post = sanitize($_POST);

    $onamae = $post['onamae'];
    $email = $post['email'];
    $postal = $post['postal'];
    $addres = $post['addres'];
    $tel = $post['tel'];
    $chumon = $post['chumon'];
    $pass = $post['pass'];
    $danjo = $post['danjo'];
    $birth = $post['birth'];

    $message = "
        {$onamae}様\n
        ご注文ありがとうございました。\n
        {$email}にメールを送りましたのでご確認ください。\n
        商品は以下の住所に送付させていただきます。\n
        {$postal}\n
        {$addres}\n
        {$tel}\n
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

    // 会員登録
    $lastmembercode = 0;
    if ($chumon == 'chumontouroku') {
        $sql = 'INSERT INTO dat_member (password,name,email,postal,address,tel,danjo,born) VALUES (?,?,?,?,?,?,?,?)';
        $stmt = $dbh->prepare($sql);
        $data = array();
        $data[] = md5($pass);
        $data[] = $onamae;
        $data[] = $email;
        $data[] = $postal;
        $data[] = $addres;
        $data[] = $tel;
        $data[] = $danjo == 'dan' ? 1 : 2;
        $data[] = $birth;
        $stmt->execute($data);

        $sql = 'SELECT LAST_INSERT_ID()';
        $stmt = $dbh->prepare($sql);
        $stmt->execute();
        $rec = $stmt->fetch(PDO::FETCH_ASSOC);
        $lastmembercode = $rec['LAST_INSERT_ID()'];
    }

    // DBに注文を登録
    $sql = 'INSERT INTO dat_sales(code_member,name,email,postal,address,tel) VALUES (?,?,?,?,?,?)';
    $stmt = $dbh->prepare($sql);
    $data = array();
    $data[] = $lastmembercode;
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

    if ($chumon == 'chumontouroku') {
        $message .= "
            \n
            会員登録が完了いたしました。\n
            次回からメールアドレスとパスワードでログインして下さい。\n
            ご注文が簡単にできるようになります。\n
            ";
    }

    $honbun .= "
        送料は無料です。
        --------------------
        
        代金は以下の口座にお振り込みください。
        ろくまる銀行 やさい支店 普通口座 1234567
        
        〜安心野菜のろくまる農園〜
        
        ○○県六丸郡六丸村 123-4
        電話 090-6060-xxxx
        メール info@rokumarunouen.co.jp
        ";

    if ($chumon == 'chumontouroku') {
        $honbun .= "
            会員登録が完了いたしました。
            次回からメールアドレスとパスワードでログインして下さい。
            ご注文が簡単にできるようになります。
            ";
    }

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

view_message_link_page(
    $message,
    'index.php',
    '商品一覧に戻る'
);