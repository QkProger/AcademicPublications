<template>

    <head>
        <title>Админ панель | Музыка қосу</title>
    </head>
    <AdminLayout>
        <template #breadcrumbs>
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Музыка қосу</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item">
                            <a :href="route('admin.index')">
                                <i class="fas fa-dashboard"></i>
                                Басты бет
                            </a>
                        </li>
                        <li class="breadcrumb-item">
                            <a :href="route('admin.musics.index')">
                                <i class="fas fa-dashboard"></i>
                                Музыкалар тізімі
                            </a>
                        </li>
                        <li class="breadcrumb-item active">
                            Музыка қосу
                        </li>
                    </ol>
                </div>
            </div>
        </template>
        <div class="container-fluid">
            <div class="card card-primary">
                <form method="post" @submit.prevent="submit">
                    <div class="card-body">
                        <div class="form-group">
                            <label for="">Аты</label>
                            <input type="text" class="form-control" v-model="music.title" name="title" />
                        </div>
                        <div class="form-group">
                            <label for="">Орындаушы</label>
                            <input type="text" class="form-control" v-model="music.artist" name="artist" />
                        </div>
                        <div class="form-group">
                            <label for="">Альбомы</label>
                            <select class="form-control"  v-model="music.album_id">
                                <option v-for="album in albums"
                                    :value="album.id">
                                    {{ album.title }}
                                </option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="">Жанры</label>
                            <input type="text" class="form-control" v-model="music.genre" name="genre" />
                        </div>
                        <div class="form-group">
                            <label for="">Файлы</label>
                            <input type="file" class="form-control" required @change="handleFileChange" name="file" />
                        </div>
                    </div>
                    <div class="card-footer">
                        <button type="submit" class="btn btn-primary mr-1">
                            Сақтау
                        </button>
                        <button type="button" class="btn btn-danger" @click.prevent="back()">
                            Артқа
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </AdminLayout>
</template>
<script>
import AdminLayout from "../../../Layouts/AdminLayout.vue";
import { Link, Head } from "@inertiajs/inertia-vue3";
import Pagination from "../../../Components/Pagination.vue";
import ValidationError from "../../../Components/ValidationError.vue";

export default {
    components: {
        AdminLayout,
        Link,
        Pagination,
        ValidationError,
        Head
    },
    props: ["albums"],
    data() {
        return {
            music: {
                album_id: this.albums[0].id,
            }
        }
    },
    created() {
        this.$store.dispatch('fetchUser');
    },
    computed: {
        userData() {
            return this.$store.getters.getUserData.user;
        }
    },
    methods: {
        handleFileChange(event) {
            const file = event.target.files[0];
            this.music.file = file;
        },
        submit() {
            this.$inertia.post(
                route("admin.musics.store"),
                this.music,
                {
                    onError: () => console.log("An error has occurred"),
                    onSuccess: () =>
                        console.log("The new contact has been saved"),
                }
            );
        },
    },
};
</script>
