<template>
    <div class="min-h-full min-w-full bg-white ">
        <router-view :key="$route.fullPath"></router-view>
    </div>
</template>

<script>

export default{
    components:{

    }
}
</script>
