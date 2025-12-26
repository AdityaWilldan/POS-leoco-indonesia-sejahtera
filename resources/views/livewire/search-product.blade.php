<div x-data x-init="
    Livewire.on('searchResultsUpdated', () => {
        // jika ada hasil, langsung select produk pertama
        if(@this.search_results.length > 0) {
            @this.selectFirstResult();
        }
    });
" class="position-relative">

    <div class="card mb-0 border-0 shadow-sm">
        <div class="card-body">
            <div class="form-group mb-0">
                <div class="input-group">
                    <div class="input-group-prepend">
                        <div class="input-group-text">
                            <i class="bi bi-search text-primary"></i>
                        </div>
                    </div>

                    <input
                        type="text"
                        class="form-control"
                        placeholder="Scan barcode / type product"
                        wire:model.live.debounce.100ms="query"
                        wire:keydown.escape="resetQuery"
                        autofocus
                    >
                </div>
            </div>
        </div>
    </div>

    {{-- Loading --}}
    <div wire:loading class="card position-absolute mt-1 border-0"
         style="z-index: 3;left: 0;right: 0;">
        <div class="card-body shadow text-center">
            <div class="spinner-border text-primary" role="status"></div>
        </div>
    </div>

    @if(!empty($query))
        {{-- overlay --}}
        <div
            wire:click="resetQuery"
            class="position-fixed w-100 h-100"
            style="left:0;top:0;z-index:1;"
        ></div>

        @if($search_results->isNotEmpty())
            <div class="card position-absolute mt-1 border-0"
                 style="z-index:2;left:0;right:0;">
                <div class="card-body shadow p-0">
                    <ul class="list-group list-group-flush">
                        @foreach($search_results as $index => $result)
                            <li class="list-group-item list-group-item-action {{ $index === 0 ? 'active' : '' }}">
                                <a
                                    href="#"
                                    class="text-decoration-none {{ $index === 0 ? 'text-white' : '' }}"
                                    wire:click.prevent="selectProduct({{ $result }})"
                                >
                                    {{ $result->product_name }}
                                    <br>
                                    <small>{{ $result->product_code }}</small>
                                </a>
                            </li>
                        @endforeach

                        @if($search_results->count() >= $how_many)
                            <li class="list-group-item text-center">
                                <a wire:click.prevent="loadMore"
                                   class="btn btn-primary btn-sm"
                                   href="#">
                                    Load More <i class="bi bi-arrow-down-circle"></i>
                                </a>
                            </li>
                        @endif

                    </ul>
                </div>
            </div>
        @else
            <div class="card position-absolute mt-1 border-0"
                 style="z-index:2;left:0;right:0;">
                <div class="card-body shadow">
                    <div class="alert alert-warning mb-0">
                        No Product Found....
                    </div>
                </div>
            </div>
        @endif
    @endif
</div>
