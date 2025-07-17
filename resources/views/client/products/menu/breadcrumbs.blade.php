<nav aria-label="breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item">
            <a href="{{route('client.index')}}">Trang chủ</a>
        </li>
        @foreach ($breadcrumbs as $item)
            @if ($loop->last)
                <li class="breadcrumb-item active" aria-current="page">{{$item->name}}</li>
            @else
                <li class="breadcrumb-item"><a href="{{$item->route}}">{{$item->name}}</a></li>    
            @endif
        @endforeach
    </ol>
</nav>

{{-- <style>
    .breadcrumb{
        font-size: 14px;
        color: #999;
        margin-bottom: 20px;
        border-bottom: 1px solid #e1e1e1;
        padding-bottom: 10px;
        width: 100vw;
        position: relative;
        left: 50%;
        right: 50%;
        margin-left: -50vw;
        margin-right: -50vw;
    }
</style> --}}