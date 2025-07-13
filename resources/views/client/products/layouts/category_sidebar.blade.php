                   <div class="list-group shadow-sm">
                        <a href="{{route('client.products.index')}}" class="list-group-item {{empty($currentCategory) ? 'active' : ''}}">Tất cả sản phẩm</a>
                        @foreach ($categories as $category)
                            <a href="{{route('client.category.show', $category->id)}}" class="list-group-item {{ isset($currentCategory) && $currentCategory->id == $category->id ? 'active' : ''}}">{{$category->name}}</a>
                        @endforeach
                    </div>
                    <style>
                        .list-group-item.active{
                            background-color: #3b5d50;
                            color:white;
                            font-weight: bold;
                        }
                    </style>