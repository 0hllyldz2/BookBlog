
@if (count($articles)>0)
    @foreach ($articles as $article)
        <!-- Post preview-->
        <div class="post-preview">
            <a href="{{ route('single', [$article->getCategory->slug, $article->slug]) }}">
                <h2 class="post-title">{{ $article->title }}</h2>
                <img style="width: 700px" height="300px" src="{{ $article->image }}" />
                <h3 class="post-subtitle">{!! Str::limit($article->content, 75) !!}</h3>
            </a>
            <p class="post-meta">Kategori:
                <a href="#!">{{ $article->getCategory->name }}, </a>
                <span class="float-right">{{ $article->created_at->diffForHumans() }}</span>
            </p>
        </div>
        @if (!$loop->last)
            <hr>
    @endif
    @endforeach
    @if ($articles->lastPage() > 1)
        <div class="pagination-container text-center">
            <ul class="pagination">
                <li class="page-item {{ ($articles->currentPage() == 1) ? ' disabled' : '' }}">
                    <a class="page-link" href="{{ $articles->url(1) }}" tabindex="-1" aria-disabled="true">&lt;</a>
                </li>
                @for ($i = 1; $i <= $articles->lastPage(); $i++)
                    <li class="page-item {{ ($articles->currentPage() == $i) ? ' active' : '' }}">
                        <a class="page-link" href="{{ $articles->url($i) }}">{{ $i }}</a>
                    </li>
                @endfor
                <li class="page-item {{ ($articles->currentPage() == $articles->lastPage()) ? ' disabled' : '' }}">
                    <a class="page-link" href="{{ $articles->url($articles->currentPage()+1) }}">&gt;</a>
                </li>
            </ul>
        </div>
    @endif
@else
    <div class="alert alert-danger text-center">
        <h1>Bu kategoriye ait yazı bulunamadı!</h1>
    </div>
@endif
