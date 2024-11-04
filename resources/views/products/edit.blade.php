
<h1>Edit Product</h1>
<form action="{{ route('products.update', $product->id) }}" method="POST">
    @csrf
    @method('PUT')
    <label>Product ID: <input type="text" name="product_id" value="{{ $product->product_id }}" required></label>
    <label>Name: <input type="text" name="name" value="{{ $product->name }}" required></label>
    <label>Description: <textarea name="description">{{ $product->description }}</textarea></label>
    <label>Price: <input type="text" name="price" value="{{ $product->price }}" required></label>
    <label>Stock: <input type="text" name="stock" value="{{ $product->stock }}"></label>
    <label>Image URL: <input type="text" name="image" value="{{ $product->image }}"></label>
    <button type="submit">Update</button>
</form>
