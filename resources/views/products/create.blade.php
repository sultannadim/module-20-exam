
<h1>Create Product</h1>
<form action="{{ route('products.store') }}" method="POST">
    @csrf
    <label>Product ID: <input type="text" name="product_id" required></label>
    <label>Name: <input type="text" name="name" required></label>
    <label>Description: <textarea name="description"></textarea></label>
    <label>Price: <input type="text" name="price" required></label>
    <label>Stock: <input type="text" name="stock"></label>
    <label>Image URL: <input type="text" name="image"></label>
    <button type="submit">Save</button>
</form>
