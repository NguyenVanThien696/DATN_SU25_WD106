    @extends('admin.layouts.default')

    @section('content')
    <div class="p-4">
        <h4 class="text-primary mb-4">Thêm sản phẩm</h4>

        @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        @if (session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
        @endif


        <form action="{{ route('admin.products.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <div class="mb-3">
                <label class="form-label">Tên sản phẩm <span class="text-danger">*</span></label>
                <input type="text" class="form-control @error('name') is-invalid @enderror" name="name"
                    value="{{ old('name') }}">
                @error('name')
                <small class="text-danger">{{ $message }}</small>
                @enderror
            </div>

            <div class="mb-3">
                <label class="form-label">Mô tả</label>
                <textarea class="form-control" name="description" rows="3" value="{{ old('description') }}"></textarea>
                @error('description') <small class="text-danger">{{ $message }}</small> @enderror
            </div>

            <div class="mb-3">
                <label class="form-label">Giá <span class="text-danger">*</span></label>
                <input type="number" class="form-control @error('price') is-invalid @enderror" name="price"
                    value="{{ old('price') }}">
                @error('price')
                <small class="text-danger">{{ $message }}</small>
                @enderror
            </div>


            <div class="mb-3">
                <label class="form-label">Danh mục</label>
                <select name="category_id" class="form-control @error('category_id') is-invalid @enderror">
                    <option value="" disabled {{ old('category_id') ? '' : 'selected' }}>-- Chọn danh mục --</option>
                    @foreach ($category as $cat)
                    <option value="{{ $cat->id }}" {{ old('category_id') == $cat->id ? 'selected' : '' }}>
                        {{ $cat->name }}
                    </option>
                    @endforeach
                </select>
                @error('category_id')
                <small class="text-danger">{{ $message }}</small>
                @enderror
            </div>

            <div class="mb-3">
                <label class="form-label">Tags</label>
                <select name="tag_id" class="form-control @error('tag_id') is-invalid @enderror">
                    <option value="" disabled {{ old('tag_id') ? '' : 'selected' }}>-- Chọn tag --</option>
                    @foreach ($tags as $tag)
                    <option value="{{ $tag->id }}" {{ old('tag_id') == $tag->id ? 'selected' : '' }}>
                        {{ $tag->name }}
                    </option>
                    @endforeach
                </select>
                @error('tag_id')
                <small class="text-danger">{{ $message }}</small>
                @enderror
            </div>

            <div class="mb-3">
                <label class="form-label">Thương hiệu</label>
                <select name="brand_id" class="form-control @error('brand_id') is-invalid @enderror">
                    <option value="" disabled {{ old('brand_id') ? '' : 'selected' }}>-- Chọn thương hiệu --</option>
                    @foreach ($brand as $br)
                    <option value="{{ $br->id }}" {{ old('brand_id') == $br->id ? 'selected' : '' }}>
                        {{ $br->name }}
                    </option>
                    @endforeach
                </select>
                @error('brand_id')
                <small class="text-danger">{{ $message }}</small>
                @enderror
            </div>

            <div class="mb-3">
                <label class="form-label">Ảnh sản phẩm</label>
                <input type="file" class="form-control @error('image') is-invalid @enderror" name="image">
                @error('image')
                <small class="text-danger">{{ $message }}</small>
                @enderror
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
                    @php $variants = old('variants', [[]]); @endphp
                    @foreach ($variants as $i => $variant)
                    <tr>
                        <td>
                            <select name="variants[{{ $i }}][size_id]" class="form-control">
                                <option value="" disabled {{ !isset($variant['size_id']) ? 'selected' : '' }}>-- Chọn
                                    size --</option>
                                @foreach ($sizes as $size)
                                <option value="{{ $size->id }}"
                                    {{ (isset($variant['size_id']) && $variant['size_id'] == $size->id) ? 'selected' : '' }}>
                                    {{ $size->name }}
                                </option>
                                @endforeach
                            </select>
                            @error("variants.$i.size_id")
                            <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </td>
                        <td>
                            <select name="variants[{{ $i }}][color_id]" class="form-control">
                                <option value="" disabled {{ !isset($variant['color_id']) ? 'selected' : '' }}>-- Chọn
                                    màu --</option>
                                @foreach ($colors as $color)
                                <option value="{{ $color->id }}"
                                    {{ (isset($variant['color_id']) && $variant['color_id'] == $color->id) ? 'selected' : '' }}>
                                    {{ $color->name }}
                                </option>
                                @endforeach
                            </select>
                            @error("variants.$i.color_id")
                            <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </td>
                        <td>
                            <input type="number" name="variants[{{ $i }}][stock]" class="form-control"
                                value="{{ $variant['stock'] ?? '' }}">
                            @error("variants.$i.stock")
                            <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </td>
                        <td>
                            <input type="file" name="variants[{{ $i }}][image]" class="form-control">
                            @error("variants.$i.image")
                            <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </td>
                        <td>
                            <button type="button" class="btn btn-danger remove-variant">Xóa</button>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>

            <button type="button" class="btn btn-outline-dark mt-3" id="addVariant">Thêm biến thể</button>

            <script>
            let variantIndex = 1;

            document.getElementById('addVariant').addEventListener('click', function() {
                const existingVariants = document.querySelectorAll('#variantTable tbody tr');
                let existingPairs = [];

                existingVariants.forEach(row => {
                    const size = row.querySelector('select[name^="variants"][name$="[size_id]"]')
                        ?.value;
                    const color = row.querySelector('select[name^="variants"][name$="[color_id]"]')
                        ?.value;
                    if (size && color) {
                        existingPairs.push(`${size}-${color}`);
                    }
                });

                const newRow = document.createElement('tr');
                newRow.innerHTML = `
        <td>
            <select name="variants[${variantIndex}][size_id]" class="form-control size-select">
                <option disabled selected value="">-- Chọn size --</option>
                @foreach ($sizes as $size)
                <option value="{{ $size->id }}">{{ $size->name }}</option>
                @endforeach
            </select>
        </td>
        <td>
            <select name="variants[${variantIndex}][color_id]" class="form-control color-select">
                <option disabled selected value="">-- Chọn màu --</option>
                @foreach ($colors as $color)
                <option value="{{ $color->id }}">{{ $color->name }}</option>
                @endforeach
            </select>
        </td>
        <td><input type="number" name="variants[${variantIndex}][stock]" class="form-control"></td>
        <td><input type="file" name="variants[${variantIndex}][image]" class="form-control"></td>
        <td><button type="button" class="btn btn-danger remove-variant">Xóa</button></td>
    `;

                table = document.querySelector('#variantTable tbody');
                table.appendChild(newRow);

                variantIndex++;
            });

            document.addEventListener('change', function(e) {
                if (e.target.classList.contains('size-select') || e.target.classList.contains('color-select')) {
                    const rows = document.querySelectorAll('#variantTable tbody tr');
                    const selectedPairs = new Set();
                    let duplicateFound = false;

                    rows.forEach(row => {
                        const size = row.querySelector('.size-select')?.value;
                        const color = row.querySelector('.color-select')?.value;
                        if (size && color) {
                            const key = `${size}-${color}`;
                            if (selectedPairs.has(key)) {
                                alert('Biến thể với Size và Màu này đã tồn tại!');
                                row.querySelector('.size-select').value = "";
                                row.querySelector('.color-select').value = "";
                                duplicateFound = true;
                            } else {
                                selectedPairs.add(key);
                            }
                        }
                    });
                }
            });
            document.addEventListener('click', function(e) {
                if (e.target.classList.contains('remove-variant')) {
                    e.target.closest('tr').remove();
                }
            });
            </script>

            <button class="btn btn-success mt-3"><i class="fas fa-save me-1"></i> Lưu</button>
        </form>
    </div>

    @endsection