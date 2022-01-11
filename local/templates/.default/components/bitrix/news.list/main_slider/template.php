<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>
<script>
	$().ready(function(){
		$(function(){
			$('#slides').slides({
				preload: false,
				generateNextPrev: false,
				autoHeight: true,
				play: 4000,
				effect: 'fade'
			});
		});
	});
</script>
<div class="sl_slider" id="slides">
	<div class="slides_container">
		<?foreach($arResult["ITEMS"] as $arItem):?>
		<div>
			<div>

				<?if(is_array($arItem["PREVIEW_PICTURE"])):?>
				    <img src="<?=$arItem["PREVIEW_PICTURE"]["SRC"]?>" alt="" />
                <? elseif ($arItem["PROPERTIES"]['LINK']['VALUE']): ?>
                    <img src="<?=
                    $arResult['LINK_ELEMENT'][$arItem["PROPERTIES"]['LINK']['VALUE']]['PREVIEW_PICTURE']['src']
                    ?>" alt="" />
				<?endif;?>

				<h2><a href="<?=
                    $arResult['LINK_ELEMENT'][$arItem["PROPERTIES"]['LINK']['VALUE']]['DETAIL_PAGE_URL']
                    ?>"><?echo $arItem["NAME"]?></a></h2>
				<p><?echo $arItem["PREVIEW_TEXT"];?></p>
                <p><?= $arResult['LINK_ELEMENT'][$arItem["PROPERTIES"]['LINK']['VALUE']]['NAME'] ?>
                    по старой цене в <?=
                    number_format($arResult['LINK_ELEMENT'][$arItem["PROPERTIES"]['LINK']['VALUE']]['PROPERTY_PRICE_VALUE'], 0, ',', ' ' ) . ' руб.'
                    ?>
                    теперь можно приобрести всего за <?=
                    number_format($arItem['PROPERTIES']['PRICE']['VALUE'], 0, ',', ' ' ) . ' руб.'
                    ?>
                </p>
                <a href="<?=
                $arResult['LINK_ELEMENT'][$arItem["PROPERTIES"]['LINK']['VALUE']]['DETAIL_PAGE_URL']
                ?>" class="sl_more" title="<?= $arResult['LINK_ELEMENT'][$arItem["PROPERTIES"]['LINK']['VALUE']]['NAME'] ?>">Подробнее &rarr;</a>
			</div>
		</div>
		<?endforeach;?>
	</div>
</div>

