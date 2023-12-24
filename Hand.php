<?php
/**
 * ブラックジャックのゲームに使用する、各プレイヤーの持ち札のクラスです
 */

namespace Vendor;

class Hand
{
    private $cards; // 持ち札

    public function __construct()
    {
        $this->cards = [];
    }

    // 引いたカードを持ち札に追加するメソッド
    public function drawcard($card)
    {
        array_push($this->cards, $card);
        return $card->getcard();
    }

    // 持ち札の点数を計算するメソッド
    public function calcpoints()
    {
        $values = [ // 点を数値化する連想配列
            "2" => 2, "3" => 3, "4" => 4, "5" => 5,
            "6" => 6, "7" => 7, "8" => 8, "9" => 9, "10" => 10,
            "J" => 10, "Q" => 10, "K" => 10, "A" => 1 // Aは1点としておく
        ];
        
        // カードのランクを取得して点数を計算
        $points = 0;
        $A_flag = 0;
        foreach ($this->cards as $card) {
            $points += $values[$card->getnum()];
            if ($card->getnum()==="A") { // Aが含まれているか判定
                $A_flag = 1;
            }
        }
        if ($A_flag === 1) {
            if ($points<=11) { // Aが含まれていて、得点が11以下の場合は10を足す
                $points += 10;
            }
        }
        return $points;
    }
}
