<?php
/**
 * Created by PhpStorm.
 * User: hungtran
 * Date: 5/10/16
 * Time: 2:39 PM
 *
 * $data array, data of slider.
 * $autoplay integer, in millisecond. If 0 not sliding on start
 * $transition integer, speed in millisecond when slider rotating.
 */
?>
<div class="main-slider">
    <div class="slider-inner loading-slider">
        <?php
        if ($data) {
            foreach ($data as $item) {
                $urlImage = $item['image']['url'];
                $intro = $item['intro'];
                $btnText = $item['button_text'];
                $btnLink = $item['button_link'];
                ?>
                <div class="slider-item"
                     style="background: url(<?php echo $urlImage ?>) no-repeat center;background-size: cover">
                    <table>
                        <tr>
                            <td>
                                <div class="slider-item-inner">
                                    <?php
                                    if(!empty($intro)){
                                        ?>
                                        <div class="intro"><?php echo $intro ?></div>
                                        <?php
                                    }
                                    if($btnLink){
                                        ?>
                                        <div class="button">
                                            <a href="<?php echo $btnLink ?>"><?php echo $btnText ?></a>
                                        </div>
                                        <?php
                                    }
                                    ?>

                                </div>
                            </td>
                        </tr>
                    </table>
                </div>
                <?php
            }
        }
        ?>
    </div>
    <input id="autoplay" type="hidden" value="<?php echo $autoplay ?>">
    <input id="transition" type="hidden" value="<?php echo $transition ?>">
</div>
