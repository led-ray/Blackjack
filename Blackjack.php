<?php
/**
 * PHPで作成したブラックジャックのゲームです
 * ターミナルで「php Blackjack.php」で起動して遊ぶことを想定します
 */
namespace Vendor;

require_once 'Card.php'; // カードのクラス
require_once 'Hand.php'; // 持ち札のクラス
require_once 'Cardpool.php'; // 山札のクラス

class Blackjack
{
    private $player;
    private $dealer;
    private $cardpool;
    private $dealercard2;

    public function __construct()
    {
        // プレイヤーのインスタンスを作成
        $this->player = new Hand();
        // ディーラーのインスタンスを作成
        $this->dealer = new Hand();
        // 山札のインスタンスを作成
        $this->cardpool = new Cardpool();

        $this->dealercard2 = "";
    }

    // ゲーム開始時のドロー(プレイヤー)
    private function initialDrawPlayer($p)
    {
        echo "あなたの引いたカードは".$p->drawcard($this->cardpool->choosecard())."です\n";
        sleep(2); // メッセージが一気に流れると読みづらいので、2秒停止
        echo "あなたの引いたカードは".$p->drawcard($this->cardpool->choosecard())."です\n";
        sleep(2);
    }

    // ゲーム開始時のドロー(ディーラー)
    private function initialDrawDealer($d)
    {
        echo "ディーラーの引いたカードは".$d->drawcard($this->cardpool->choosecard())."です\n";
        sleep(2);
        // 2回目は結果を後で参照したいので変数に入れておく
        $this->dealercard2 = $d->drawcard($this->cardpool->choosecard());
        echo "ディーラーの引いた2枚目のカードはわかりません\n";
        sleep(2);
    }

    // プレイヤーにカードを引かせる
    private function playerdraw($p)
    {
        // プレイヤーの得点が21点の時は終了
        if ($p->calcpoints() === 21) {
            echo "あなたの現在の得点は".strval($p->calcpoints())."です。\n";
            sleep(2);
            return;
        }

        // プレイヤーの得点が21点未満のとき、引くか選択させる
        $stdin = "";
        while ($p->calcpoints() < 21) {
            echo "あなたの現在の得点は".strval($p->calcpoints())."です。カードを引きますか？（Y/N）\n";
            sleep(2);

            // プレイヤーに入力させる
            $stdin = trim(fgets(STDIN));
            
            // Yの場合、カードを引く
            if ($stdin==="Y") {
                echo "あなたの引いたカードは".$p->drawcard($this->cardpool->choosecard())."です\n";
                sleep(2);
            // Nの場合中断
            } elseif ($stdin==="N") {
                return;
            // YでもNでもないときは警告
            } else {
                echo "YかNを入力してください\n";
                sleep(2);
            }
        }
    }

    private function dealerdraw($d)
    {
        echo "ディーラーの引いた2枚目のカードは".$this->dealercard2."でした\n";
        echo "ディーラーの現在の得点は".strval($d->calcpoints())."です\n";
        sleep(2);

        // ディーラーは得点が17以上になるまでカードを引く
        while ($d->calcpoints() < 17) {
            echo "ディーラーの引いたカードは".$d->drawcard($this->cardpool->choosecard())."です\n";
            sleep(2);
        }
    }
    
    private function judge($p, $d)
    {
        //　勝敗の判定
        echo "あなたの得点は".strval($p->calcpoints())."です\n";
        echo "ディーラーの得点は".strval($d->calcpoints())."です\n";
        sleep(2);

        if ($d->calcpoints() > 21) { //　ディーラーが21点を超えていたらディーラーの負け
            echo "あなたの勝ちです！\n";
            sleep(2);
        } elseif ($p->calcpoints() > $d->calcpoints()) { //　プレイヤーの方が21点に近いときはプレイヤーの勝ち
            echo "あなたの勝ちです！\n";
            sleep(2);
        } elseif ($p->calcpoints() < $d->calcpoints()) { //　ディーラーの方が21点に近いときはディーラーの勝ち
            echo "あなたの負けです…\n";
            sleep(2);
        } elseif ($p->calcpoints() === $d->calcpoints()) { //　同点のときは引き分け
            echo "同点のため引き分けです\n";
            sleep(2);
        }
    }
    
    public function gameplay()
    {
        echo "ブラックジャックを開始します。\n";

        // 始めのドロー
        $this->initialDrawPlayer($this->player);
        $this->initialDrawDealer($this->dealer);

        // プレイヤーに引かせる
        $this->playerdraw($this->player);

        if ($this->player->calcpoints() > 21) { // プレイヤーが引いた結果、21点を越えていたらプレイヤーの負け
            echo "あなたの得点は".strval($this->player->calcpoints())."です。得点が21を超えたためあなたの負けです\n";
        } else { // プレイヤーが引いた結果、21点以下ならディーラーのターン開始
            // ディーラーが引く
            $this->dealerdraw($this->dealer);
            $this->judge($this->player, $this->dealer);
        }

        echo "ブラックジャックを終了します\n";
    }
}

// ゲーム実行
$game = new Blackjack();
$game->gameplay();
