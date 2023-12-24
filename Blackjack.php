<?php
/**
 * PHPで作成したブラックジャックのゲームです
 * ターミナルで「php Blackjack.php」で起動して遊ぶことを想定します
 */
namespace Vendor;

require_once 'Hand.php'; // 持ち札のクラス
require_once 'Cardpool.php'; // 山札のクラス

// プレイヤーのインスタンスを作成
$player = new Hand();
// ディーラーのインスタンスを作成
$dealer = new Hand();
// 山札のインスタンスを作成
$cardpool = new Cardpool();

echo "ブラックジャックを開始します。\n";

// 初めにプレイヤーが2回引く
echo "あなたの引いたカードは".$player->drawcard($cardpool->choosecard())."です\n";
// メッセージが一気に流れると読みづらいので、2秒停止
sleep(2);
echo "あなたの引いたカードは".$player->drawcard($cardpool->choosecard())."です\n";
sleep(2);

// ディーラーが2回引く
echo "ディーラーの引いたカードは".$dealer->drawcard($cardpool->choosecard())."です\n";
sleep(2);

// 2回目は結果を後で参照したいので変数に入れておく
$message = $dealer->drawcard($cardpool->choosecard());
echo "ディーラーの引いた2枚目のカードはわかりません\n";
sleep(2);

// プレイヤーの得点が21点の時は終了
if ($player->calcpoints() === 21) {
    echo "あなたの現在の得点は".strval($player->calcpoints())."です。\n";
    sleep(2);
}

// プレイヤーの得点が21点未満のとき、引くか選択させる
$stdin = "";
while ($player->calcpoints() < 21) {
    echo "あなたの現在の得点は".strval($player->calcpoints())."です。カードを引きますか？（Y/N）\n";
    sleep(2);

    // プレイヤーに入力させる
    $stdin = trim(fgets(STDIN));
    
    // Yの場合、カードを引く
    if ($stdin==="Y") {
        echo "あなたの引いたカードは".$player->drawcard($cardpool->choosecard())."です\n";
        sleep(2);
    // Nの場合中断
    } elseif ($stdin==="N") {
        break;
    // YでもNでもないときは警告
    } else {
        echo "YかNを入力してください\n";
        sleep(2);
    }
}

// プレイヤーが引いた結果、21点を越えていたらプレイヤーの負け
if ($player->calcpoints() > 21) {
    echo "あなたの得点は".strval($player->calcpoints())."です。得点が21を超えたためあなたの負けです\n";
    sleep(2);
// プレイヤーが引いた結果、21点以下ならディーラーのターン開始
} else {
    echo "ディーラーの引いた2枚目のカードは".$message."でした\n";
    echo "ディーラーの現在の得点は".strval($dealer->calcpoints())."です\n";
    sleep(2);

    // ディーラーは得点が17以上になるまでカードを引く
    while ($dealer->calcpoints() < 17) {
        echo "ディーラーの引いたカードは".$dealer->drawcard($cardpool->choosecard())."です\n";
        sleep(2);
    }

    //　勝敗の判定
    echo "あなたの得点は".strval($player->calcpoints())."です\n";
    echo "ディーラーの得点は".strval($dealer->calcpoints())."です\n";
    sleep(2);

    if ($dealer->calcpoints() > 21) { //　ディーラーが21点を超えていたらディーラーの負け
        echo "あなたの勝ちです！\n";
        sleep(2);
    } elseif ($player->calcpoints() > $dealer->calcpoints()) { //　プレイヤーの方が21点に近いときはプレイヤーの勝ち
        echo "あなたの勝ちです！\n";
        sleep(2);
    } elseif ($player->calcpoints() < $dealer->calcpoints()) { //　ディーラーの方が21点に近いときはディーラーの勝ち
        echo "あなたの負けです…\n";
        sleep(2);
    } elseif ($player->calcpoints() === $dealer->calcpoints()) { //　同点のときは引き分け
        echo "同点のため引き分けです\n";
        sleep(2);
    }
}

echo "ブラックジャックを終了します\n";
