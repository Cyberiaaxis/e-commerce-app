@extends('Staff.layouts.staff')

@section('title', 'Order create')

@section('content')
<div class="container">
    <h2>Create New Order</h2>

    <form action="{{ route('orders.store') }}" method="POST">
        @csrf

        <!-- Order Items (Dynamic Fields for Multiple Items) -->
        <h3>Order Items</h3>
        <div id="order-items">
            <div class="order-item">
                <div class="form-group">
                    <label for="product_id">Product</label>
                    <select name="order_items[0][product_id]" class="form-control product-select" data-index="0" required>
                        <option value="" data-price="0" selected>Select Product</option>
                        @foreach ($products as $product)
                        <option value="{{ $product->id }}" data-price="{{ $product->price }}">
                            {{ $product->name }} - ${{ $product->price }}
                        </option>
                        @endforeach
                    </select>
                </div>

                <div class="form-group">
                    <label for="quantity">Quantity</label>
                    <input type="number" name="order_items[0][quantity]" class="form-control quantity-input" data-index="0" required min="1" value="1">
                </div>

                <div class="form-group">
                    <label for="discount_code">Discount Code</label>
                    <select name="order_items[0][discount_code]" class="form-control discount-code-select" data-index="0">
                        <option value="" data-discount="0" title="No discount selected">Select Discount Code</option>
                    </select>
                </div>
            </div>
        </div>

        <!-- Button to Add More Order Items -->
        <button type="button" class="btn btn-secondary" id="add-item-btn">Add Item</button>

        <!-- Order Information -->
        <div class="form-group">
            <div class="row">
                <div class="col-md-4">
                    <label>Total Amount:</label>
                    <p id="display-total-amount">$0.00</p>
                    <input type="hidden" name="total_amount" class="form-control" value="0">
                </div>
                <div class="col-md-4">
                    <label>Discount Amount:</label>
                    <p id="display-discount-amount">$0.00</p>
                    <input type="hidden" name="discount_amount" class="form-control" value="0">
                </div>
                <div class="col-md-4">
                    <label>Final Amount:</label>
                    <p id="display-final-amount">$0.00</p>
                    <input type="hidden" name="final_amount" class="form-control" value="0">
                </div>
            </div>
        </div>

        <div class="form-group">
            <label for="payment_type">Payment Type</label>
            <select name="payment_type" class="form-control">
                <option value="cod">Cash on Delivery</option>
                <option value="online">Online</option>
            </select>
        </div>

        <div class="form-group">
            <label for="payment_status">Payment Status</label>
            <select name="payment_status" class="form-control">
                <option value="pending">Pending</option>
                <option value="paid">Paid</option>
                <option value="refunded">Refunded</option>
                <option value="failed">Failed</option>
            </select>
        </div>

        <div class="form-group">
            <label for="delivery_status">Delivery Status</label>
            <select name="delivery_status" class="form-control">
                <option value="pending">Pending</option>
                <option value="shipped">Shipped</option>
                <option value="delivered">Delivered</option>
                <option value="returned">Returned</option>
                <option value="canceled">Canceled</option>
            </select>
        </div>

        <!-- Submit Button -->
        <button type="submit" class="btn btn-primary">Create Order</button>
    </form>
</div>

<script>
    let itemIndex = 1;

    // Add new order item dynamically
    document.getElementById('add-item-btn').addEventListener('click', function() {
        const orderItemsDiv = document.getElementById('order-items');
        const newItemDiv = document.createElement('div');
        newItemDiv.classList.add('order-item');

        newItemDiv.innerHTML = `
            <div class="form-group">
                <label for="product_id">Product</label>
                <select name="order_items[${itemIndex}][product_id]" class="form-control product-select" data-index="${itemIndex}" required>
                    <option value="" data-price="0" selected>Select Product</option>
                    @foreach ($products as $product)
                        <option value="{{ $product->id }}" data-price="{{ $product->price }}">
                            {{ $product->name }} - '$'{{ $product->price }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="form-group">
                <label for="quantity">Quantity</label>
                <input type="number" name="order_items[${itemIndex}][quantity]" class="form-control quantity-input" data-index="${itemIndex}" required min="1" value="1">
            </div>

            <div class="form-group">
                <label for="discount_code">Discount Code</label>
                <select name="order_items[${itemIndex}][discount_code]" class="form-control discount-code-select" data-index="${itemIndex}">
                    <option value="" data-discount="0" title="No discount selected">Select Discount Code</option>
                </select>
            </div>
        `;
        orderItemsDiv.appendChild(newItemDiv);
        itemIndex++;
    });

    // Update amounts dynamically
    function updateAmounts() {
        let totalAmount = 0;
        let totalDiscount = 0;

        // Loop through each order item
        document.querySelectorAll('.order-item').forEach((item) => {
            const productSelect = item.querySelector('.product-select');
            const quantityInput = item.querySelector('.quantity-input');
            const discountSelect = item.querySelector('.discount-code-select');

            const price = parseFloat(productSelect.options[productSelect.selectedIndex]?.dataset?.price || 0);
            const quantity = parseInt(quantityInput.value || 0);
            const discountPercentage = parseFloat(discountSelect.options[discountSelect.selectedIndex]?.dataset?.discount || 0);

            const itemTotal = price * quantity; // Total price for the item
            const itemDiscount = (itemTotal * discountPercentage) / 100; // Discount for the item

            totalAmount += itemTotal; // Accumulate total amount
            totalDiscount += itemDiscount; // Accumulate total discount
        });

        // Update total amount
        document.querySelector('#display-total-amount').textContent = `$${totalAmount.toFixed(2)}`;
        document.querySelector('input[name="total_amount"]').value = totalAmount.toFixed(2);

        // Update discount amount
        document.querySelector('#display-discount-amount').textContent = `$${totalDiscount.toFixed(2)}`;
        document.querySelector('input[name="discount_amount"]').value = totalDiscount.toFixed(2);

        // Update final amount
        const finalAmount = totalAmount - totalDiscount;
        document.querySelector('#display-final-amount').textContent = `$${finalAmount.toFixed(2)}`;
        document.querySelector('input[name="final_amount"]').value = finalAmount.toFixed(2);
    }

    // Function to fetch the discount for a selected product
    function fetchDiscount(productId, index) {
        fetch(`/product/${productId}/discount`)
            .then(response => response.json())
            .then(data => {
                const discountSelect = document.querySelector(`.discount-code-select[data-index="${index}"]`);
                discountSelect.innerHTML = '<option value="" data-discount="0" title="No discount selected">Select Discount Code</option>';

                // Populate discount options
                data.forEach(discount => {
                    const option = document.createElement('option');
                    option.value = discount.code;
                    option.dataset.discount = discount.value;
                    option.title = discount.description || `Apply ${discount.value}% off`;
                    option.textContent = `${discount.code} - ${discount.value}% Off`;
                    discountSelect.appendChild(option);
                });

                updateAmounts();
            })
            .catch(error => console.error('Error fetching discount:', error));
    }

    // Event listener for product selection to fetch discount
    document.addEventListener('change', function(event) {
        if (event.target.classList.contains('product-select')) {
            const index = event.target.getAttribute('data-index');
            const productId = event.target.value;
            if (productId) {
                fetchDiscount(productId, index); // Fetch discount for the selected product
            }
        }

        if (
            event.target.classList.contains('product-select') ||
            event.target.classList.contains('quantity-input') ||
            event.target.classList.contains('discount-code-select')
        ) {
            updateAmounts(); // Update the amounts when any of these fields change
        }
    });

    // Trigger amounts update on page load
    document.addEventListener('DOMContentLoaded', updateAmounts);
</script>
@endsection