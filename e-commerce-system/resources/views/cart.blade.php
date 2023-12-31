    <div class="container">
        <h1>Your Cart</h1>

        @if(count($cartItems) > 0)
            <table class="table">
                <thead>
                    <tr>
                        <th>Item</th>
                        <th>Quantity</th>
                        <th>Total Item Price</th>
                        <th>Action</th> {{-- New column for the Remove link --}}
                    </tr>
                </thead>
                <tbody>
                    @foreach($cartItems as $item)
                        <tr>
                            <td>{{ $item->name }}</td>
                            <td>{{ $item->pivot->quantity }}</td>
                            <td>{{ $item->price * $item->pivot->quantity }}</td>
                            <td>
                                <a href="{{ route('removeItemFromCart', ['itemId' => $item->id]) }}" class="btn btn-danger">Remove</a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @else
            <p>Your cart is empty.</p>
        @endif

        <a href="{{ route('store') }}" class="btn btn-primary">Continue Shopping</a>
        <a href="{{ route('checkout') }}" class="btn btn-success">Checkout</a>
    </div>
