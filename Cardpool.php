<?php
/**
 * ブラックジャックのゲームに使用するトランプデッキのクラスです
 */

namespace Vendor;

require_once 'Card.php'; // カードのクラス

class Cardpool
{
    private $cards; //山札

    public function __construct()
    {
        $this->cards = $this->makedeck();
    }

    public function makedeck()
    {
        $suit = ["スペード","クラブ","ダイヤ","ハート"];
        $number = ["A","2","3","4","5","6","7","8","9","10","J","Q","K"];
        $deck = [];
        foreach ($suit as $s) {
            foreach ($number as $n) {
                $deck[] = new Card($s, $n); // 52枚のカードを生成
            }
        }
        shuffle($deck); // 山札をシャッフル
        return $deck;
    }

    // カードを引くメソッド
    public function choosecard()
    {
        return array_pop($this->cards);
    }
}
