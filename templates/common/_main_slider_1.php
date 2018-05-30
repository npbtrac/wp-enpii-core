<?php
/**
 * Created by PhpStorm.
 * Author: npbtrac@yahoo.com
 * Date time: 12/4/17 4:03 PM
 */

/* @var array $slider_data */
! empty( $slider_data ) || $slider_data = [];
?>

<?php
if ( ! empty( $slider_data ) ) {
	?>
	<div class="main-slider">
		<div class="main-slider-inner">
			<div class="carousel-instance">
				<?php
				foreach ( $slider_data as $key => $slider_item ) {
					if ( ! empty( $slider_item['image'] ) ) {
						?>
						<div class="slider-item item-<?= $key ?>">
							<div class="slider-item-inner">
								<div class="slider-item-image">
									<img src="<?= esc_attr( $slider_item['image']['url'] ) ?>"
										 alt="<?= esc_attr( $slider_item['title'] ) ?>"/>
								</div>
								<div class="slider-item-overlay">
									<div class="slider-item-title">
										<h3><?= esc_html( $slider_item['title'] ) ?></h3>
									</div>
									<div class="slider-item-intro">
										<?= nl2br( esc_html( $slider_item['intro'] ) ) ?>
									</div>
									<?php
									if ( ! empty( $slider_item['button_link'] ) && ! empty( $slider_item['button_text'] ) ) {
										?>
										<div class="slider-item-button">
											<a href="<?= esc_attr( $slider_item['button_link'] ) ?>"><?= esc_html( nl2br( $slider_item['button_text'] ) ) ?></a>
										</div>
										<?php
									}
									?>
								</div>
							</div>
						</div>
						<?php
					}
				}
				?>
			</div>
			<div class="slider-pagers"></div>
		</div>
	</div>
	<?php
}