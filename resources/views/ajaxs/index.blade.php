@extends('layouts.ajaxs')

@section('content')
<div class="container p-4 mx-auto">
    <h1 class="mb-4 text-2xl font-bold">Product List</h1>
    <button id="addProductBtn" class="px-4 py-2 text-white bg-blue-500 rounded">Add Product</button>
    <table class="mt-4 w-full">
        <thead>
            <tr>
                <th class="px-4 py-2">Name</th>
                <th class="px-4 py-2">Description</th>
                <th class="px-4 py-2">Price</th>
                <th class="px-4 py-2">Actions</th>
            </tr>
        </thead>
        <tbody id="productTableBody">
            @foreach($products as $product)
            <tr id="product{{ $product->id }}">
                <td class="px-4 py-2">{{ $product->name }}</td>
                <td class="px-4 py-2">{{ $product->description }}</td>
                <td class="px-4 py-2">{{ $product->price }}</td>
                <td class="px-4 py-2">
                    <button onclick="editProduct({{ $product->id }})" class="px-2 py-1 text-white bg-yellow-500 rounded">Edit</button>
                    <button onclick="deleteProduct({{ $product->id }})" class="px-2 py-1 text-white bg-red-500 rounded">Delete</button>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>

<!-- Modal for Add/Edit Product -->
<div id="productModal" class="hidden fixed inset-0 bg-black bg-opacity-50">
    <div class="p-4 mx-auto mt-10 w-1/3 bg-white rounded">
        <h2 id="modalTitle" class="mb-4 text-xl font-bold">Add Product</h2>
        <form id="productForm">
            <input type="hidden" id="productId">
            <div class="mb-4">
                <label for="name" class="block">Name</label>
                <input type="text" id="name" name="name" class="px-2 py-1 w-full rounded border">
            </div>
            <div class="mb-4">
                <label for="description" class="block">Description</label>
                <textarea id="description" name="description" class="px-2 py-1 w-full rounded border"></textarea>
            </div>
            <div class="mb-4">
                <label for="price" class="block">Price</label>
                <input type="number" id="price" name="price" class="px-2 py-1 w-full rounded border">
            </div>
            <button type="submit" class="px-4 py-2 text-white bg-green-500 rounded">Save</button>
            <button type="button" onclick="closeModal()" class="px-4 py-2 text-white bg-gray-500 rounded">Cancel</button>
        </form>
    </div>
</div>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
<script>
    $.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
        // Add Product Modal Open
    $('#addProductBtn').click(function() {
        $('#modalTitle').text('Add Product');
        $('#productForm')[0].reset();
        $('#productId').val('');
        $('#productModal').removeClass('hidden');
    });

    // Close Modal
    function closeModal() {
        $('#productModal').addClass('hidden');
    }

    // Save Product
    $('#productForm').submit(function(e) {

        e.preventDefault();
        let formData = $(this).serialize();
        let url = $('#productId').val() ? `/ajaxs/products/${$('#productId').val()}` : '/ajaxs/products';
        let method = $('#productId').val() ? 'PUT' : 'POST';

        $.ajax({
            url: url,
            method: method,
            data: formData,
            success: function(response) {
                if (method === 'POST') {
                    $('#productTableBody').append(`
                        <tr id="product${response.id}">
                            <td class="px-4 py-2">${response.name}</td>
                            <td class="px-4 py-2">${response.description}</td>
                            <td class="px-4 py-2">${response.price}</td>
                            <td class="px-4 py-2">
                                <button onclick="editProduct(${response.id})" class="px-2 py-1 text-white bg-yellow-500 rounded">Edit</button>
                                <button onclick="deleteProduct(${response.id})" class="px-2 py-1 text-white bg-red-500 rounded">Delete</button>
                            </td>
                        </tr>
                    `);
                } else {
                    $(`#product${response.id}`).html(`
                        <td class="px-4 py-2">${response.name}</td>
                        <td class="px-4 py-2">${response.description}</td>
                        <td class="px-4 py-2">${response.price}</td>
                        <td class="px-4 py-2">
                            <button onclick="editProduct(${response.id})" class="px-2 py-1 text-white bg-yellow-500 rounded">Edit</button>
                            <button onclick="deleteProduct(${response.id})" class="px-2 py-1 text-white bg-red-500 rounded">Delete</button>
                        </td>
                    `);
                }
                closeModal();
            }
        });
    });

    // Edit Product
    function editProduct(id) {
        $.get(`/products/${id}/edit`, function(response) {
            $('#modalTitle').text('Edit Product');
            $('#productId').val(response.id);
            $('#name').val(response.name);
            $('#description').val(response.description);
            $('#price').val(response.price);
            $('#productModal').removeClass('hidden');
        });
    }

    // Delete Product
    function deleteProduct(id) {
        if (confirm('Are you sure you want to delete this product?')) {
            $.ajax({
                url: `/products/${id}`,
                method: 'DELETE',
                success: function(response) {
                    $(`#product${id}`).remove();
                }
            });
        }
    }
</script>
@endsection
