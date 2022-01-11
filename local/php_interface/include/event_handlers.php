<?php

AddEventHandler("iblock", "OnBeforeIBlockElementUpdate", ["CIBLockHandler", "OnBeforeIBlockElementUpdateHandler"]);

class CIBLockHandler
{
    // создаем обработчик события "OnBeforeIBlockElementUpdate"
    function OnBeforeIBlockElementUpdateHandler(&$arFields)
    {
        if ($arFields['IBLOCK_ID'] == NEWS_IBLOCK_ID) {//проверка ИБ Новости
            if ($arFields['ACTIVE'] === 'N') {//Если новость была деактивирована
                //смотрим на Свежесть новости по заданию
                $date = DateTime::createFromFormat('d.m.Y', $arFields["ACTIVE_FROM"]);
                $now = new DateTime();
                $dayDiff = $date->diff($now)->format('%a');
                if (intval($dayDiff) <= 300) { //по заданию требуется сравнение до 3 дней, здесь до 300 дней
                    $arFields['ACTIVE'] = 'Y';
                    die("Вы деактивировали свежую новость");
                }
            }
        }
    }
}

AddEventHandler("main", "OnBeforeEventAdd", array("CMainHandler", "OnBeforeEventAddHandler"));
AddEventHandler("main", "OnBeforeUserAdd", array("CMainHandler", "OnBeforeUserAddHandler"));

class CMainHandler
{
    function OnBeforeUserAddHandler(&$arFields)
    {
        if ($arFields["LAST_NAME"] == $arFields["NAME"]) {
            global $APPLICATION;
            $APPLICATION->throwException("Имя и Фамилия одинаковы!");
            return false;
        }
    }

    function OnBeforeEventAddHandler(&$event, &$lid, &$arFields)
    {

        if ($event == "FEEDBACK_FORM") {
            if (CMOdule::IncludeModule("iblock")) {
                $el = new CIBlockElement;
                $arLoadProductArray = array(
                    "IBLOCK_ID" => FEEDBACK_IBLOCK_ID,
                    "NAME" => $arFields["AUTHOR"],
                    "DETAIL_TEXT" => $arFields["TEXT"],
                    "DATE_ACTIVE_FROM" => ConvertTimeStamp(false, "FULL"),
                );
                $el->Add($arLoadProductArray);
            }
        }


    }
}
