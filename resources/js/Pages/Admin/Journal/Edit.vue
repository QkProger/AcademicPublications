<template>

    <head>
        <title>Админ панель | Журналды өңдеу</title>
    </head>
    <AdminLayout>
        <template #breadcrumbs>
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Журналды өңдеу</h1>
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
                            <a :href="route('admin.journals.index')">
                                <i class="fas fa-dashboard"></i>
                                Журналдар тізімі
                            </a>
                        </li>
                        <li class="breadcrumb-item active">
                            Журналды өңдеу
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
                            <input type="text" class="form-control" v-model="journal.name" name="name" />
                        </div>
                        <div class="form-group">
                            <label for="">Импакт-фактор</label>
                            <input type="text" class="form-control" v-model="journal.impact_factor" name="impact_factor" />
                        </div>
                        <div class="form-group">
                            <label for="">issn</label>
                            <input type="text" class="form-control" v-model="journal.issn" name="issn" />
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
        'journal',
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
            this.journal["_method"] = "put";
            this.$inertia.post(
                route("admin.journals.update", this.journal.id),
                this.journal,
                {
                    FormData:true,
                }
            );
        },
    },
};
</script>
