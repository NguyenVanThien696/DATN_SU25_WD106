    @extends('admin.layouts.default')

    @section('content')
    <div class="p-4">
        <h4 class="text-primary mb-4">Thêm sản phẩm</h4>

        @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        <form action="{{ route('admin.products.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <div class="mb-3">
                <label class="form-label">Tên sản phẩm</label>
                <input type="text" class="form-control" name="name" required value="{{ old('name') }}">
            </div>

            <div class="mb-3">
                <label class="form-label">Mô tả</label>
                <textarea class="form-control" name="description" rows="3" value="{{ old('description') }}"></textarea>
            </div>

            <div class="mb-3">
                <label class="form-label">Giá</label>
                <input type="number" class="form-control" name="price" required value="{{ old('price') }}">
            </div>

            <div class="mb-3">
                <label class="form-label">Danh mục</label>
                <select name="category_id" class="form-control" required>
                    @foreach ($category as $cat)
                    <option value="{{ $cat->id }}">{{ $cat->name }}</option>
                    @endforeach
                </select>
            </div>

            <div class="mb-3">
                <label class="form-label">Thương hiệu</label>
                <select name="brand_id" class="form-control" required>
                    @foreach ($brand as $br)
                    <option value="{{ $br->id }}">{{ $br->name }}</option>
                    @endforeach
                </select>
            </div>

            <div class="mb-3">
                <label class="form-label">Ảnh sản phẩm</label>
                <input type="file" class="form-control" name="image">
            </div>

            <table class="table table-bordered" id="variantTable">
                <thead>
                    <tr>
                        <th>Size</th>
                        <th>Màu sắc</th>
                        <th>Số lượng</th>
                        <th>Hành động</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>
                            <select name="variants[0][size_id]" class="form-control" required>
                                @foreach ($sizes as $size)
                                <option value="{{ $size->id }}">{{ $size->name }}</option>
                                @endforeach
                            </select>
                        </td>
                        <td>
                            <select name="variants[0][color_id]" class="form-control" required>
                                @foreach ($colors as $color)
                                <option value="{{ $color->id }}">{{ $color->name }}</option>
                                @endforeach
                            </select>
                        </td>
                        <td><input type="number" name="variants[0][stock]" class="form-control" required></td>
                        <td><button type="button" class="btn btn-danger remove-variant">Xóa</button></td>
                    </tr>
                </tbody>
            </table>
            <button type="button" class="btn btn-secondary" id="addVariant">Thêm biến thể</button>

            <script>
            let variantIndex = 1;

            document.getElementById('addVariant').addEventListener('click', function() {
                const sizesOptions =
                    `@foreach ($sizes as $size) <option value="{{ $size->id }}">{{ $size->name }}</option> @endforeach`;
                const colorsOptions =
                    `@foreach ($colors as $color) <option value="{{ $color->id }}">{{ $color->name }}</option> @endforeach`;

                const table = document.querySelector('#variantTable tbody');
                const row = document.createElement('tr');
                row.innerHTML = `
            <td><select name="variants[${variantIndex}][size_id]" class="form-control" required>${sizesOptions}</select></td>
            <td><select name="variants[${variantIndex}][color_id]" class="form-control" required>${colorsOptions}</select></td>
            <td><input type="number" name="variants[${variantIndex}][stock]" class="form-control" required></td>
            <td><button type="button" class="btn btn-danger remove-variant">Xóa</button></td>
        `;
                table.appendChild(row);
                variantIndex++;
            });

            document.addEventListener('click', function(e) {
                if (e.target.classList.contains('remove-variant')) {
                    e.target.closest('tr').remove();
                }
            });
            </script>
            <button type="submit" class="btn btn-primary">Thêm sản phẩm</button>
        </form>
    </div>

    @endsection