<template>
    <!-- Social auth buttons -->
    <div class="grid grid-cols-2 gap-2.5" v-if="route().has('social.redirect')">
        <a
            v-if="$page.props.socialAuth?.includes('google')"
            class="btn btn-light btn-sm justify-center"
            :href="route('social.redirect', 'google')"
        >
            <img
                alt=""
                class="size-3.5 shrink-0"
                src="/static/media/brand-logos/google.svg"
            />
            Google
        </a>
        <a
            v-if="$page.props.socialAuth?.includes('facebook')"
            class="btn btn-light btn-sm justify-center"
            :href="route('social.redirect', 'facebook')"
        >
            <img
                alt=""
                class="size-3.5 shrink-0"
                src="/static/media/brand-logos/facebook.svg"
            />
            Facebook
        </a>
    </div>
    <div class="flex items-center gap-2">
        <span class="border-t border-gray-200 w-full"> </span>
        <span class="text-2xs text-gray-500 font-medium uppercase"> Ou </span>
        <span class="border-t border-gray-200 w-full"> </span>
    </div>
    <!-- end of Social auth buttons -->
</template>
