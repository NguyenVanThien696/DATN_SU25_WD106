@extends('admin.layouts.default')

@section('content')
<div class="p-4">
    <h4 class="text-primary mb-4">Cập nhật sản phẩm</h4>

    @if (session('error'))
    <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    @if (session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    @if (session('warning'))
    <div class="alert alert-warning">{{ session('warning') }}</div>
    @endif

    <form action="{{ route('admin.products.update', $product->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label class="form-label">Tên sản phẩm</label>
            <input type="text" class="form-control" name="name" required value="{{ old('name', $product->name) }}">
        </div>

        <div class="mb-3">
            <label class="form-label">Mô tả</label>
            <textarea class="form-control" name="description"
                rows="3">{{ old('description', $product->description) }}</textarea>
        </div>

        <div class="mb-3">
            <label class="form-label">Giá</label>
            <input type="number" class="form-control" name="price" required value="{{ old('price', $product->price) }}">
        </div>

        <div class="mb-3">
            <label class="form-label">Danh mục</label>
            <select name="category_id" class="form-control" required>
                @foreach ($category as $cat)
                <option value="{{ $cat->id }}" {{ $product->category_id == $cat->id ? 'selected' : '' }}>
                    {{ $cat->name }}</option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label class="form-label">Thương hiệu</label>
            <select name="brand_id" class="form-control" required>
                @foreach ($brand as $br)
                <option value="{{ $br->id }}" {{ $product->brand_id == $br->id ? 'selected' : '' }}>{{ $br->name }}
                </option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label class="form-label">Tags</label>
            <select name="tag_id" class="form-control" required>
                @foreach ($tag as $t)
                <option value="{{ $t->id }}" {{ $product->tag_id == $t->id ? 'selected' : '' }}>{{ $t->name }}</option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label class="form-label">Ảnh sản phẩm</label>
            <input type="file" class="form-control" name="image">
            @if ($product->image)
            <div class="mt-2">
                <img src="{{ asset('storage/' . $product->image) }}" alt="" style="max-width: 150px;">
            </div>
            @endif
        </div>

        <table class="table table-bordered" id="variantTable">
            <thead>
                <tr>
                    <th>Size</th>
                    <th>Màu sắc</th>
                    <th>Số lượng</th>
                    <th>Ảnh</th>
                    <th>Hành động</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($product->variants as $i => $variant)
                <tr>
                    <input type="hidden" name="variants[{{ $i }}][id]" value="{{ $variant->id }}">
                    <td>
                        <select name="variants[{{ $i }}][size_id]" class="form-control" required>
                            @foreach ($sizes as $size)
                            <option value="{{ $size->id }}" {{ $variant->size_id == $size->id ? 'selected' : '' }}>
                                {{ $size->name }}</option>
                            @endforeach
                        </select>
                    </td>
                    <td>
                        <select name="variants[{{ $i }}][color_id]" class="form-control" required>
                            @foreach ($colors as $color)
                            <option value="{{ $color->id }}" {{ $variant->color_id == $color->id ? 'selected' : '' }}>
                                {{ $color->name }}</option>
                            @endforeach
                        </select>
                    </td>
                    <td><input type="number" name="variants[{{ $i }}][stock]" class="form-control" required
                            value="{{ $variant->stock }}"></td>
                    <td>
                        <input type="file" name="variants[{{ $i }}][image]" class="form-control mb-2">
                        @if ($variant->image)
                        <img src="{{ asset('storage/' . $variant->image) }}" style="width: 60px;">
                        @endif
                    </td>
                    <td></td>
                </tr>
                @endforeach
            </tbody>


        </table>

        <button type="button" class="btn btn-outline-dark mt-3" id="addVariant">Thêm biến thể</button>

        <button type="submit" class="btn btn-primary mt-3">Cập nhật sản phẩm</button>
    </form>
</div>

<script>
let variantIndex = {{ count($product ->variants) }};

document.getElementById('addVariant').addEventListener('click', function() {
    const newRow = document.createElement('tr');
    newRow.innerHTML = `
        <td>
            <select name="variants[${variantIndex}][size_id]" class="form-control size-select" required>
                <option disabled selected value="">Chọn size</option>
                @foreach ($sizes as $size)
                    <option value="{{ $size->id }}">{{ $size->name }}</option>
                @endforeach
            </select>
        </td>
        <td>
            <select name="variants[${variantIndex}][color_id]" class="form-control color-select" required>
                <option disabled selected value="">Chọn màu</option>
                @foreach ($colors as $color)
                    <option value="{{ $color->id }}">{{ $color->name }}</option>
                @endforeach
            </select>
        </td>
        <td>
            <input type="number" name="variants[${variantIndex}][stock]" class="form-control" required>
        </td>
        <td>
            <input type="file" name="variants[${variantIndex}][image]" class="form-control">
        </td>
        <td>
            <button type="button" class="btn btn-danger remove-variant">Xóa</button>
        </td>
    `;
    document.querySelector('#variantTable tbody').appendChild(newRow);
    variantIndex++;
});

document.addEventListener('click', function(e) {
    if (e.target.classList.contains('remove-variant')) {
        e.target.closest('tr').remove();
    }
});

document.addEventListener('change', function(e) {
    if (e.target.classList.contains('size-select') || e.target.classList.contains('color-select')) {
        const rows = document.querySelectorAll('#variantTable tbody tr');
        const selectedPairs = new Set();

        rows.forEach(row => {
            const size = row.querySelector('.size-select')?.value;
            const color = row.querySelector('.color-select')?.value;
            if (size && color) {
                const key = `${size}-${color}`;
                if (selectedPairs.has(key)) {
                    alert('Biến thể với Size và Màu này đã tồn tại!');
                    row.querySelector('.size-select').value = "";
                    row.querySelector('.color-select').value = "";
                } else {
                    selectedPairs.add(key);
                }
            }
        });
    }
});
</script>

@endsection