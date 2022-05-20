<x-client-layout>
	<x-slot name="header">
		<h2 class="font-semibold text-xl text-gray-800 leading-tight">
			{{ __('Apply RFQ') }}
		</h2>
	</x-slot>
	<div>
		<div class="max-w-7xl mx-auto py-10 sm:px-6 lg:px-8">
			<?/*php include resource_path() . '/views/client/rfq/jotform/jotform-rfq.html'; */?>
			<form id="payment-form" method="POST" action="{{ route('client.apply-rfq.store') }}" data-secret="{{ $intent->client_secret }}">
				@csrf
				<div class="mt-4">
					<input type="radio" name="plan" id="standard" value="price_1L0j7eElWv4kz27VPrADuDut" checked>
					<label for="standard">Quotation</label> <br>
				</div>
				<div id="payment-element">
					<!--Stripe.js injects the Payment Element-->
				</div>
				<button id="btnSubmit" class="bg-gray-900 text-white px-4 py-2 rounded">
					<div class="spinner hidden" id="spinner"></div>
					<span id="button-text">Pay now</span>
				</button>
				<div id="payment-message" class="hidden"></div>
    		</form>
		</div>
	</div>
	@push('scripts')
		<script src="https://js.stripe.com/v3/"></script>
		<!-- <script src="checkout.js" defer></script> -->
		<script>
			// This is your test publishable API key.
			const stripe = Stripe("pk_test_51IFXkJElWv4kz27VGINeyXJElMbSvRLdRZXPN9t35EIbB5M3DIK01eQYFVsGL51ET2saNpfLVetFteT7CVIBEG4u00Th297oRJ");

			// The items the customer wants to buy
			// const items = [{ id: "xl-tshirt" }];
			const items = [{ id: "price_1L0j7eElWv4kz27VPrADuDut" }];
			let elements;
			 // Create an instance of the card Element.
			
			var form = document.getElementById('payment-form');
			initialize();

			document
				.querySelector("#payment-form")
				.addEventListener("submit", handleSubmit);

			

			
			//original an async function
			function initialize() {
				// const { clientSecret } = await fetch("/create.php", {
				// 	method: "POST",
				// 	headers: { "Content-Type": "application/json" },
				// 	body: JSON.stringify({ items }),
				// }).then((r) => r.json());

				elements = stripe.elements({ 
					clientSecret :"{{ $intent->client_secret}}"
				});

				const paymentElement = elements.create("payment");
				paymentElement.mount("#payment-element");
				var cardElement = elements.create('card');
				// cardElement.mount('#card-element');
			}

			async function handleSubmit(e) {
				e.preventDefault();
				// setLoading(true);

				// const { paymentMethod ,error } = await stripe.confirmSetup({
				// 	elements,
				// 	confirmParams: {
				// 	// Make sure to change this to your payment completion page
				// 	return_url: "http://localhost:4242/public/checkout.html",
				// 	},
				// 	redirect: 'if_required'
				// });

				const { paymentMethod, error } = await stripe.createPaymentMethod(
					'card', cardElement, {
						billing_details: { name: cardHolderName.value }
					}
				);


				// This point will only be reached if there is an immediate error when
				// confirming the payment. Otherwise, your customer will be redirected to
				// your `return_url`. For some payment methods like iDEAL, your customer will
				// be redirected to an intermediate site first to authorize the payment, then
				// redirected to the `return_url`.
				if(error){
					if (error.type === "card_error" || error.type === "validation_error") {
					showMessage(error.message);
					} else {
						showMessage("An unexpected error occured.");
					}
				}else{
					// console.log(setupIntent)
					console.log(paymentMethod)
					

					// // Insert the token ID into the form so it gets submitted to the server
					// var form = document.getElementById('payment-form');
					// var hiddenInput = document.createElement('input');
					// hiddenInput.setAttribute('type', 'hidden');
					// hiddenInput.setAttribute('name', 'paymentMethod');
					// hiddenInput.setAttribute('value', paymentMethod.payment_method);
					// form.appendChild(hiddenInput);

					// // Submit the form
					// form.submit();
				}
				
				// setLoading(false);
			}

			// Fetches the payment intent status after payment submission
			// 	async function checkStatus() {
			// 	const clientSecret = new URLSearchParams(window.location.search).get(
			// 		"payment_intent_client_secret"
			// 	);

			// 	if (!clientSecret) {
			// 		return;
			// 	}

			// 	const { paymentIntent } = await stripe.retrievePaymentIntent(clientSecret);

			// 	switch (paymentIntent.status) {
			// 		case "succeeded":
			// 		showMessage("Payment succeeded!");
			// 		break;
			// 		case "processing":
			// 		showMessage("Your payment is processing.");
			// 		break;
			// 		case "requires_payment_method":
			// 		showMessage("Your payment was not successful, please try again.");
			// 		break;
			// 		default:
			// 		showMessage("Something went wrong.");
			// 		break;
			// 	}
			// }
			

			function showMessage(messageText) {
				const messageContainer = document.querySelector("#payment-message");

				messageContainer.classList.remove("hidden");
				messageContainer.textContent = messageText;

				setTimeout(function () {
					messageContainer.classList.add("hidden");
					messageText.textContent = "";
				}, 4000);
			}


		</script>
	@endpush
</x-client-layout>
