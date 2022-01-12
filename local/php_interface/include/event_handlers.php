<?php


/*RegisterModuleDependences("iblock", "OnIBlockElementDelete", "catalog", "CCatalogProduct", "OnIBlockElementDelete");

class CCatalogProduct
{
    function OnIBlockElementDelete($PRODUCT_ID)
    {
        dump($PRODUCT_ID);die;
        global $DB;
        echo "Вы удалили популярный товар с ID = {$PRODUCT_ID}";
        return false;
    }
}*/


AddEventHandler("iblock", "OnBeforeIBlockElementUpdate", ["CIBLockHandler", "OnBeforeIBlockElementUpdateHandler"]);
AddEventHandler("iblock", "OnBeforeIBlockElementDelete", ["CIBLockHandler", "OnBeforeIBlockElementDeleteHandler"]);


class CIBLockHandler
{

    function OnBeforeIBlockElementDeleteHandler($ID)
    {
        if (CModule::IncludeModule("iblock")) {
            $res = CIBlockElement::GetByID($ID);
            if ($ar_res = $res->GetNext()) {
                //деактивируем element по заданию вместо удаления если товар просмотрели более 1 раза
                if (intval($ar_res["SHOW_COUNTER"]) >= 1) { //по заданию более 1 раза, здесь от 1 просмотра

                    $el = new CIBlockElement;
                    $arLoadProductArray = [
                        "ACTIVE" => "N"
                    ];
                    $el->Update($ID, $arLoadProductArray);
                    $GLOBALS['DB']->Commit();

                    global $APPLICATION;
                    $APPLICATION->throwException("Вы удалили популярный товар с ID = {$ID}, его уже просмотрели - " . $ar_res["SHOW_COUNTER"] . ' раз!');
                    return false;
                }
            }
        }
    }

    function OnBeforeIBlockElementUpdateHandler(&$arFields)
    {
        global $APPLICATION;

        if ($arFields['IBLOCK_ID'] == NEWS_IBLOCK_ID) {//ИБ Новости
            if ($arFields['ACTIVE'] === 'N') {//Если новость была деактивирована
                //смотрим на Свежесть новости по заданию
                $date = DateTime::createFromFormat('d.m.Y', $arFields["ACTIVE_FROM"]);
                $now = new DateTime();
                $dayDiff = $date->diff($now)->format('%a');
                if (intval($dayDiff) <= 300) { //по заданию требуется сравнение до 3 дней, здесь до 300 дней
                    $APPLICATION->throwException("Вы деактивировали свежую новость");
                    return false;
                }
            }
        }
    }
}

/*AddEventHandler("main", "OnBeforeEventAdd", array("CMainHandler", "OnBeforeEventAddHandler"));
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
}*/
