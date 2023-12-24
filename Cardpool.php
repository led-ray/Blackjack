<?php
/**
 * ブラックジャックのゲームに使用するトランプデッキのクラスです
 * 52枚のトランプを用い、同じカードが複数回引かれないようにします
 */

namespace Vendor;

class Cardpool
{
    protected $cards; //山札

    public function __construct()
    {
        $this->cards = range(1, 52); // 52枚のカードを生成
    }

    // 各プレイヤーが引くカードを決めるメソッド
    public function choosecard()
    {
        // 乱数を生成してインデックスとする
        $rnd = random_int(0, count($this->cards)-1);

        // 選ばれたカードの値を取得
        $card = $this->cards[$rnd];

        // 選ばれたカードをデッキから削除
        array_splice($this->cards, $rnd, 1);

        // 選ばれたカードの値を返す
        return $card;
    }
}
