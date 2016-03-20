<div class="cart site-page page">
	<div class="cart-inner responsive-inner">
		<div class="cart-top page-top">
			<div class="cart-icon page-icon">
				<span class="icomoon">&#xe93a;</span>
			</div>
			<div class="cart-text page-text">
				Shopping Cart
			</div>
		</div>
		<div class="cart-main page-main">
			<?php foreach ($cart as $item) { ?>
			<div class="cart-item">
				<div class="cart-item-text">
					<strong><?= $item[1] ?></strong>
				</div>
				<div class="cart-price">
					$<?= $item[0] ?>
				</div>
				<div class="cart-actions">
					<a href="" class="caps">remove</a>
				</div>
				<div class="cart-item-text">
					<?= $item[3] ?>. <?= $item[4] ?>. <?= $item[2] ?>, Seat <?= $item[5] ?>
				</div>
			</div>
			<?php } ?>

			<div class="cart-total">
				<div class="cart-total-pretax">
					Pre-Tax: $<?= $pre_tax ?>
				</div>
				<div class="cart-total-pretax">
					Tax: $<?= $tax ?>
				</div>
				<div class="cart-total-pretax">
					<strong>Total: $<?= $total ?></strong>
				</div>
			</div>

			<div class="cart-checkout">
				<div class="button call-to-action">
					<a href="<?= $this->Url->build("/checkout/") ?>">Proceed to Checkout</a>
				</div>
			</div>
		</div>
	</div>
</div>