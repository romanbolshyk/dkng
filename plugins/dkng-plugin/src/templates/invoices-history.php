<?php
/*
 * Template Name: History of Invoices
 */

get_header('custom');
?>
	<div class="inner_container invoices_block">
		<div class="container">
			<div class="row">
				<div class="col">
					<div class="inner_content">
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<?php if ( is_user_logged_in() ) {
	$user     = wp_get_current_user();
	$customer = rcp_get_customer_by_user_id( $user->ID );
	if ( $customer ) {
		$payments = $customer->get_payments();

		global $rcp_options;
		$secret = $rcp_options['stripe_live_secret'];
		$stripe = new \Stripe\StripeClient(
			$secret
		);

		// Check if payments exist in site Database
		if ( $payments ) {

			// Check if payments exist in Stripe
			foreach ( $payments as $key => $payment ) {
				$transaction_id = $payment->transaction_id;
				if ( strpos( $transaction_id, 'sub_' ) === 0 ) {
					unset( $payments[ $key ] );
					continue;
				}

				try {
					$charges[ $key ] = $stripe->charges->retrieve(
						$payment->transaction_id,
						[]
					);
				} catch ( Exception $e ) {
					unset( $payments[ $key ] );
					continue;
				}

			}

			if ( count( $payments ) > 0 ) {
				?>
				<div class="container invoice-page">
					<div class="sv-section">
					<div class="sv-filter-table-wrap">
						<table class="sv-filter-table">
							<thead>
							<tr>
								<th><div class="sv-filter-table__th"><?php echo __( 'Date', 'dkng' ); ?></div></th>
								<th><div class="sv-filter-table__th"><?php echo __( 'Amount', 'dkng' ); ?></div></th>
								<th><div class="sv-filter-table__th"><?php echo __( 'Status', 'dkng' ); ?></div></th>
								<th><div class="sv-filter-table__th"><?php echo __( 'Invoice Number', 'dkng' ); ?></div></th>
								<th><div class="sv-filter-table__th"><?php echo __( 'PDF', 'dkng' ); ?></div></th>
							</tr>
							</thead>
							<tbody>
							<?php
							foreach ( $payments as $key => $payment ) {
								$receipt_url = $charges[ $key ]->receipt_url;

								$date_with_time = $payment->date;
								$date_with_time = explode( ' ', $date_with_time );
								$date           = $date_with_time[0];
								echo '<tr>';
								echo '<th><div class="sv-filter-table__td">' . date('m/d/Y', strtotime($date)) . '</div></th>';
								echo '<th><div class="sv-filter-table__td">$' . $payment->amount . '</div></th>';
								echo '<th><div class="sv-filter-table__td">' . $payment->status . '</div></th>';
								echo '<th><div class="sv-filter-table__td">' . $payment->id . '</div></th>';
								echo '<th><div class="sv-filter-table__td"><a href="' . $receipt_url . '" target="_blank">' . __('Download', 'dkng') . '</a></div></th>';
								echo '<tr>';
							}
							?>
							</tbody>
						</table>
					</div>
					</div>
				</div>
				<?php
			} else {?>
	<div class="container invoice-page">
		<div class="sv-section">
			<div class="sv-filter-table-wrap"><h2 class="text-center mb-0">
				<?php
				// Nothing to show. Payments do not exist in Stripe dashboard.
				echo __( 'Nothing to show. Payments do not exist in Stripe dashboard.', 'dkng' );
			}?>
			</h2>
			</div>
			</div>
			</div>
			<?php

		} else {?>
		<div class="container invoice-page">
			<div class="sv-section">
				<div class="sv-filter-table-wrap"><h2 class="text-center mb-0">
					<?php // Nothing to show. Payments do not exist.
					echo __( 'Nothing to show. Payments do not exist.', 'dkng' );
					?>
					</h2>
				</div>
			</div>
		</div>
		<?php }
	} else {?>
	<div class="container invoice-page">
		<div class="sv-section">
			<div class="sv-filter-table-wrap"><h2 class="text-center mb-0">
				<?php // You are not customer.
				echo __( 'You are not customer.', 'dkng' );?>
				</h2>
			</div>
		</div>
	</div>
		<?php
	}

} else { ?>
	<div class="container invoice-page">
		<div class="sv-section">
			<div class="sv-filter-table-wrap"><h2 class="text-center mb-0">
				<?php // You are not logged in.
				echo __( 'Login to your dashboard to access this page.', 'dkng' );?>
				</h2>
			</div>
		</div>
	</div>
<?php
}

get_footer( 'custom' );
