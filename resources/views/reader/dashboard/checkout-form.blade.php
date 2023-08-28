<div class="row g-5">
    <div class="col-md-5 col-lg-4 order-md-last">
        <h4 class="d-flex justify-content-between align-items-center mb-3">
            <span class="text-primary">Your cart</span>
            <span class="badge bg-primary rounded-pill">3</span>
        </h4>
        <ul class="list-group mb-3" id="cart-items">
            <li class="list-group-item d-flex justify-content-between lh-sm gap-3">
                <div class="col-auto" id="mage">
                    <img src="img/book.jpg" aria-label="image" class="rounded p-1 bg-secondary" width="64">
                </div>
                <div class="col">
                    <div class="h6 my-0 d-flex align-items-baseline justify-content-between">
                        <span class="w-65 line-clamp-2">Dr. Marcelina Ondricka III Loaf that there is</span>
                        <span class="text-body-secondary small text-end"><span id="price">155.99</span> TMT</span>
                    </div>
                    <div class="text-body-secondary small">
                        <div>Total: 6 days</div>
                        <div>Return date: Jun 22, 2024</div>
                        <a href="#" class="bi-pencil-square"> Change terms</a>
                    </div>
                </div>
            </li>
        </ul>

        <form class="card p-2">
            <div class="input-group">
                <input type="text" class="form-control form-control-sm" placeholder="Promo code">
                <button type="submit" class="btn btn-secondary">Redeem</button>
            </div>
        </form>
    </div>
    <div class="col-md-7 col-lg-8">
        <h4 class="mb-3">Billing address</h4>
        <form class="needs-validation" novalidate>
            <div class="row g-3">
                <div class="col-sm-6">
                    <label for="firstName" class="form-label">First name</label>
                    <input type="text" class="form-control form-control-sm" id="firstName" placeholder="" value="" required>
                    <div class="invalid-feedback">
                        Valid first name is required.
                    </div>
                </div>

                <div class="col-sm-6">
                    <label for="lastName" class="form-label">Last name</label>
                    <input type="text" class="form-control form-control-sm" id="lastName" placeholder="" value="" required>
                    <div class="invalid-feedback">
                        Valid last name is required.
                    </div>
                </div>

                <div class="col-12">
                    <label for="username" class="form-label">Mobile</label>
                    <div class="input-group has-validation">
                        <span class="input-group-text">+993</span>
                        <input type="text" class="form-control form-control-sm" id="username" placeholder="phone number" required>
                        <div class="invalid-feedback">
                            Your phone is required.
                        </div>
                    </div>
                </div>

                <div class="col-12">
                    <label for="email" class="form-label">Email <span class="text-body-secondary">(Optional)</span></label>
                    <input type="email" class="form-control form-control-sm" id="email" placeholder="you@example.com">
                    <div class="invalid-feedback">
                        Please enter a valid email address for shipping updates.
                    </div>
                </div>

                <div class="col-12">
                    <label for="address" class="form-label">Address</label>
                    <input type="text" class="form-control form-control-sm" id="address" placeholder="1234 Main St" required>
                    <div class="invalid-feedback">
                        Please enter your shipping address.
                    </div>
                </div>

                <div class="col-12">
                    <label for="address2" class="form-label">Address 2 <span class="text-body-secondary">(Optional)</span></label>
                    <input type="text" class="form-control form-control-sm" id="address2" placeholder="Apartment or suite">
                </div>

                <div class="col-md-5">
                    <label for="country" class="form-label">Region</label>
                    <select class="form-select form-select-sm" id="region" required>
                        <option value="">Choose...</option>
                        <option>United States</option>
                    </select>
                    <div class="invalid-feedback">
                        Please select a valid region.
                    </div>
                </div>

                <div class="col-md-4">
                    <label for="state" class="form-label">City/District</label>
                    <select class="form-select form-select-sm" id="city-district" required>
                        <option value="">Choose...</option>
                        <option>California</option>
                    </select>
                    <div class="invalid-feedback">
                        Please provide a valid state.
                    </div>
                </div>

                <div class="col-md-3">
                    <label for="zip" class="form-label">Zip</label>
                    <input type="text" class="form-control form-control-sm" id="zip" placeholder="6 digits" required>
                    <div class="invalid-feedback">
                        Zip code required.
                    </div>
                </div>
            </div>

            <hr class="my-4">

            <div class="form-check">
                <input type="checkbox" class="form-check-input" id="same-address">
                <label class="form-check-label" for="same-address">Shipping address is the same as my billing address</label>
            </div>

            <div class="form-check">
                <input type="checkbox" class="form-check-input" id="save-info">
                <label class="form-check-label" for="save-info">Save this information for next time</label>
            </div>

            <hr class="my-4">

            <h4 class="mb-3">Payment</h4>

            <div class="my-3">
                <div class="form-check">
                    <input id="credit" name="paymentMethod" type="radio" class="form-check-input" checked required>
                    <label class="form-check-label" for="credit">Credit card</label>
                </div>
                <div class="form-check">
                    <input id="debit" name="paymentMethod" type="radio" class="form-check-input" required>
                    <label class="form-check-label" for="debit">Debit card</label>
                </div>
                <div class="form-check">
                    <input id="paypal" name="paymentMethod" type="radio" class="form-check-input" required>
                    <label class="form-check-label" for="paypal">PayPal</label>
                </div>
            </div>

            <div class="row gy-3">
                <div class="col-md-6">
                    <label for="cc-name" class="form-label">Name on card</label>
                    <input type="text" class="form-control form-control-sm" id="cc-name" placeholder="" required>
                    <small class="text-body-secondary">Full name as displayed on card</small>
                    <div class="invalid-feedback">
                        Name on card is required
                    </div>
                </div>

                <div class="col-md-6">
                    <label for="cc-number" class="form-label">Credit card number</label>
                    <input type="text" class="form-control form-control-sm" id="cc-number" placeholder="" required>
                    <div class="invalid-feedback">
                        Credit card number is required
                    </div>
                </div>

                <div class="col-md-3">
                    <label for="cc-expiration" class="form-label">Expiration</label>
                    <input type="text" class="form-control form-control-sm" id="cc-expiration" placeholder="" required>
                    <div class="invalid-feedback">
                        Expiration date required
                    </div>
                </div>

                <div class="col-md-3">
                    <label for="cc-cvv" class="form-label">CVV</label>
                    <input type="text" class="form-control form-control-sm" id="cc-cvv" placeholder="" required>
                    <div class="invalid-feedback">
                        Security code required
                    </div>
                </div>
            </div>

            <hr class="my-4">

            <button class="w-100 btn btn-primary btn-lg" type="submit">Continue to checkout</button>
        </form>
    </div>
</div>

