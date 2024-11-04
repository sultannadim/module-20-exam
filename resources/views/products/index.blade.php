<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Product List</title>
    <style>
        /* Basic styling for table, form, and pagination */
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
        }
        h1 {
            margin-bottom: 20px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        table, th, td {
            border: 1px solid #ddd;
        }
        th, td {
            padding: 10px;
            text-align: left;
        }
        th a {
            color: inherit;
            text-decoration: none;
        }
        form {
            margin-bottom: 20px;
        }
        form input[type="text"] {
            padding: 5px;
            width: 300px;
        }
        form button {
            padding: 5px 10px;
        }
        .pagination {
            display: flex;
            list-style-type: none;
            padding: 0;
        }
        .pagination li {
            margin: 0 5px;
        }
        .pagination a, .pagination span {
            padding: 5px 10px;
            border: 1px solid #ddd;
            color: #333;
            text-decoration: none;
        }
        .pagination .active span {
            background-color: #333;
            color: #fff;
        }
    </style>
</head>
<body>

    <h1>Product List</h1>

    <!-- Search Form -->
    <form action="{{ route('products.index') }}" method="GET">
        <input 
            type="text" 
            name="search" 
            value="{{ request()->get('search', '') }}" 
            placeholder="Search by Product ID or Description"
        >
        <button type="submit">Search</button>
    </form>

    <!-- Product Table -->
    <table>
        <thead>
            <tr>
                <th>
                    <a href="{{ route('products.index', array_merge(request()->all(), ['sort' => 'name', 'direction' => request()->get('direction') === 'asc' && request()->get('sort') === 'name' ? 'desc' : 'asc'])) }}">
                        Name
                        @if(request()->get('sort') === 'name')
                            {{ request()->get('direction') === 'asc' ? '▲' : '▼' }}
                        @endif
                    </a>
                </th>
                <th>
                    <a href="{{ route('products.index', array_merge(request()->all(), ['sort' => 'price', 'direction' => request()->get('direction') === 'asc' && request()->get('sort') === 'price' ? 'desc' : 'asc'])) }}">
                        Price
                        @if(request()->get('sort') === 'price')
                            {{ request()->get('direction') === 'asc' ? '▲' : '▼' }}
                        @endif
                    </a>
                </th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($products as $product)
                <tr>
                    <td>{{ $product->name }}</td>
                    <td>${{ number_format($product->price, 2) }}</td>
                    <td>
                        <a href="{{ route('products.show', $product->id) }}">View</a> |
                        <a href="{{ route('products.edit', $product->id) }}">Edit</a> |
                        <form action="{{ route('products.destroy', $product->id) }}" method="POST" style="display: inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" onclick="return confirm('Are you sure?');">Delete</button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="3">No products found.</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <!-- Pagination Links -->
    <div>
        @if ($products->hasPages())
            <ul class="pagination">
                <!-- Previous Page Link -->
                @if ($products->onFirstPage())
                    <li class="disabled"><span>&laquo;</span></li>
                @else
                    <li><a href="{{ $products->previousPageUrl() }}" rel="prev">&laquo;</a></li>
                @endif

                <!-- Pagination Elements -->
                @foreach ($products->getUrlRange(1, $products->lastPage()) as $page => $url)
                    @if ($page == $products->currentPage())
                        <li class="active"><span>{{ $page }}</span></li>
                    @else
                        <li><a href="{{ $url }}">{{ $page }}</a></li>
                    @endif
                @endforeach

                <!-- Next Page Link -->
                @if ($products->hasMorePages())
                    <li><a href="{{ $products->nextPageUrl() }}" rel="next">&raquo;</a></li>
                @else
                    <li class="disabled"><span>&raquo;</span></li>
                @endif
            </ul>
        @endif
    </div>

</body>
</html>
