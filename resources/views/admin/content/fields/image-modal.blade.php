<div class="cms-img-modal hidden" data-img-modal aria-hidden="true" data-upload-url="{{ route('admin.media.store') }}">
    <div class="cms-img-modal__backdrop" data-img-modal-close></div>
    <div class="cms-img-modal__dialog" role="dialog" aria-label="Escolher imagem">
        <div class="cms-img-modal__head">
            <h3 class="cms-img-modal__title">Escolher imagem</h3>
            <button type="button" class="flex h-9 w-9 shrink-0 cursor-pointer items-center justify-center rounded-[0.55rem] border border-[#e8e4ef] bg-white text-lg leading-none text-[#667085] hover:border-[#c9b8e8] hover:text-[#5b2b82]" data-img-modal-close title="Fechar">×</button>
        </div>

        <label class="cms-img-picker__upload">
            <input type="file" accept="image/*" class="hidden" data-img-modal-upload>
            <span>Carregar nova imagem</span>
        </label>

        <div class="cms-img-modal__body" data-img-modal-body>
            @if (! empty($siteImages))
                <p class="cms-img-picker__section-label">Imagens do site</p>
                <div class="cms-img-picker__grid" data-img-modal-site>
                    @foreach ($siteImages as $sitePath)
                        <button
                            type="button"
                            class="cms-img-picker__thumb"
                            data-img-select="{{ $sitePath }}"
                            title="{{ basename($sitePath) }}"
                        >
                            <img src="{{ admin_asset_url($sitePath) }}" alt="">
                        </button>
                    @endforeach
                </div>
            @endif

            @if ($media->isNotEmpty())
                <p class="cms-img-picker__section-label">Biblioteca</p>
                <div class="cms-img-picker__grid" data-img-modal-library>
                    @foreach ($media as $item)
                        <button
                            type="button"
                            class="cms-img-picker__thumb"
                            data-img-select="{{ $item->path }}"
                            title="{{ $item->filename }}"
                        >
                            <img src="{{ $item->url() }}" alt="">
                        </button>
                    @endforeach
                </div>
            @endif
        </div>
    </div>
</div>
