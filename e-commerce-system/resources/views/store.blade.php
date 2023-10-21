 <h1>All Store Items</h1>

    <div class="store-items">
        @foreach($items as $item)
            <div class="item">
                <h2>{{ $item->name }}</h2>
                <p>{{ $item->description }}</p>
                <p>Price: ${{ $item->price }}</p>
                <form action="{{ route('addToCart', ['item' => $item->id]) }}" method="post">
                    @csrf
                    <label for="quantity">Quantity:</label>
                    <input type="number" name="quantity" value="0" min="0">
                    <button type="submit">Add to Cart</button>
                </form>
            </div>
        @endforeach
    </div>

{{-- Add a link to the "View Cart" page --}}
<a href="{{ route('viewCart') }}">View Cart</a>