<template>
    <!-- Navbar -->
    <nav class="main-header navbar navbar-expand navbar-white navbar-light">
        <!-- Left navbar links -->
        <ul class="navbar-nav">
            <li class="nav-item">
                <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
            </li>
            <li class="nav-item d-none d-sm-inline-block">
                <a :href="route('main')" class="nav-link">Басты бет</a>
            </li>
        </ul>

        <!-- Right navbar links -->
        <!-- <ul class="navbar-nav ml-auto">
            <li class="nav-item text-bold mr-2 c-p" @click="changeLangCode('kz')"
                :style="{ color: userData.lang_code == 'kz' ? 'red' : '' }">
                KZ
            </li>
            <li class="nav-item text-bold c-p" @click="changeLangCode('tr')"
                :style="{ color: userData.lang_code == 'tr' ? 'red' : '' }">
                TR
            </li>
        </ul> -->
        <ul class="navbar-nav">
            <li class="nav-item">
                <a class="nav-link" data-widget="fullscreen" href="#" role="button">
                    <i class="fas fa-expand-arrows-alt"></i>
                </a>
            </li>
        </ul>
    </nav>
    <!-- /.navbar -->
</template>
<script>
export default {
    created() {
        this.$store.dispatch('fetchUser');
    },
    computed: {
        userData() {
            return this.$store.getters.getUserData.user;
        }
    },
    methods: {
        changeLangCode(lang_code) {
            console.log(lang_code);
            this.$inertia.put(
                route("admin.users.changeLangCode", this.userData.id),
                { lang_code: lang_code }
            );
            window.location.reload();
        },
    },
}
</script>
<style>
.c-p {
    cursor: pointer;
}
</style>