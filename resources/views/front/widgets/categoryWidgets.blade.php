<!-- Side widgets-->
@isset($categories)

<div class="col-lg-12">
    <!-- Categories widget-->
    <div class="card mb-4">
        <div class="card-header">Kategoriler</div>
        <div class="card-body">
            <div class="row">
                <div class="col-sm-12">
                    <ul class="list-unstyled mb-0">
                        <div class="list-group">
                            @foreach ($categories as $category)
                                <li class="list-group-item mb-2 @if(Request::segment(2)==$category->slug) active @endif">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <a @if(Request::segment(2)!=$category->slug) href="{{ route('category', $category->slug) }}" @endif class="d-inline-block">{{ $category->name }}</a><span class="badge bg-danger d-inline-block ml-2">{{ $category->articleCount() }}</span>
                                    </div>
                                </li>
                            @endforeach
                        </div>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
@endisset
