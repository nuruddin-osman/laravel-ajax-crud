@extends('layouts.ajaxs')

@section('content')
    <div class="">
        <div class="container mx-auto">
                <h2 class="py-4 text-4xl font-bold text-center text-orange-500">Product details page</h2>
            <div class="">
                <button id="addProductBtn" class="p-3 text-xl bg-orange-500 rounded-md">Add Button</button>
            </div>
            <table>
                <thead class="w-full">
                    <tr class="w-full">
                        <th class="px-5 border">
                            <p class="text-lg font-bold text-[#2d2d2d]">Name</p>
                        </th>
                        <th class="px-5 border">
                            <p class="text-lg font-bold text-[#2d2d2d]">Title</p>
                        </th>
                        <th class="px-5 border">
                            <p class="text-lg font-bold text-[#2d2d2d]">Description</p>
                        </th>
                        <th class="px-5 border">
                            <p class="text-lg font-bold text-[#2d2d2d]">Price</p>
                        </th>
                        <th class="px-5 border">
                            <p class="text-lg font-bold text-[#2d2d2d]">category</p>
                        </th>
                        <th class="px-5 border">
                            <p class="text-lg font-bold text-[#2d2d2d]">Action</p>
                        </th>
                    </tr>
                </thead>
                <tbody id="tbody">
                    @foreach ($products as $product)
                        <tr>
                            <td>
                                <p>{{$product->name}}</p>
                            </td>
                            <td>
                                <p>{{$product->title}}</p>
                            </td>
                            <td>
                                <p>{{$product->description}}</p>
                            </td>
                            <td>
                                <p>{{$product->price}}</p>
                            </td>
                            <td>
                                <p>{{$product->category}}</p>
                            </td>
                            <td>
                                <button onclick="editProduct({{$product->id}})" class="p-3 text-xl bg-green-500 rounded-md">Edit</button>
                                <button onclick="deleteProduct({{$product->id}})" class="p-3 text-xl bg-red-500 rounded-md">Delete</button>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        {{-- modal --}}

        <div id="modalToggle" class="bg-[#0001] hidden w-full h-screen fixed top-0 left-0">
            <div class="flex justify-center items-center w-full h-full">
                <div class="p-5 mx-auto w-1/2 bg-white rounded-md shadow-md">
                    <h3 class="modalTitle text-[#2d2d2d] font-medium text-xl">Add Product</h3>
                    <form class="productForm">
                        <input type="hidden" id="productId">
                        <div class="flex flex-col gap-1">
                            <label class="py-1 text-xl font-medium" for="name">Name</label>
                            <input type="text" id="name" name="name"
                            class="w-1/2 py-2 px-5 text-base text-[#262626] outline-none border border-[#2D2D2D] rounded-md">
                        </div>
                        <div class="flex flex-col gap-1">
                            <label class="py-1 text-xl font-medium" for="title">Title</label>
                            <input type="text" id="title" name="title"
                            class="w-1/2 py-2 px-5 text-base text-[#262626] outline-none border border-[#2D2D2D] rounded-md">
                        </div>
                        <div class="flex flex-col gap-1">
                            <label class="py-1 text-xl font-medium" for="description">Description</label>
                            <input type="text" id="description" name="description"
                            class="w-1/2 py-2 px-5 text-base text-[#262626] outline-none border border-[#2D2D2D] rounded-md">
                        </div>
                        <div class="flex flex-col gap-1">
                            <label class="py-1 text-xl font-medium" for="price">Price</label>
                            <input type="text" id="price" name="price"
                            class="w-1/2 py-2 px-5 text-base text-[#262626] outline-none border border-[#2D2D2D] rounded-md">
                        </div>
                        <div class="flex flex-col gap-1">
                            <label class="py-1 text-xl font-medium" for="category">Category</label>
                            <input type="text" id="category" name="category"
                            class="w-1/2 py-2 px-5 text-base text-[#262626] outline-none border border-[#2D2D2D] rounded-md">
                        </div>
                        <div class="mt-3">
                            <button type="submit" class="px-3 py-2 text-xl bg-orange-500 rounded-md">Save</button>
                            <button type="button" onclick="closeModal()" class="px-3 py-2 text-xl bg-red-500 rounded-md">Cancel</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        {{-- script here --}}
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
        <script>
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $('#addProductBtn').click(function(){
                $('.modalTitle').text('Add Product');
                $('.productForm')[0].reset();
                $('#productId').val('');
                $('#modalToggle').removeClass('hidden');
            })

            function closeModal() {
                $('#modalToggle').addClass('hidden')
            }

            $('.productForm').submit(function(e){
                e.preventDefault();
                const formData = $(this).serialize();
                const url = $('#productId').val() ? `/ajaxs/index/${$('#productId').val()}` : '/ajaxs/index';
                const method = $('#productId').val() ? 'PUT' : 'POST';

                $.ajax({
                    data: formData,
                    url: url,
                    method: method,
                    success: function(response){
                        if (method == 'POST') {
                            $('#tbody').append(`
                                <tr  id="product${response.id}">
                                    <td>
                                        <p>${response.name}</p>
                                    </td>
                                    <td>
                                        <p>${response.title}</p>
                                    </td>
                                    <td>
                                        <p>${response.description}</p>
                                    </td>
                                    <td>
                                        <p>${response.price}</p>
                                    </td>
                                    <td>
                                        <p>${response.category}</p>
                                    </td>
                                    <td>
                                        <button onclick="editProduct(${response.id})" class="p-3 text-xl bg-green-500 rounded-md">Edit</button>
                                        <button onclick="deleteProduct(${response.id})" class="p-3 text-xl bg-red-500 rounded-md">Delete</button>
                                    </td>
                                </tr>
                            `)
                        }else{
                            $(`#product${response.id}`).html(`
                                <td>
                                    <p>${response.name}</p>
                                </td>
                                <td>
                                    <p>${response.title}</p>
                                </td>
                                <td>
                                    <p>${response.description}</p>
                                </td>
                                <td>
                                    <p>${response.price}</p>
                                </td>
                                <td>
                                    <p>${response.category}</p>
                                </td>
                                <td>
                                    <button onclick="editProduct(${response.id})" class="p-3 text-xl bg-green-500 rounded-md">Edit</button>
                                    <button onclick="deleteProduct(${response.id})" class="p-3 text-xl bg-red-500 rounded-md">Delete</button>
                                </td>
                            `)
                        }
                        closeModal();
                    },
                })
            })

            // edit product
            function editProduct(id) {
                $.get(`/ajaxs/index/${id}/edit`, function(response) {
                    $('.modalTitle').text('Edit Product');
                    $('#productId').val(response.id);
                    $('#name').val(response.name);
                    $('#title').val(response.title);
                    $('#description').val(response.description);
                    $('#price').val(response.price);
                    $('#category').val(response.category);
                    $('#modalToggle').removeClass('hidden');
                })
                ajax.reload();
            }

            //delete product
            function deleteProduct(id) {
                if (confirm('Are you sure? You want to delelte this product')) {
                    $.ajax({
                        url: `/ajaxs/index/${id}`,
                        method: 'DELETE',
                        success: function(response){
                            $(`#product${id}`).remove();
                        }
                    })
                }
            }
        </script>
    </div>
@endsection
