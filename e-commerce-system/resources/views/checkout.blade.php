    <div class="container">
        <h1>Checkout</h1>

        <form method="post" action="{{ route('checkout.process') }}">
            @csrf

            <div class="form-group">
                <label for="address">Address</label>
                <input type="text" name="address" id="address" class="form-control" required>
            </div>

            <div class="form-group">
                <label for="telephone">Telephone</label>
                <input type="tel" name="telephone" id="telephone" class="form-control" required>
            </div>

            <button type="submit" class="btn btn-success">Place Order</button>
        </form>

        <a href="{{ route('cart') }}" class="btn btn-primary">Back to Cart</a>
    </div>
