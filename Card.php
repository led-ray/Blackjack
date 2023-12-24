<?php
/**
 * ブラックジャックのゲームに使用するカードのクラスです
 */

namespace Vendor;

class Card
{
    private $suit; // スート
    private $number; // 数字

    public function __construct($suit, $number)
    {
        $this->suit = $suit;
        $this->number = $number;
    }

    // カードを表示するメソッド
    public function getcard()
    {
        return $this->suit . 'の' . $this->number;
    }

    // カードの数字を取得するメソッド
    public function getnum()
    {
        return $this->number;
    }
}
