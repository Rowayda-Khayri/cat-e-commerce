    <div class="container">
        <h1>Transaction Result</h1>

        @if($transactionResult === 'success')
            <div class="alert alert-success">
                Payment Successful
            </div>
        @else
            <div class="alert alert-danger">
                Payment Failed: Your credit isn't enough!
            </div>
            <p>Total Price: ${{ $totalPrice }}</p>
            <p>Your Credit Now: ${{ $userCredit }}</p>
            <a href="{{ route('cart') }}" class="btn btn-primary">View Cart</a>
        @endif

        <a href="{{ route('store') }}" class="btn btn-primary">Back to Store</a>
    </div>
