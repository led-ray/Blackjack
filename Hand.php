<?php
/**
 * ブラックジャックのゲームに使用する、各プレイヤーの持ち札のクラスです
 */

namespace Vendor;

class Hand
{
    protected $cards; // 持ち札

    public function __construct()
    {
        $this->cards = [];
    }

    // 引いたカードを持ち札に追加するメソッド
    public function drawcard($value)
    {
        // 引いたカードを追加
        array_push($this->cards, $value);

        // 引いたカードの説明を出力
        $suit="";
        if (intdiv($value, 13)===0) {
            $suit = "スペード";
        } elseif (intdiv($value, 13)===1) {
            $suit = "クラブ";
        } elseif (intdiv($value, 13)===2) {
            $suit = "ダイヤ";
        } elseif (intdiv($value, 13)===3) {
            $suit = "ハート";
        }

        $number="";
        if ($value % 13 === 11) {
            $number = "J";
        } elseif ($value % 13 === 12) {
            $number = "Q";
        } elseif ($value % 13 === 0) {
            $number = "K";
        } else {
            $number = strval($value % 13);
        }

        return $suit."の".$number;
    }

    // 持ち札の点数を計算するメソッド
    public function calcpoints()
    {
        $points = 0;
        foreach ($this->cards as $card) {
            $points = $points + min(($card-1) % 13 + 1, 10);
        }
        return $points;
    }
}
