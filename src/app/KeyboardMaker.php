<?php


namespace App;


class KeyboardMaker
{
    public static function GetMainViberKeyboard()
    {
        $kb['keyboard'] = [
            'Type' => 'keyboard',
            'DefaultHeight' => false,
            'Buttons' => [
                [
                    "Columns" => 3,
                    "Rows" => 1,
                    "Text" => "💳 Моя карта",
                    "TextSize" => "large",
                    "TextHAlign" => "center",
                    "TextVAlign" => "middle",
                    "ActionType" => "reply",
                    "ActionBody" => "my_card",
                    "BgColor" => "#f6f7f9",
                    "Silent" => true,
                    //"Image" => "https: //s12.postimg.org/ti4alty19/smoke.png"
                ],
                [
                    "Columns" => 3,
                    "Rows" => 1,
                    "Text" => "🎁 Мои бонусы",
                    "TextSize" => "large",
                    "TextHAlign" => "center",
                    "TextVAlign" => "middle",
                    "ActionType" => "reply",
                    "ActionBody" => "bonuses",
                    "BgColor" => "#f6f7f9",
                    //"Image" => "https: //s14.postimg.org/us7t38az5/Nonsmoke.png"
                ],
            ]
        ];

        return $kb;

    }

    public static function GetPhoneSahreKeyboard()
    {
        $kb['keyboard'] = [
            'Type' => 'keyboard',
            'DefaultHeight' => false,
            'min_api_version' => 3,
            'Buttons' => [
                    [
                        "Columns" => 2,
                        "Rows" => 2,
                        "Text" => "Поделиться",
                        //"TextSize" => "large",
                        //"TextHAlign" => "center",
                        //"TextVAlign" => "middle",
                        "ActionType" => "share-phone",
                        "ActionBody" => "reply",
                        //"BgColor" => "#f6f7f9",
                        //"Image" => "https: //s14.postimg.org/us7t38az5/Nonsmoke.png"
                    ],
                ]
            ];

        return $kb;
    }


}