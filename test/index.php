<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetTitle("test");
?>

<?php

$email = COption::GetOptionString('main', 'email_from');
echo $email;


if (!CModule::IncludeModule('iblock')) {
    die('Ошибка загрузки модуля iblock');
};
//Получаем акции с истекшей датой активности, но со статусом АКТИВЕН в админке
$arSelect = ["ID", "NAME", "DATE_ACTIVE_FROM", 'DATE_ACTIVE_TO'];
$arFilter = [
    'IBLOCK_ID' => 5, //Акции
    "!ACTIVE_DATE"=>"Y", //магия!  Чтобы выбрать все не активные по датам элементы, используется такой синтаксис
    "ACTIVE" => "Y", // Статус акции - Активен, но фактически БХ игнорит, если дата активности истекла
];
$BDRes = CIBlockElement::GetList(false, $arFilter, false, false, $arSelect);
$arResult['FINISHED_ACTIONS'] = [];
while($arRes = $BDRes->GetNext())
{
    $arResult['FINISHED_ACTIONS'][$arRes['ID']] = $arRes;
}
//dump($arResult);
//Получаем акции с истекшей датой активности, но со статусом АКТИВЕН в админке

//Изменяем активность на НЕАКТИВЕН для акции с истекшей датой активности, но со статусом АКТИВЕН в админке
if (!empty($arResult['FINISHED_ACTIONS'])) {
    foreach ($arResult['FINISHED_ACTIONS'] as $Id => $action) {
        $el = new CIBlockElement;
        $arLoadProductArray = ["ACTIVE" => "N",];
        if (!($res = $el->Update($Id, $arLoadProductArray))) {
            echo $el->LAST_ERROR;
        } else {
            echo 'НЕАктивность акции c ID - ' . $Id . ' успешно ИЗМЕНЕНА в админке<br>';
        }
    }
}
//Изменяем активность на НЕАКТИВЕН для акции с истекшей датой активности, но со статусом АКТИВЕН в админке

//Получаем акции с истекшей датой активности, И со статусом НЕАКТИВЕН
$arSelect = ["ID", "NAME", "DATE_ACTIVE_FROM", 'DATE_ACTIVE_TO'];
$arFilter = [
    'IBLOCK_ID' => 5, //Акции
    "!ACTIVE_DATE"=>"Y", //магия!  Чтобы выбрать все не активные по датам элементы, используется такой синтаксис
    "ACTIVE" => "N", // Статус акции - НЕАктивен
];
$BDRes = CIBlockElement::GetList(false, $arFilter, false, false, $arSelect);
$arResult['FINISHED_ACTIONS'] = [];
while($arRes = $BDRes->GetNext())
{
    $arResult['FINISHED_ACTIONS'][$arRes['ID']] = $arRes;
}
dump($arResult);
//Получаем акции с истекшей датой активности, И со статусом НЕАКТИВЕН

//Получаем акции с истекшей датой активности, И со статусом НЕАКТИВЕН
$arSelect = ["ID", "NAME", "DATE_ACTIVE_FROM", 'DATE_ACTIVE_TO'];
$arFilter = [
    'IBLOCK_ID' => 5, //Акции
    "!ACTIVE_DATE"=>"Y", //магия!  Чтобы выбрать все не активные по датам элементы, используется такой синтаксис
    "ACTIVE" => "N", // Статус акции - НЕАктивен
];
$res = CIBlockElement::GetList(false, $arFilter, false, false, $arSelect);
while($ob = $res->GetNextElement())
{
    $arField = $ob->getFields();
    dump($arField);
}
//Получаем акции с истекшей датой активности, И со статусом НЕАКТИВЕН



?>


<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>