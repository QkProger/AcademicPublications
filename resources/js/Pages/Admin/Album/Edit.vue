<template>

    <head>
        <title>Админ панель | Альбомды өңдеу</title>
    </head>
    <AdminLayout>
        <template #breadcrumbs>
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Альбомды өңдеу</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item">
                            <a :href="route('admin.index')">
                                <i class="fas fa-dashboard"></i>
                                {{ userData.lang_code == 'kz' ? 'Басты бет' : 'Ana sayfa' }}
                            </a>
                        </li>
                        <li class="breadcrumb-item">
                            <a :href="route('admin.albums.index')">
                                <i class="fas fa-dashboard"></i>
                                Альбомдар тізімі
                            </a>
                        </li>
                        <li class="breadcrumb-item active">
                            Альбомды өңдеу
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
                            <input type="text" class="form-control" v-model="album.title" name="title" />
                        </div>
                    </div>
                    <div class="card-footer">
                        <button type="submit" class="btn btn-primary mr-1">
                            {{ userData.lang_code == 'kz' ? 'Сақтау' : 'Kaydet' }}
                        </button>
                        <button type="button" class="btn btn-danger" @click.prevent="back()">
                            {{ userData.lang_code == 'kz' ? 'Артқа' : 'Dönüş' }}
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
    props: [
        'album',
    ],
    created() {
        this.$store.dispatch('fetchUser');
    },
    computed: {
        userData() {
            return this.$store.getters.getUserData.user;
        }
    },
    methods: {
        submit() {
            this.album["_method"] = "put";
            this.$inertia.post(
                route("admin.albums.update", this.album.id),
                this.album,
                {
                    FormData:true,
                }
            );
        },
    },
};
</script>
