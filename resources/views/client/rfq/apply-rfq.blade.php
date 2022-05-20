<x-client-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Charge
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                Loop here
                <!-- <?php foreach ($rfqsInfo as $rfqinfo):?>
                        {{$rfqinfo->project_name}}
                    <p>
                <?php endforeach;?> -->

                <div class="p-6">
                    <form action="{{ route('client.apply-rfq.store') }}" method="post" id="payment-form">
                        @csrf
                        <div>
                            Product Name and Price and description goes here
                        </div>
                        <div>
                            <div class="form-fields-container">
                                <div>
                                    <label for="client-name">Name</label>
                                    <div>
                                        <input type="text" id="client-name" class="px-2 py-2 border">
                                    </div>
                                </div>
                                <div>
                                    <label for="client-phone">Phone</label>
                                    <div>
                                        <input type="text" id="client-phone" class="px-2 py-2 border">
                                    </div>
                                </div>
                            </div>
                            <div class="form-fields-container">
                                <div>
                                    <label for="client-email">Email</label>
                                    <div>
                                        <input type="text" id="client-email" class="px-2 py-2 border">
                                    </div>
                                </div>
                                <div>
                                    <label for="client-company-name">Company Name</label>
                                    <div>
                                        <input type="text" id="client-company-name" class="px-2 py-2 border">
                                    </div>
                                </div>
                            </div>
                            <div class="form-fields-container">
                                <div>
                                    <label for="client-company-address">Company Address</label>
                                    <div>
                                        <input type="text" id="client-company-address" class="px-2 py-2 border">
                                    </div>
                                </div>
                                <div>
                                    <label for="client-project-name">Project Name</label>
                                    <div>
                                        <input type="text" id="client-project-name" class="px-2 py-2 border">
                                    </div>
                                </div>
                            </div>
                            <div class="form-fields-container">
                                <div>
                                    <label for="client-project-requirements">Project Requirements</label>
                                    <div>
                                        <input type="text" id="client-project-requirements" class="px-2 py-2 border">
                                    </div>
                                </div>
                                <div>
                                    <label for="client-expected-budget">Expected Budget</label>
                                    <div>
                                        <input type="text" id="client-expected-budget" class="px-2 py-2 border">
                                    </div>
                                </div>
                            </div>
                            <div class="form-fields-container">
                                <div>
                                    <label for="client-notes">Notes</label>
                                    <div>
                                        <input type="text" id="client-notes" class="px-2 py-2 border">
                                    </div>
                                </div>
                                <div>
                                    <label for="cardholder-name">Cardholder's Name</label>
                                    <div>
                                        <input type="text" id="cardholder-name" class="px-2 py-2 border">
                                    </div>
                                </div>
                            </div>

                            <label for="card-element">
                                Credit or debit card
                            </label>
                            <div id="card-element">
                                <!-- A Stripe Element will be inserted here. -->
                            </div>

                            <!-- Used to display form errors. -->
                            <div id="card-errors" role="alert"></div>
                        </div>

                        <x-jet-button class="mt-4">
                            Buy Quotations
                        </x-jet-button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    @push('scripts')
        <script src="https://js.stripe.com/v3/"></script>

        <script>
            // Create a Stripe client.
            var stripe = Stripe('pk_test_51IFXkJElWv4kz27VGINeyXJElMbSvRLdRZXPN9t35EIbB5M3DIK01eQYFVsGL51ET2saNpfLVetFteT7CVIBEG4u00Th297oRJ');

            // Create an instance of Elements.
            var elements = stripe.elements();
            // checkStatus()

            // Custom styling can be passed to options when creating an Element.
            // (Note that this demo uses a wider set of styles than the guide below.)
            var style = {
                base: {
                    color: '#32325d',
                    fontFamily: '"Helvetica Neue", Helvetica, sans-serif',
                    fontSmoothing: 'antialiased',
                    fontSize: '16px',
                    '::placeholder': {
                    color: '#aab7c4'
                    }
                },
                invalid: {
                    color: '#fa755a',
                    iconColor: '#fa755a'
                }
            };

            // Create an instance of the card Element.
            var card = elements.create('card', {hidePostalCode: true, style: style});

            // Add an instance of the card Element into the `card-element` <div>.
            card.mount('#card-element');
            // Handle real-time validation errors from the card Element.
            card.on('change', function(event) {
            var displayError = document.getElementById('card-errors');
                if (event.error) {
                    displayError.textContent = event.error.message;
                } else {
                    displayError.textContent = '';
                }
            });

            // Handle form submission.
            var form = document.getElementById('payment-form');
            var cardHolderName = document.getElementById('cardholder-name');

            form.addEventListener('submit', async function(event) {
                event.preventDefault();

                const { paymentMethod, error } = await stripe.createPaymentMethod(
                    'card', card, {
                        billing_details: { 
                            name: cardHolderName.value,
                        },
                        // metadata: {
                        //         "meta1": 'testing123' ,
                        //         "meta2": "testing321"
                        // }
                    }
                );

                if (error) {
                    // Inform the user if there was an error.
                    var errorElement = document.getElementById('card-errors');
                    errorElement.textContent = error.message;
                } else {
                    // Send the token to your server.
                    // console.log(paymentMethod.id);

                    stripeTokenHandler(paymentMethod);
                }

                // stripe.createToken(card).then(function(result) {
                //     if (result.error) {
                //     // Inform the user if there was an error.
                //     var errorElement = document.getElementById('card-errors');
                //     errorElement.textContent = result.error.message;
                //     } else {
                //     // Send the token to your server.
                //     stripeTokenHandler(result.token);
                //     }
                // });
            });

            // Submit the form with the token ID.
            function stripeTokenHandler(paymentMethod) {
                // Insert the token ID into the form so it gets submitted to the server
                var form = document.getElementById('payment-form');
                var hiddenInput = document.createElement('input');
                hiddenInput.setAttribute('type', 'hidden');
                hiddenInput.setAttribute('name', 'paymentMethod');
                hiddenInput.setAttribute('value', paymentMethod.id);
                form.appendChild(hiddenInput);

                // Submit the form
                form.submit();
            }

            // async function checkStatus() {
            //     const clientSecret = new URLSearchParams(window.location.search).get(
            //         "payment_intent_client_secret"
            //     );
            //     stripe.retrievePaymentIntent(clientSecret).then(function(response) {
            //         if (response.paymentIntent && response.paymentIntent.status === 'succeeded') {
            //             console.log("Successful payment!!!");
            //         } else {
            //             // Handle unsuccessful, processing, or canceled payments and API errors here
            //             console.log("Failed payment!!!");
            //         }
            //     });
            // }

                

        </script>
    @endpush
</x-client-layout>
