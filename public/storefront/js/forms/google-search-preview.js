/**
 * Google Search Preview Component
 */
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
            try { 
                return new URL(this.baseUrl).origin.replace(/\/+$/, ''); 
            } catch { 
                return this.baseUrl; 
            }
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

