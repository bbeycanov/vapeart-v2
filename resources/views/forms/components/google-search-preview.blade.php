@php
    use Illuminate\Support\Str;

    $extra    = $getExtraAttributes();
    $baseUrl  = rtrim($extra['data-base-url'] ?? (config('app.url') ?? 'https://example.com'), '/');
    $host     = preg_replace('#^https?://#', '', $baseUrl);
    $siteName = $extra['data-site-name'] ?? ucfirst(Str::before($host, '/'));

    // Favicon üçün tam URL qur (əgər nisbidir isə asset() ilə çevir)
    $favRaw   = $extra['data-favicon'] ?? null;
    $favicon  = $favRaw
        ? (Str::startsWith($favRaw, ['http://','https://','/']) ? $favRaw : asset($favRaw))
        : null;
@endphp

<style>
    .g-clamp-1{display:-webkit-box;-webkit-line-clamp:1;-webkit-box-orient:vertical;overflow:hidden}
    .g-clamp-2{display:-webkit-box;-webkit-line-clamp:2;-webkit-box-orient:vertical;overflow:hidden}
    .g-clamp-3{display:-webkit-box;-webkit-line-clamp:3;-webkit-box-orient:vertical;overflow:hidden}
</style>

<div
    x-data="serpPreview(
        @entangle('data.meta_title').live,
        @entangle('data.meta_description').live,
        @entangle('data.slug').live,
        '{{ $baseUrl }}',
        '{{ $host }}',
        '{{ $siteName }}',
        @js($favicon)
    )"
    class="flex justify-start"
>
    <div
        class="w-full max-w-[720px] rounded-2xl border p-5 shadow-sm space-y-3
               bg-white border-zinc-200 text-zinc-900
               dark:bg-zinc-900 dark:border-zinc-800 dark:text-zinc-100"
    >
        <!-- üst xətt: favicon + site adı + breadcrumb -->
        <div class="flex items-start gap-3">
            <div class="mt-[2px] h-6 w-6 flex items-center justify-center rounded-full overflow-hidden
                        bg-amber-500 text-white text-xs font-semibold">
                <template x-if="favicon">
                    <img :src="favicon" alt="" class="h-6 w-6 rounded-full object-cover" />
                </template>
                <template x-if="!favicon">
                    <span x-text="siteInitial"></span>
                </template>
            </div>

            <div class="min-w-0 flex-1">
                <div class="text-[13px] font-medium truncate
                            text-zinc-900 dark:text-zinc-100"
                     x-text="siteName"></div>

                <div class="text-[12px] truncate
                            text-zinc-600 dark:text-zinc-400">
                    <span x-text="protoHost"></span>
                    <span class="mx-1">›</span>
                    <span x-text="slugPath"></span>
                </div>
            </div>
        </div>

        <!-- başlıq -->
        <a href="javascript:void(0)"
           class="block g-clamp-2 text-[20px] leading-[1.35] font-normal
                  text-blue-700 hover:underline
                  dark:text-blue-400"
           x-text="meta_title && meta_title.trim() !== '' ? meta_title : 'SEO title burada görünəcək'"></a>

        <!-- təsvir -->
        <p class="g-clamp-3 text-[14px] leading-6
                  text-zinc-700 dark:text-zinc-300"
           x-text="descLine || '~150–160 simvolluq cəlbedici meta description yazın.'"></p>
    </div>
</div>

<script>
    function serpPreview(metaTitleRef, metaDescRef, slugRef, baseUrl, host, siteName, favicon) {
        return {
            meta_title: metaTitleRef,
            meta_description: metaDescRef,
            slug: slugRef,

            baseUrl, host, siteName, favicon,

            get siteInitial() {
                return (this.siteName || 'S').toString().trim().charAt(0).toUpperCase();
            },
            get protoHost() {
                try { return new URL(this.baseUrl).origin.replace(/\/+$/,''); }
                catch { return this.baseUrl; }
            },
            get slugPath() {
                return (this.slug || '').toString().trim().replace(/^\/+/, '');
            },
            get descLine() {
                const d = (this.meta_description || '').trim();
                return d.length > 170 ? d.substring(0, 170) + '…' : d;
            },
        }
    }
</script>
